<?php
// random_game.php
header('Content-Type: text/html; charset=utf-8');

include_once("config.php");
require_once __DIR__ . "/common-file/php/game_helpers.php";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// 获取随机游戏
try {
    // 方法1: 使用RAND()函数（适合数据量不大的情况）
    $query = "SELECT g.* FROM games g 
              ORDER BY RAND() 
              LIMIT 1";
    
    // 方法2: 使用更高效的方式（适合数据量大的情况）
    // $query = "SELECT g.* FROM games g 
    //           JOIN (SELECT CEIL(RAND() * (SELECT MAX(id) FROM games)) AS random_id) AS temp
    //           WHERE g.id >= temp.random_id
    //           ORDER BY g.id ASC
    //           LIMIT 1";
    
    $stmt = $pdo->query($query);
    $randomGame = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$randomGame) {
        die("No playable game was found.");
    }
    
    // 更新点击次数
    $updateStmt = $pdo->prepare("UPDATE games SET clicks = clicks + 1 WHERE id = ?");
    $updateStmt->execute([$randomGame['id']]);
    
    // 记录详细点击统计（可选）
    $statsStmt = $pdo->prepare("INSERT INTO click_stats (game_id, game_name, ip_address, user_agent, referrer) VALUES (?, ?, ?, ?, ?)");
    $statsStmt->execute([
        $randomGame['id'],
        $randomGame['name'],
        $_SERVER['REMOTE_ADDR'] ?? '',
        $_SERVER['HTTP_USER_AGENT'] ?? '',
        $_SERVER['HTTP_REFERER'] ?? 'random_game.php'
    ]);
    
} catch (PDOException $e) {
    die("Failed to fetch a random game: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Game Picker - Retro Library</title>
    <link rel="shortcut icon" href="common-file/img/ilove-logo-6.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Microsoft YaHei', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 600px;
            width: 100%;
            animation: fadeIn 0.8s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .game-image {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 12px;
            margin: 20px auto;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }
        
        .game-image:hover {
            transform: scale(1.05);
        }
        
        .game-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
            line-height: 1.4;
        }
        
        .game-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            font-size: 14px;
            color: #666;
        }
        
        .play-button {
            display: inline-block;
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            box-shadow: 0 8px 25px rgba(110, 142, 251, 0.3);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .play-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(110, 142, 251, 0.4);
            color: white;
            text-decoration: none;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .btn-primary {
            background: #6e8efb;
            color: white;
        }
        
        .btn-outline {
            background: transparent;
            color: #6e8efb;
            border-color: #6e8efb;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .loading {
            display: none;
            font-size: 18px;
            color: #666;
            margin: 20px 0;
        }
        
        .countdown {
            font-size: 14px;
            color: #999;
            margin-top: 10px;
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 20px;
                margin: 10px;
            }
            
            .game-title {
                font-size: 20px;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="color: #6e8efb; margin-bottom: 10px;">🎮 Random Game Discovery</h1>
        <p style="color: #666; margin-bottom: 20px;">A surprise pick is ready for you.</p >
        
        <?php if ($randomGame): ?>
            <img src="<?= htmlspecialchars(resolve_game_image_url($randomGame)) ?>" 
                 alt="<?= htmlspecialchars($randomGame['name']) ?>" 
                 class="game-image"
                 loading="eager"
                 decoding="async"
                 onerror="this.onerror=null;this.src='common-file/img/default-game.jpg'">
            
            <div class="game-title"><?= htmlspecialchars($randomGame['name']) ?></div>
            
            <div class="game-info">
                <div>🔥 Plays: <?= number_format($randomGame['clicks'] + 1) ?></div>
                <div>📅 Selected at: <?= date('Y-m-d H:i:s') ?></div>
            </div>
            
            <div class="loading" id="loading">
                Loading the game, please wait...
            </div>
            
            <a href="<?= htmlspecialchars($randomGame['game_url']) ?>" 
               class="play-button" 
               target="_blank"
               onclick="showLoading()"
               id="playLink">
                🎯 Start Playing Now
            </a >
            
            <div class="countdown" id="countdown"></div>
            
            <div class="action-buttons">
                <a href="/" class="btn btn-outline">🏠 Back to Home</a >
                <a href="random_game.php" class="btn btn-primary">🔄 Pick Another</a >
            </div>
        <?php else: ?>
            <div style="color: #ff4757; font-size: 18px; margin: 40px 0;">
                😔 No playable game is available right now.
            </div>
            <a href="/" class="btn btn-primary">Back to Home</a >
        <?php endif; ?>
    </div>

    <script>
        function showLoading() {
            document.getElementById('loading').style.display = 'block';
            document.getElementById('playLink').style.opacity = '0.7';
            
            // 倒计时重定向
            let countdown = 3;
            const countdownElement = document.getElementById('countdown');
            countdownElement.style.display = 'block';
            
            const timer = setInterval(function() {
                countdownElement.textContent = `Opening in ${countdown} seconds...`;
                countdown--;
                
                if (countdown < 0) {
                    clearInterval(timer);
                    countdownElement.textContent = 'Opening game...';
                }
            }, 1000);
        }
        
        // 自动点击（可选功能）
        // setTimeout(function() {
        //     document.getElementById('playLink').click();
        // }, 3000);
        
        // 添加键盘快捷键
        document.addEventListener('keydown', function(event) {
            // 按空格键或回车键重新随机
            if (event.code === 'Space' || event.code === 'Enter') {
                event.preventDefault();
                window.location.href = 'random_game.php';
            }
            
            // 按ESC键返回首页
            if (event.code === 'Escape') {
                window.location.href = '/';
            }
        });
        
        // 页面加载完成后的动画
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.game-title, .game-image, .play-button');
            elements.forEach((element, index) => {
                element.style.animationDelay = (index * 0.2) + 's';
            });
        });
    </script>
</body>
</html>
