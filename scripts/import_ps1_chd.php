<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require __DIR__ . '/../config.php';

if ($argc < 2) {
    fwrite(STDERR, "Usage: php scripts/import_ps1_chd.php <source-chd-file> [collection-slug] [display-name]\n");
    exit(1);
}

$sourceFile = $argv[1];
$collectionSlug = $argv[2] ?? '_ps1_trial';
$displayName = $argv[3] ?? '';
$siteRoot = realpath(__DIR__ . '/..');

if ($siteRoot === false) {
    fwrite(STDERR, "Unable to resolve site root.\n");
    exit(1);
}

if (!preg_match('/^[A-Za-z0-9_-]+$/', $collectionSlug)) {
    fwrite(STDERR, "Collection slug may only contain letters, numbers, underscores, and dashes.\n");
    exit(1);
}

if (!is_file($sourceFile)) {
    fwrite(STDERR, "Source CHD file not found: {$sourceFile}\n");
    exit(1);
}

if (strtolower(pathinfo($sourceFile, PATHINFO_EXTENSION)) !== 'chd') {
    fwrite(STDERR, "Only .chd files are supported by this initial PS1 importer.\n");
    exit(1);
}

function display_name_from_ps1_file(string $filename): string
{
    $name = pathinfo($filename, PATHINFO_FILENAME);
    $name = str_replace(['_', '.'], ' ', $name);
    $name = preg_replace('/\s+/u', ' ', $name) ?? $name;
    $name = trim($name);

    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
        return mb_strlen($name, 'UTF-8') > 250 ? mb_substr($name, 0, 250, 'UTF-8') : $name;
    }

    return strlen($name) > 250 ? substr($name, 0, 250) : $name;
}

function bucket_key_for_ps1_name(string $name): string
{
    if (preg_match('/[A-Za-z0-9]/', $name, $matches)) {
        $char = strtoupper($matches[0]);
        if (ctype_digit($char)) {
            return '0-9';
        }
        if ($char >= 'A' && $char <= 'Z') {
            return $char;
        }
    }

    return 'Other';
}

function ps1_url_from_relative_path(string $relativePath): string
{
    $segments = explode('/', str_replace('\\', '/', $relativePath));
    return implode('/', array_map('rawurlencode', $segments));
}

function ensure_ps1_category(PDO $pdo, string $name): int
{
    $select = $pdo->prepare('SELECT id FROM categories WHERE category_name = :name LIMIT 1');
    $select->execute([':name' => $name]);
    $existing = $select->fetchColumn();
    if ($existing !== false) {
        return (int) $existing;
    }

    $insert = $pdo->prepare('INSERT INTO categories (category_name) VALUES (:name)');
    $insert->execute([':name' => $name]);
    return (int) $pdo->lastInsertId();
}

function link_ps1_game_category(PDO $pdo, int $gameId, int $categoryId): void
{
    $stmt = $pdo->prepare('INSERT IGNORE INTO game_category (game_id, category_id) VALUES (:game_id, :category_id)');
    $stmt->execute([
        ':game_id' => $gameId,
        ':category_id' => $categoryId,
    ]);
}

$pdo = new PDO(
    "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
    $username,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);

$displayName = trim($displayName) !== '' ? trim($displayName) : display_name_from_ps1_file(basename($sourceFile));
$bucket = bucket_key_for_ps1_name($displayName);
$targetRoot = $siteRoot . DIRECTORY_SEPARATOR . 'ps1' . DIRECTORY_SEPARATOR . 'games' . DIRECTORY_SEPARATOR . $collectionSlug . DIRECTORY_SEPARATOR . $bucket;

if (!is_dir($targetRoot) && !mkdir($targetRoot, 0777, true) && !is_dir($targetRoot)) {
    fwrite(STDERR, "Unable to create target folder: {$targetRoot}\n");
    exit(1);
}

$targetName = basename($sourceFile);
$targetPath = $targetRoot . DIRECTORY_SEPARATOR . $targetName;
if (!is_file($targetPath)) {
    if (!copy($sourceFile, $targetPath)) {
        fwrite(STDERR, "Failed to copy {$sourceFile} to {$targetPath}\n");
        exit(1);
    }
}

$relativeGameFile = $collectionSlug . '/' . $bucket . '/' . $targetName;
$gameUrl = '/ps1/play.html?file=' . ps1_url_from_relative_path($relativeGameFile);
$imageUrl = '/common-file/img/default-game.jpg';

$pdo->beginTransaction();
try {
    $parentCategoryId = ensure_ps1_category($pdo, 'PS1');
    $bucketCategoryId = ensure_ps1_category($pdo, 'PS1 ' . $bucket);

    $selectGame = $pdo->prepare('SELECT id FROM games WHERE game_url = :game_url LIMIT 1');
    $selectGame->execute([':game_url' => $gameUrl]);
    $gameId = (int) $selectGame->fetchColumn();

    if ($gameId <= 0) {
        $insertGame = $pdo->prepare(
            'INSERT INTO games (name, game_url, image_url, clicks) VALUES (:name, :game_url, :image_url, 0)'
        );
        $insertGame->execute([
            ':name' => $displayName,
            ':game_url' => $gameUrl,
            ':image_url' => $imageUrl,
        ]);
        $gameId = (int) $pdo->lastInsertId();
    }

    link_ps1_game_category($pdo, $gameId, $parentCategoryId);
    link_ps1_game_category($pdo, $gameId, $bucketCategoryId);

    $pdo->commit();
} catch (Throwable $exception) {
    $pdo->rollBack();
    fwrite(STDERR, "Import failed: {$exception->getMessage()}\n");
    exit(1);
}

echo "Source: {$sourceFile}\n";
echo "Target: {$targetPath}\n";
echo "Game URL: {$gameUrl}\n";
echo "Game ID: {$gameId}\n";
echo "Categories: PS1, PS1 {$bucket}\n";

