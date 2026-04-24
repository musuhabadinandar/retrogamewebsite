<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require __DIR__ . '/../config.php';
require_once __DIR__ . '/../common-file/php/game_helpers.php';

$pdo = new PDO(
    "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
    $username,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);

function scalar(PDO $pdo, string $sql): int
{
    return (int) $pdo->query($sql)->fetchColumn();
}

function local_game_file_exists(string $gameUrl): bool
{
    $path = parse_url($gameUrl, PHP_URL_PATH);
    $query = parse_url($gameUrl, PHP_URL_QUERY);
    if (!is_string($path) || !is_string($query)) {
        return true;
    }

    $system = strtok(trim($path, '/'), '/');
    if (!in_array($system, ['fc', 'gba', 'gb', 'ps1', 'mame'], true)) {
        return true;
    }

    parse_str($query, $params);
    $file = isset($params['file']) && is_string($params['file']) ? $params['file'] : '';
    if ($file === '' && isset($params['f']) && is_string($params['f'])) {
        $file = decode_legacy_game_file($params['f']);
    }
    if (has_unsafe_game_file_path($file)) {
        return false;
    }

    $candidate = game_site_root() . DIRECTORY_SEPARATOR . $system . DIRECTORY_SEPARATOR . 'games' . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, str_replace('\\', '/', $file));
    return is_file($candidate);
}

$counts = [
    'games' => scalar($pdo, 'SELECT COUNT(*) FROM games'),
    'categories' => scalar($pdo, 'SELECT COUNT(*) FROM categories'),
    'game_category' => scalar($pdo, 'SELECT COUNT(*) FROM game_category'),
    'duplicate_game_url_groups' => scalar($pdo, 'SELECT COUNT(*) FROM (SELECT game_url FROM games GROUP BY game_url HAVING COUNT(*) > 1) d'),
    'missing_game_url_hash' => scalar($pdo, "SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'games' AND column_name = 'game_url_hash'") === 1 ? scalar($pdo, 'SELECT COUNT(*) FROM games WHERE game_url_hash IS NULL') : -1,
    'orphan_game_links' => scalar($pdo, 'SELECT COUNT(*) FROM game_category gc LEFT JOIN games g ON g.id = gc.game_id WHERE g.id IS NULL'),
    'orphan_category_links' => scalar($pdo, 'SELECT COUNT(*) FROM game_category gc LEFT JOIN categories c ON c.id = gc.category_id WHERE c.id IS NULL'),
];

$missingLocalImages = 0;
$remoteImages = 0;
$missingLocalGames = 0;
$checkedLocalGames = 0;

$stmt = $pdo->query('SELECT id, name, game_url, image_url FROM games ORDER BY id ASC');
foreach ($stmt as $game) {
    $imageUrl = (string) ($game['image_url'] ?? '');
    if ($imageUrl !== '' && (preg_match('#^https?://#i', $imageUrl) || str_starts_with($imageUrl, '//'))) {
        $remoteImages++;
    } elseif ($imageUrl !== '' && $imageUrl !== '/common-file/img/default-game.jpg' && !is_file(local_path_from_url($imageUrl))) {
        $missingLocalImages++;
    }

    $gamePath = parse_url((string) $game['game_url'], PHP_URL_PATH);
    $system = is_string($gamePath) ? strtok(trim($gamePath, '/'), '/') : '';
    if (in_array($system, ['fc', 'gba', 'gb', 'ps1', 'mame'], true)) {
        $checkedLocalGames++;
        if (!local_game_file_exists((string) $game['game_url'])) {
            $missingLocalGames++;
        }
    }
}

foreach ($counts as $key => $value) {
    echo "{$key}={$value}\n";
}
echo "remote_images={$remoteImages}\n";
echo "missing_local_images={$missingLocalImages}\n";
echo "checked_local_games={$checkedLocalGames}\n";
echo "missing_local_game_files={$missingLocalGames}\n";

$hasFailure = $counts['duplicate_game_url_groups'] > 0
    || $counts['orphan_game_links'] > 0
    || $counts['orphan_category_links'] > 0
    || $missingLocalGames > 0;

echo 'status=' . ($hasFailure ? 'FAIL' : 'PASS') . "\n";
exit($hasFailure ? 1 : 0);

