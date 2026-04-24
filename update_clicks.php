<?php
header('Content-Type: application/json');

include_once("config.php");

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

$gameId = isset($_POST['game_id']) ? (int) $_POST['game_id'] : 0;
$gameName = isset($_POST['game_name']) ? trim($_POST['game_name']) : '';

if ($gameId <= 0 && $gameName === '') {
    echo json_encode(['success' => false, 'error' => 'Game identifier cannot be empty']);
    exit;
}

try {
    if ($gameId > 0) {
        $stmt = $pdo->prepare("SELECT id, name FROM games WHERE id = ?");
        $stmt->execute([$gameId]);
    } else {
        $stmt = $pdo->prepare("SELECT id, name FROM games WHERE name = ? LIMIT 1");
        $stmt->execute([$gameName]);
    }

    $game = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$game) {
        echo json_encode(['success' => false, 'error' => 'Game not found']);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE games SET clicks = clicks + 1 WHERE id = ?");
    $stmt->execute([$game['id']]);

    $stmt = $pdo->prepare(
        "INSERT INTO click_stats (game_id, game_name, ip_address, user_agent, referrer)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->execute([
        $game['id'],
        $game['name'],
        $_SERVER['REMOTE_ADDR'] ?? '',
        $_SERVER['HTTP_USER_AGENT'] ?? '',
        $_SERVER['HTTP_REFERER'] ?? '',
    ]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Update failed: ' . $e->getMessage()]);
}
?>
