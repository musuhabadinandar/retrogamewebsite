<?php
declare(strict_types=1);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$pdo = webarcade_pdo();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user = webarcade_require_user();

    if (isset($_GET['export']) && $_GET['export'] === '1') {
        $payload = webarcade_build_user_export_payload($pdo, (int) $user['id'], (string) $user['username']);
        webarcade_send_json_download($payload, 'webarcade-saves-' . $user['username'] . '.json');
    }

    $query = $pdo->prepare(
        'SELECT game_id, revision, updated_at, storage_json
         FROM webarcade_cloud_saves
         WHERE user_id = :user_id
         ORDER BY updated_at DESC, id DESC'
    );
    $query->execute(['user_id' => $user['id']]);
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
        ];
    }

    webarcade_json_response([
        'ok' => true,
        'authenticated' => true,
        'user' => $user,
        'csrfToken' => webarcade_csrf_token(),
        'saveCount' => count($saves),
        'exportUrl' => 'api/account.php?export=1',
        'saves' => $saves,
    ]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    webarcade_json_response([
        'ok' => false,
        'error' => 'Method not allowed.',
    ], 405);
}

$user = webarcade_require_user();
webarcade_validate_csrf();

$input = webarcade_json_input();
$action = isset($input['action']) && is_string($input['action']) ? $input['action'] : '';

if ($action !== 'change_password') {
    webarcade_json_response([
        'ok' => false,
        'error' => 'Unknown account action.',
    ], 400);
}

$currentPassword = isset($input['currentPassword']) && is_string($input['currentPassword']) ? $input['currentPassword'] : '';
$newPassword = isset($input['newPassword']) && is_string($input['newPassword']) ? $input['newPassword'] : '';

if ($currentPassword === '') {
    webarcade_json_response([
        'ok' => false,
        'error' => 'Current password is required.',
    ], 422);
}

if ($passwordError = webarcade_validate_password($newPassword)) {
    webarcade_json_response([
        'ok' => false,
        'error' => $passwordError,
    ], 422);
}

$query = $pdo->prepare(
    'SELECT password_hash
     FROM webarcade_users
     WHERE id = :user_id
     LIMIT 1'
);
$query->execute(['user_id' => $user['id']]);
$row = $query->fetch();

if (!$row || !password_verify($currentPassword, (string) $row['password_hash'])) {
    webarcade_json_response([
        'ok' => false,
        'error' => 'Current password is incorrect.',
    ], 401);
}

if (password_verify($newPassword, (string) $row['password_hash'])) {
    webarcade_json_response([
        'ok' => false,
        'error' => 'Choose a different password.',
    ], 422);
}

$update = $pdo->prepare(
    'UPDATE webarcade_users
     SET password_hash = :password_hash
     WHERE id = :user_id'
);
$update->execute([
    'password_hash' => password_hash($newPassword, PASSWORD_DEFAULT),
    'user_id' => $user['id'],
]);

session_regenerate_id(true);

webarcade_json_response([
    'ok' => true,
    'authenticated' => true,
    'user' => $user,
    'csrfToken' => webarcade_csrf_token(),
    'message' => 'Password updated successfully.',
]);
