<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require __DIR__ . '/../config.php';

$pdo = new PDO(
    "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
    $username,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);

$duplicateGroups = (int) $pdo->query('SELECT COUNT(*) FROM (SELECT game_url FROM games GROUP BY game_url HAVING COUNT(*) > 1) d')->fetchColumn();
if ($duplicateGroups > 0) {
    fwrite(STDERR, "Cannot add unique game_url_hash while duplicate game_url groups exist: {$duplicateGroups}\n");
    exit(1);
}

$columnExists = (int) $pdo->query("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'games' AND column_name = 'game_url_hash'")->fetchColumn();
if ($columnExists === 0) {
    $pdo->exec("ALTER TABLE games ADD COLUMN game_url_hash BINARY(32) GENERATED ALWAYS AS (UNHEX(SHA2(game_url, 256))) STORED AFTER game_url");
    echo "added_game_url_hash=1\n";
} else {
    echo "added_game_url_hash=0\n";
}

$indexExists = (int) $pdo->query("SELECT COUNT(*) FROM information_schema.statistics WHERE table_schema = DATABASE() AND table_name = 'games' AND index_name = 'ux_games_game_url_hash'")->fetchColumn();
if ($indexExists === 0) {
    $pdo->exec('ALTER TABLE games ADD UNIQUE INDEX ux_games_game_url_hash (game_url_hash)');
    echo "added_ux_games_game_url_hash=1\n";
} else {
    echo "added_ux_games_game_url_hash=0\n";
}

echo 'games=' . (int) $pdo->query('SELECT COUNT(*) FROM games')->fetchColumn() . "\n";
echo 'duplicate_game_url_groups=' . $duplicateGroups . "\n";

