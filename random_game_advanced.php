<?php
// random_game_advanced.php
header('Content-Type: text/html; charset=utf-8');

include_once("config.php");
require_once __DIR__ . "/common-file/php/game_helpers.php";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// 获取所有分类
$categories = $pdo->query("SELECT id, category_name FROM categories ORDER BY sort_order")->fetchAll(PDO::FETCH_ASSOC);

// 处理分类筛选
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// 获取随机游戏
try {
    if ($category_id > 0) {
        // 按分类随机
        $query = "SELECT g.* FROM games g 
                  JOIN game_category gc ON g.id = gc.game_id 
                  WHERE gc.category_id = ? 
                  ORDER BY RAND() 
                  LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$category_id]);
    } else {
        // 全局随机
        $query = "SELECT g.* FROM games g ORDER BY RAND() LIMIT 1";
        $stmt = $pdo->query($query);
    }
    
    $randomGame = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($randomGame) {
        // 更新点击次数
        $updateStmt = $pdo->prepare("UPDATE games SET clicks = clicks + 1 WHERE id = ?");
        $updateStmt->execute([$randomGame['id']]);
        
        // 记录详细点击统计
        $statsStmt = $pdo->prepare("INSERT INTO click_stats (game_id, game_name, ip_address, user_agent, referrer) VALUES (?, ?, ?, ?, ?)");
        $statsStmt->execute([
            $randomGame['id'],
            $randomGame['name'],
            $_SERVER['REMOTE_ADDR'] ?? '',
            $_SERVER['HTTP_USER_AGENT'] ?? '',
            $_SERVER['HTTP_REFERER'] ?? 'random_game.php'
        ]);
    }
    
} catch (PDOException $e) {
    die("Failed to fetch a random game: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Random Picker - Retro Library</title>
    <link rel="shortcut icon" href="common-file/img/ilove-logo-6.png">
    <link href="common-file/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .category-selector {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
        }
        .category-btn {
            margin: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- 分类选择器 -->
                <div class="category-selector text-center">
                    <h5>🎯 Choose a Game Category</h5>
                    <div class="mt-3">
                        <a href="random_game_advanced.php" class="btn btn-primary category-btn">
                            All Games
                        </a >
                        <?php foreach ($categories as $category): ?>
                            <a href="random_game_advanced.php?category=<?= $category['id'] ?>" 
                               class="btn btn-outline-primary category-btn">
                                <?= htmlspecialchars($category['category_name']) ?>
                            </a >
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- 随机游戏显示 -->
                <?php if ($randomGame): ?>
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h3 class="card-title"><?= htmlspecialchars($randomGame['name']) ?></h3>
                            <img src="<?= htmlspecialchars(resolve_game_image_url($randomGame)) ?>" 
                                 class="img-fluid rounded mt-3" 
                                 style="max-height: 200px;"
                                 loading="eager"
                                 decoding="async"
                                 onerror="this.onerror=null;this.src='common-file/img/default-game.jpg'">
                            
                            <div class="mt-4">
                                <a href="<?= htmlspecialchars($randomGame['game_url']) ?>" 
                                   class="btn btn-success btn-lg" 
                                   target="_blank">
                                    🎮 Start Game
                                </a >
                                <a href="random_game_advanced.php<?= $category_id ? '?category=' . $category_id : '' ?>" 
                                   class="btn btn-primary btn-lg">
                                    🔄 Pick Another
                                </a >
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning text-center">
                        No games are available in this category yet.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
