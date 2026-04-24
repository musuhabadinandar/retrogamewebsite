<?php
declare(strict_types=1);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$pdo = webarcade_pdo();
$user = webarcade_require_user();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $gameId = isset($_GET['game_id']) && is_string($_GET['game_id']) ? $_GET['game_id'] : '';
    if (!webarcade_valid_game_id($gameId)) {
        webarcade_json_response(['ok' => false, 'error' => 'Invalid game id.'], 422);
    }

    $query = $pdo->prepare(
        'SELECT storage_json, revision, updated_at
         FROM webarcade_cloud_saves
         WHERE user_id = :user_id AND game_id = :game_id
         LIMIT 1'
    );
    $query->execute([
        'user_id' => $user['id'],
        'game_id' => $gameId,
    ]);
    $row = $query->fetch();

    webarcade_json_response([
        'ok' => true,
        'authenticated' => true,
        'gameId' => $gameId,
        'revision' => $row ? (int) $row['revision'] : 0,
        'updatedAt' => $row['updated_at'] ?? null,
        'storageData' => $row ? json_decode((string) $row['storage_json'], true) : [],
    ]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    webarcade_json_response(['ok' => false, 'error' => 'Method not allowed.'], 405);
}

webarcade_validate_csrf();

$input = webarcade_json_input();
$action = isset($input['action']) && is_string($input['action']) ? $input['action'] : 'save';
$gameId = isset($input['game_id']) && is_string($input['game_id']) ? $input['game_id'] : '';
$storageData = $input['storageData'] ?? [];

if (!webarcade_valid_game_id($gameId)) {
    webarcade_json_response(['ok' => false, 'error' => 'Invalid game id.'], 422);
}

if ($action === 'clear') {
    $delete = $pdo->prepare(
        'DELETE FROM webarcade_cloud_saves
         WHERE user_id = :user_id AND game_id = :game_id'
    );
    $delete->execute([
        'user_id' => $user['id'],
        'game_id' => $gameId,
    ]);

    webarcade_json_response([
        'ok' => true,
        'authenticated' => true,
        'gameId' => $gameId,
        'revision' => 0,
        'updatedAt' => null,
        'savedKeys' => 0,
        'message' => 'Cloud save cleared.',
    ]);
}

if (!is_array($storageData)) {
    webarcade_json_response(['ok' => false, 'error' => 'Invalid save payload.'], 422);
}

$normalized = [];
foreach ($storageData as $key => $value) {
    if (!is_string($key) || strlen($key) > 120) {
        continue;
    }

    if (!is_scalar($value) && $value !== null) {
        continue;
    }

    $normalized[$key] = $value === null ? '' : (string) $value;
}

$encoded = json_encode($normalized, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if ($encoded === false) {
    webarcade_json_response(['ok' => false, 'error' => 'Failed to encode save payload.'], 500);
}

if (strlen($encoded) > 2_000_000) {
    webarcade_json_response(['ok' => false, 'error' => 'Save payload is too large.'], 413);
}

$statement = $pdo->prepare(
    <<<SQL
    INSERT INTO webarcade_cloud_saves (user_id, game_id, storage_json, revision)
    VALUES (:user_id, :game_id, :storage_json, 1)
    ON DUPLICATE KEY UPDATE
        storage_json = VALUES(storage_json),
        revision = revision + 1,
        updated_at = CURRENT_TIMESTAMP
    SQL
);

$statement->execute([
    'user_id' => $user['id'],
    'game_id' => $gameId,
    'storage_json' => $encoded,
]);

$revisionQuery = $pdo->prepare(
    'SELECT revision, updated_at
     FROM webarcade_cloud_saves
     WHERE user_id = :user_id AND game_id = :game_id
     LIMIT 1'
);
$revisionQuery->execute([
    'user_id' => $user['id'],
    'game_id' => $gameId,
]);
$row = $revisionQuery->fetch();

webarcade_json_response([
    'ok' => true,
    'authenticated' => true,
    'gameId' => $gameId,
    'revision' => $row ? (int) $row['revision'] : 1,
    'updatedAt' => $row['updated_at'] ?? null,
    'savedKeys' => count($normalized),
]);
