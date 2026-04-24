<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require __DIR__ . '/../config.php';

$sourceRoot = $argv[1] ?? 'C:\\Users\\arishat\\Downloads\\Compressed\\KUMPULAN ROM NES NANDAR';
$collectionSlug = $argv[2] ?? '_nes_nandar';
$sourceRoot = rtrim($sourceRoot, "\\/");
$siteRoot = realpath(__DIR__ . '/..');

if (!preg_match('/^[A-Za-z0-9_-]+$/', $collectionSlug)) {
    fwrite(STDERR, "Collection slug may only contain letters, numbers, underscores, and dashes.\n");
    exit(1);
}

if ($siteRoot === false) {
    fwrite(STDERR, "Unable to resolve site root.\n");
    exit(1);
}

if (!is_dir($sourceRoot)) {
    fwrite(STDERR, "Source folder not found: {$sourceRoot}\n");
    exit(1);
}

$targetRoot = $siteRoot . DIRECTORY_SEPARATOR . 'fc' . DIRECTORY_SEPARATOR . 'games' . DIRECTORY_SEPARATOR . $collectionSlug;
$imageUrl = '/common-file/img/default-nes.svg';
$supportedExtensions = ['nes' => true, 'unf' => true, 'unif' => true, 'fds' => true];

$pdo = new PDO(
    "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
    $username,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);

function normalize_slashes(string $value): string
{
    return str_replace('\\', '/', $value);
}

function display_name_from_file(string $filename): string
{
    $name = pathinfo($filename, PATHINFO_FILENAME);
    $name = str_replace(['_', '.'], ' ', $name);
    $name = preg_replace('/\s+/u', ' ', $name) ?? $name;
    return trim($name);
}

function bucket_key_for_name(string $name): string
{
    if (preg_match('/[A-Za-z0-9]/', $name, $matches, PREG_OFFSET_CAPTURE)) {
        $char = strtoupper($matches[0][0]);
        if (ctype_digit($char)) {
            return '0-9';
        }
        if ($char >= 'A' && $char <= 'Z') {
            return $char;
        }
    }

    return 'Other';
}

function url_from_relative_path(string $relativePath): string
{
    $segments = explode('/', normalize_slashes($relativePath));
    return implode('/', array_map('rawurlencode', $segments));
}

function unique_target_name(string $bucketDir, string $basename, string $relativeSource): string
{
    $name = pathinfo($basename, PATHINFO_FILENAME);
    $extension = pathinfo($basename, PATHINFO_EXTENSION);
    $candidate = $basename;
    $counter = 1;

    while (is_file($bucketDir . DIRECTORY_SEPARATOR . $candidate)) {
        $suffix = substr(sha1($relativeSource . '|' . $counter), 0, 8);
        $candidate = $name . '--' . $suffix . ($extension !== '' ? '.' . $extension : '');
        $counter++;
    }

    return $candidate;
}

function ensure_category(PDO $pdo, string $name): int
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

function link_game_category(PDO $pdo, int $gameId, int $categoryId): void
{
    $stmt = $pdo->prepare('INSERT IGNORE INTO game_category (game_id, category_id) VALUES (:game_id, :category_id)');
    $stmt->execute([
        ':game_id' => $gameId,
        ':category_id' => $categoryId,
    ]);
}

function backup_current_catalog(PDO $pdo, string $siteRoot, string $collectionSlug): string
{
    $backupName = trim($collectionSlug, '_-');
    $backupName = $backupName !== '' ? $backupName : 'nes';
    $backupPath = (getenv('NANDAR_IMPORT_BACKUP_DIR') ?: 'C:\\laragon\\private\\import_backups') . DIRECTORY_SEPARATOR . 'nes_import_' . $backupName . '_backup_' . date('Ymd_His') . '.json';
    $payload = [
        'generated_at' => date(DATE_ATOM),
        'tables' => [],
    ];

    foreach (['categories', 'games', 'game_category'] as $table) {
        $payload['tables'][$table] = $pdo->query("SELECT * FROM {$table}")->fetchAll();
    }

    if (!is_dir(dirname($backupPath))) {
        mkdir(dirname($backupPath), 0777, true);
    }
    file_put_contents($backupPath, json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    return $backupPath;
}

function ensure_category_lookup_index(PDO $pdo): void
{
    $stmt = $pdo->prepare(
        "SELECT COUNT(*)
         FROM information_schema.statistics
         WHERE table_schema = DATABASE()
           AND table_name = 'game_category'
           AND index_name = 'idx_category_game'"
    );
    $stmt->execute();

    if ((int) $stmt->fetchColumn() === 0) {
        $pdo->exec('ALTER TABLE game_category ADD INDEX idx_category_game (category_id, game_id)');
    }
}

$roms = [];
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($sourceRoot, FilesystemIterator::SKIP_DOTS)
);

