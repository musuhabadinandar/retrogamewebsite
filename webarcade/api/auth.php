<?php
declare(strict_types=1);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$pdo = webarcade_pdo();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    webarcade_json_response(webarcade_session_payload());
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    webarcade_json_response([
        'ok' => false,
        'error' => 'Method not allowed.',
    ], 405);
}

$input = webarcade_json_input();
$action = isset($input['action']) && is_string($input['action']) ? $input['action'] : '';

if ($action === 'logout') {
    webarcade_validate_csrf();
    $_SESSION = [];
    session_regenerate_id(true);
    webarcade_json_response([
        'ok' => true,
        'authenticated' => false,
        'user' => null,
        'csrfToken' => webarcade_csrf_token(),
    ]);
}

$username = isset($input['username']) && is_string($input['username']) ? trim($input['username']) : '';
$password = isset($input['password']) && is_string($input['password']) ? $input['password'] : '';

if ($usernameError = webarcade_validate_username($username)) {
    webarcade_json_response(['ok' => false, 'error' => $usernameError], 422);
}

if ($passwordError = webarcade_validate_password($password)) {
    webarcade_json_response(['ok' => false, 'error' => $passwordError], 422);
}

if ($action === 'register') {
    $check = $pdo->prepare('SELECT id FROM webarcade_users WHERE username = :username LIMIT 1');
    $check->execute(['username' => $username]);
    if ($check->fetch()) {
        webarcade_json_response(['ok' => false, 'error' => 'Username is already taken.'], 409);
    }

    $insert = $pdo->prepare(
        'INSERT INTO webarcade_users (username, password_hash) VALUES (:username, :password_hash)'
    );
    $insert->execute([
        'username' => $username,
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
    ]);

    $_SESSION['webarcade_user'] = [
        'id' => (int) $pdo->lastInsertId(),
        'username' => $username,
    ];
    session_regenerate_id(true);

    webarcade_json_response(webarcade_session_payload());
}

if ($action === 'login') {
    $query = $pdo->prepare(
        'SELECT id, username, password_hash FROM webarcade_users WHERE username = :username LIMIT 1'
    );
    $query->execute(['username' => $username]);
    $row = $query->fetch();

    if (!$row || !password_verify($password, (string) $row['password_hash'])) {
        webarcade_json_response(['ok' => false, 'error' => 'Invalid username or password.'], 401);
    }

    $_SESSION['webarcade_user'] = [
        'id' => (int) $row['id'],
        'username' => (string) $row['username'],
    ];
    session_regenerate_id(true);

    webarcade_json_response(webarcade_session_payload());
}

webarcade_json_response([
    'ok' => false,
    'error' => 'Unknown auth action.',
], 400);
