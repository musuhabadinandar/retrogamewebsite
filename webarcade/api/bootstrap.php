<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => false,
    ]);
    session_start();
}

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'config.php';

function webarcade_pdo(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    global $host, $dbname, $username, $password;

    try {
        $pdo = new PDO(
            "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );

        webarcade_ensure_schema($pdo);
        return $pdo;
    } catch (Throwable $exception) {
        if (PHP_SAPI === 'cli') {
            throw $exception;
        }

        webarcade_json_response([
            'ok' => false,
            'error' => 'Database connection failed.',
        ], 500);
    }
}

function webarcade_ensure_schema(PDO $pdo): void
{
    static $ready = false;

    if ($ready) {
        return;
    }

    $pdo->exec(
        <<<SQL
        CREATE TABLE IF NOT EXISTS webarcade_users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(32) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        SQL
    );

    $pdo->exec(
        <<<SQL
        CREATE TABLE IF NOT EXISTS webarcade_cloud_saves (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT UNSIGNED NOT NULL,
            game_id VARCHAR(16) NOT NULL,
            storage_json LONGTEXT NOT NULL,
            revision INT UNSIGNED NOT NULL DEFAULT 1,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY uniq_user_game (user_id, game_id),
            CONSTRAINT fk_webarcade_save_user
                FOREIGN KEY (user_id) REFERENCES webarcade_users(id)
                ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        SQL
    );

    $ready = true;
}

function webarcade_json_input(): array
{
    static $decoded = null;

    if (is_array($decoded)) {
        return $decoded;
    }

    $raw = file_get_contents('php://input');
    if ($raw === false || trim($raw) === '') {
        $decoded = [];
        return $decoded;
    }

    $parsed = json_decode($raw, true);
    $decoded = is_array($parsed) ? $parsed : [];
    return $decoded;
}

function webarcade_json_response(array $payload, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function webarcade_csrf_token(): string
{
    if (empty($_SESSION['webarcade_csrf'])) {
        $_SESSION['webarcade_csrf'] = bin2hex(random_bytes(16));
    }

    return (string) $_SESSION['webarcade_csrf'];
}

function webarcade_current_user(): ?array
{
    if (empty($_SESSION['webarcade_user']) || !is_array($_SESSION['webarcade_user'])) {
        return null;
    }

    return $_SESSION['webarcade_user'];
}

function webarcade_require_user(): array
{
    $user = webarcade_current_user();
    if ($user === null) {
        webarcade_json_response([
            'ok' => false,
            'error' => 'Authentication required.',
            'authenticated' => false,
        ], 401);
    }

    return $user;
}

function webarcade_validate_csrf(): void
{
    $input = webarcade_json_input();
    $headerToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    $bodyToken = $input['csrfToken'] ?? '';
    $postToken = $_POST['csrfToken'] ?? '';

    if (is_string($headerToken) && $headerToken !== '') {
        $token = $headerToken;
    } elseif (is_string($bodyToken) && $bodyToken !== '') {
        $token = $bodyToken;
    } else {
        $token = is_string($postToken) ? $postToken : '';
    }

    if ($token === '' || !hash_equals(webarcade_csrf_token(), $token)) {
        webarcade_json_response([
            'ok' => false,
            'error' => 'Invalid CSRF token.',
        ], 403);
    }
}

function webarcade_validate_username(string $username): ?string
{
    $trimmed = trim($username);
    if ($trimmed === '' || strlen($trimmed) < 3 || strlen($trimmed) > 32) {
        return 'Username must be between 3 and 32 characters.';
    }

    if (!preg_match('/^[A-Za-z0-9._-]+$/', $trimmed)) {
        return 'Username may only contain letters, numbers, dots, underscores, and dashes.';
    }

    return null;
}

function webarcade_validate_password(string $password): ?string
{
    if (strlen($password) < 6) {
        return 'Password must be at least 6 characters.';
    }

    if (strlen($password) > 128) {
        return 'Password is too long.';
    }

    return null;
}

function webarcade_valid_game_id(string $gameId): bool
{
    return (bool) preg_match('/^[0-9]{2}$/', $gameId);
}

function webarcade_session_payload(): array
{
    $user = webarcade_current_user();

    return [
        'ok' => true,
        'authenticated' => $user !== null,
        'user' => $user,
        'csrfToken' => webarcade_csrf_token(),
    ];
}

function webarcade_html(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function webarcade_games_index(): array
{
    static $index = null;

    if (is_array($index)) {
        return $index;
    }

    $index = [];
    $catalogPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'games.json';
    if (!is_file($catalogPath)) {
        return $index;
    }

    $raw = file_get_contents($catalogPath);
    if ($raw === false) {
        return $index;
    }

    $decoded = json_decode($raw, true);
    if (!is_array($decoded) || !isset($decoded['games']) || !is_array($decoded['games'])) {
        return $index;
    }

    foreach ($decoded['games'] as $game) {
        if (!is_array($game) || !isset($game['id']) || !is_string($game['id'])) {
            continue;
        }

        $index[$game['id']] = [
            'name' => isset($game['name']) && is_string($game['name']) ? $game['name'] : ('Game ' . $game['id']),
            'category' => isset($game['category']) && is_string($game['category']) ? $game['category'] : '',
            'hint' => isset($game['hint']) && is_string($game['hint']) ? $game['hint'] : '',
        ];
    }

    return $index;
}

function webarcade_build_user_export_payload(PDO $pdo, int $userId, string $username): array
{
    $query = $pdo->prepare(
        'SELECT game_id, storage_json, revision, updated_at
         FROM webarcade_cloud_saves
         WHERE user_id = :user_id
         ORDER BY updated_at DESC, id DESC'
    );
    $query->execute(['user_id' => $userId]);
    $rows = $query->fetchAll();

    $gamesIndex = webarcade_games_index();
    $saves = [];

    foreach ($rows as $row) {
        $gameId = isset($row['game_id']) && is_string($row['game_id']) ? $row['game_id'] : '';
        $gameMeta = $gamesIndex[$gameId] ?? ['name' => 'Unknown game', 'category' => '', 'hint' => ''];
        $decoded = json_decode((string) ($row['storage_json'] ?? '{}'), true);
        $storageData = is_array($decoded) ? $decoded : [];

        $saves[] = [
            'gameId' => $gameId,
            'gameName' => $gameMeta['name'],
            'category' => $gameMeta['category'],
            'hint' => $gameMeta['hint'],
            'revision' => isset($row['revision']) ? (int) $row['revision'] : 0,
            'updatedAt' => $row['updated_at'] ?? null,
            'savedKeys' => count($storageData),
            'storageData' => $storageData,
        ];
    }

    return [
        'generatedAt' => gmdate('c'),
        'module' => 'webarcade',
        'user' => [
            'id' => $userId,
            'username' => $username,
        ],
        'saveCount' => count($saves),
        'saves' => $saves,
    ];
}

function webarcade_send_json_download(array $payload, string $filename): never
{
    $safeFilename = preg_replace('/[^A-Za-z0-9._-]+/', '-', $filename) ?: 'webarcade-export.json';

    http_response_code(200);
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $safeFilename . '"');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}