foreach ($iterator as $fileInfo) {
    if (!$fileInfo instanceof SplFileInfo || !$fileInfo->isFile()) {
        continue;
    }

    $extension = strtolower($fileInfo->getExtension());
    if (!isset($supportedExtensions[$extension])) {
        continue;
    }

    $fullPath = $fileInfo->getPathname();
    $relativeSource = ltrim(substr($fullPath, strlen($sourceRoot)), "\\/");
    $displayName = display_name_from_file($fileInfo->getFilename());
    $bucket = bucket_key_for_name($displayName);

    $roms[] = [
        'source' => $fullPath,
        'relative_source' => $relativeSource,
        'filename' => $fileInfo->getFilename(),
        'name' => $displayName,
        'bucket' => $bucket,
    ];
}

usort($roms, static function (array $a, array $b): int {
    return strcasecmp($a['name'], $b['name']);
});

$backupPath = backup_current_catalog($pdo, $siteRoot, $collectionSlug);
ensure_category_lookup_index($pdo);

$insertGame = $pdo->prepare(
    'INSERT INTO games (name, game_url, image_url, clicks) VALUES (:name, :game_url, :image_url, 0)'
);
$selectGame = $pdo->prepare('SELECT id FROM games WHERE game_url = :game_url LIMIT 1');

$inserted = 0;
$skippedExisting = 0;
$copied = 0;
$reusedFiles = 0;

if (!is_dir($targetRoot) && !mkdir($targetRoot, 0777, true) && !is_dir($targetRoot)) {
    fwrite(STDERR, "Unable to create target folder: {$targetRoot}\n");
    exit(1);
}

$pdo->beginTransaction();
try {
    $existingGameUrl = [];
    $selectExistingCollection = $pdo->prepare("SELECT game_url FROM games WHERE game_url LIKE :prefix");
    $selectExistingCollection->execute([
        ':prefix' => '/fc/play.html?file=' . rawurlencode($collectionSlug) . '/%',
    ]);
    $rows = $selectExistingCollection->fetchAll();
    foreach ($rows as $row) {
        $existingGameUrl[(string) $row['game_url']] = true;
    }

    $categoryIds = [];
    foreach (array_merge(['0-9'], range('A', 'Z'), ['Other']) as $bucket) {
        $categoryIds[$bucket] = ensure_category($pdo, 'NES ' . $bucket);
    }

    foreach ($roms as $rom) {
        $bucketDir = $targetRoot . DIRECTORY_SEPARATOR . $rom['bucket'];
        if (!is_dir($bucketDir) && !mkdir($bucketDir, 0777, true) && !is_dir($bucketDir)) {
            throw new RuntimeException("Unable to create bucket folder: {$bucketDir}");
        }

        $targetName = unique_target_name($bucketDir, $rom['filename'], $rom['relative_source']);
        $targetPath = $bucketDir . DIRECTORY_SEPARATOR . $targetName;
        $relativeGameFile = $collectionSlug . '/' . $rom['bucket'] . '/' . $targetName;
        $gameUrl = '/fc/play.html?file=' . url_from_relative_path($relativeGameFile);

        if (isset($existingGameUrl[$gameUrl])) {
            $selectGame->execute([':game_url' => $gameUrl]);
            $gameId = (int) $selectGame->fetchColumn();
            if ($gameId > 0) {
                link_game_category($pdo, $gameId, $categoryIds[$rom['bucket']]);
            }
            $skippedExisting++;
            continue;
        }

        if (is_file($targetPath)) {
            $reusedFiles++;
        } else {
            if (!copy($rom['source'], $targetPath)) {
                throw new RuntimeException("Failed to copy {$rom['source']} to {$targetPath}");
            }
            $copied++;
        }

        $insertGame->execute([
            ':name' => $rom['name'],
            ':game_url' => $gameUrl,
            ':image_url' => $imageUrl,
        ]);

        $gameId = (int) $pdo->lastInsertId();
        link_game_category($pdo, $gameId, $categoryIds[$rom['bucket']]);
        $existingGameUrl[$gameUrl] = true;
        $inserted++;
    }

    $pdo->commit();
} catch (Throwable $exception) {
    $pdo->rollBack();
    fwrite(STDERR, "Import failed: {$exception->getMessage()}\n");
    exit(1);
}

echo "Backup: {$backupPath}\n";
echo "Source: {$sourceRoot}\n";
echo "Target: {$targetRoot}\n";
echo "Playable ROMs found: " . count($roms) . "\n";
echo "Inserted games: {$inserted}\n";
echo "Skipped existing games: {$skippedExisting}\n";
echo "Copied files: {$copied}\n";
echo "Reused existing files: {$reusedFiles}\n";

