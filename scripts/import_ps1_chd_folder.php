<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require __DIR__ . '/../config.php';

$args = array_slice($argv, 1);
$dryRun = in_array('--dry-run', $args, true) || !in_array('--apply', $args, true);
$apply = in_array('--apply', $args, true);
$skipBackup = in_array('--skip-backup', $args, true);
$skipAudit = in_array('--skip-audit', $args, true);
$limit = null;
$offset = 0;
$minMb = null;
$maxMb = null;
$sortMode = 'name';
$positionals = [];

foreach ($args as $arg) {
    if (str_starts_with($arg, '--limit=')) {
        $value = substr($arg, strlen('--limit='));
        if (!ctype_digit($value) || (int) $value < 1) {
            fwrite(STDERR, "--limit must be a positive integer.\n");
            exit(1);
        }
        $limit = (int) $value;
        continue;
    }
    if (str_starts_with($arg, '--offset=')) {
        $value = substr($arg, strlen('--offset='));
        if (!ctype_digit($value)) {
            fwrite(STDERR, "--offset must be zero or a positive integer.\n");
            exit(1);
        }
        $offset = (int) $value;
        continue;
    }
    if (str_starts_with($arg, '--min-mb=')) {
        $value = substr($arg, strlen('--min-mb='));
        if (!is_numeric($value) || (float) $value < 0) {
            fwrite(STDERR, "--min-mb must be zero or a positive number.\n");
            exit(1);
        }
        $minMb = (float) $value;
        continue;
    }
    if (str_starts_with($arg, '--max-mb=')) {
        $value = substr($arg, strlen('--max-mb='));
        if (!is_numeric($value) || (float) $value < 0) {
            fwrite(STDERR, "--max-mb must be zero or a positive number.\n");
            exit(1);
        }
        $maxMb = (float) $value;
        continue;
    }
    if (str_starts_with($arg, '--sort=')) {
        $sortMode = strtolower(trim(substr($arg, strlen('--sort='))));
        if (!in_array($sortMode, ['name', 'size'], true)) {
            fwrite(STDERR, "--sort must be name or size.\n");
            exit(1);
        }
        continue;
    }
    if (str_starts_with($arg, '--')) {
        continue;
    }
    $positionals[] = $arg;
}

if (count($positionals) < 1) {
    fwrite(STDERR, "Usage: php scripts/import_ps1_chd_folder.php <source-folder> [collection-slug] [--dry-run|--apply] [--limit=N] [--offset=N] [--min-mb=N] [--max-mb=N] [--sort=name|size] [--skip-backup] [--skip-audit]\n");
    fwrite(STDERR, "Default mode is --dry-run. Use --apply to copy files and write database rows.\n");
    exit(1);
}

$sourceRoot = rtrim($positionals[0], "\\/");
$collectionSlug = $positionals[1] ?? '_ps1_import';
$siteRoot = realpath(__DIR__ . '/..');

if ($siteRoot === false) {
    fwrite(STDERR, "Unable to resolve site root.\n");
    exit(1);
}

if (!is_dir($sourceRoot)) {
    fwrite(STDERR, "Source folder not found: {$sourceRoot}\n");
    exit(1);
}

if ($minMb !== null && $maxMb !== null && $minMb > $maxMb) {
    fwrite(STDERR, "--min-mb cannot be greater than --max-mb.\n");
    exit(1);
}

if (!preg_match('/^[A-Za-z0-9_-]+$/', $collectionSlug)) {
    fwrite(STDERR, "Collection slug may only contain letters, numbers, underscores, and dashes.\n");
    exit(1);
}

function display_name_from_ps1_chd(string $filename): string
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

function ps1_bucket_key(string $name): string
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

function ps1_size_label(int $bytes): string
{
    $mb = $bytes / 1048576;
    if ($mb <= 150) {
        return 'Small';
    }
    if ($mb <= 400) {
        return 'Medium';
    }
    if ($mb <= 700) {
        return 'Large';
    }
    return 'Huge';
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

function unique_ps1_target_name(string $bucketDir, string $basename, string $relativeSource): string
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

function run_catalog_command(string $script, string $label): void
{
    $command = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg(__DIR__ . DIRECTORY_SEPARATOR . $script) . ' --all';
    if ($script === 'audit_catalog_integrity.php') {
        $command = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg(__DIR__ . DIRECTORY_SEPARATOR . $script);
    }
    passthru($command, $exitCode);
    if ($exitCode !== 0) {
        throw new RuntimeException("{$label} failed.");
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
    if (strtolower($fileInfo->getExtension()) !== 'chd') {
        continue;
    }

    $fullPath = $fileInfo->getPathname();
    $relativeSource = ltrim(substr($fullPath, strlen($sourceRoot)), "\\/");
    $displayName = display_name_from_ps1_chd($fileInfo->getFilename());
    $bucket = ps1_bucket_key($displayName);
    $sizeBytes = $fileInfo->getSize();
    $sizeLabel = ps1_size_label($sizeBytes);

    $roms[] = [
        'source' => $fullPath,
        'relative_source' => $relativeSource,
        'filename' => $fileInfo->getFilename(),
        'name' => $displayName,
        'bucket' => $bucket,
        'size_bytes' => $sizeBytes,
        'size_label' => $sizeLabel,
    ];
}

$minBytes = $minMb === null ? null : (int) round($minMb * 1048576);
$maxBytes = $maxMb === null ? null : (int) round($maxMb * 1048576);

if ($minBytes !== null || $maxBytes !== null) {
    $roms = array_values(array_filter($roms, static function (array $rom) use ($minBytes, $maxBytes): bool {
        if ($minBytes !== null && $rom['size_bytes'] < $minBytes) {
            return false;
        }
        if ($maxBytes !== null && $rom['size_bytes'] > $maxBytes) {
            return false;
        }
        return true;
    }));
}

if ($sortMode === 'size') {
    usort($roms, static function (array $a, array $b): int {
        $sizeCompare = $a['size_bytes'] <=> $b['size_bytes'];
        return $sizeCompare !== 0 ? $sizeCompare : strcasecmp($a['name'], $b['name']);
    });
} else {
    usort($roms, static fn(array $a, array $b): int => strcasecmp($a['name'], $b['name']));
}

if ($offset > 0) {
    $roms = array_slice($roms, $offset);
}

if ($limit !== null) {
    $roms = array_slice($roms, 0, $limit);
}

$totalBytes = array_sum(array_column($roms, 'size_bytes'));
$sizeCounts = ['Small' => 0, 'Medium' => 0, 'Large' => 0, 'Huge' => 0];
foreach ($roms as $rom) {
    $sizeCounts[$rom['size_label']]++;
}

echo "Mode: " . ($apply ? 'apply' : 'dry-run') . "\n";
echo "Source: {$sourceRoot}\n";
echo "Collection: {$collectionSlug}\n";
echo "Sort: {$sortMode}\n";
echo "Offset: {$offset}\n";
echo "Min MB: " . ($minMb === null ? 'none' : (string) $minMb) . "\n";
echo "Max MB: " . ($maxMb === null ? 'none' : (string) $maxMb) . "\n";
echo "CHD files selected: " . count($roms) . "\n";
echo "Total size MB: " . number_format($totalBytes / 1048576, 2, '.', '') . "\n";
foreach ($sizeCounts as $label => $count) {
    echo "PS1 {$label}: {$count}\n";
}

if (!$apply || $dryRun) {
    foreach (array_slice($roms, 0, 30) as $rom) {
        echo "[dry-run] {$rom['bucket']} | {$rom['size_label']} | " . number_format($rom['size_bytes'] / 1048576, 2, '.', '') . " MB | {$rom['name']}\n";
    }
    if (count($roms) > 30) {
        echo "[dry-run] ... " . (count($roms) - 30) . " more files\n";
    }
    echo "Dry run complete. Pass --apply to import.\n";
    exit(0);
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

if (!$skipBackup) {
    echo "Pre-import backup:\n";
    run_catalog_command('backup_catalog.php', 'Backup');
}

$targetCollectionRoot = $siteRoot . DIRECTORY_SEPARATOR . 'ps1' . DIRECTORY_SEPARATOR . 'games' . DIRECTORY_SEPARATOR . $collectionSlug;
$imageUrl = '/ps1/img/default-ps1.svg';

$inserted = 0;
$skippedExisting = 0;
$copied = 0;
$reusedFiles = 0;

$pdo->beginTransaction();
try {
    $categoryIds = [
        'PS1' => ensure_ps1_category($pdo, 'PS1'),
    ];
    foreach (array_merge(['0-9'], range('A', 'Z'), ['Other']) as $bucket) {
        $categoryIds['PS1 ' . $bucket] = ensure_ps1_category($pdo, 'PS1 ' . $bucket);
    }
    foreach (['Small', 'Medium', 'Large', 'Huge'] as $sizeLabel) {
        $categoryIds['PS1 ' . $sizeLabel] = ensure_ps1_category($pdo, 'PS1 ' . $sizeLabel);
    }
    $categoryIds['PS1 Mobile'] = ensure_ps1_category($pdo, 'PS1 Mobile');

    $selectGame = $pdo->prepare('SELECT id FROM games WHERE game_url = :game_url LIMIT 1');
    $insertGame = $pdo->prepare(
        'INSERT INTO games (name, game_url, image_url, clicks) VALUES (:name, :game_url, :image_url, 0)'
    );

    foreach ($roms as $rom) {
        $bucketDir = $targetCollectionRoot . DIRECTORY_SEPARATOR . $rom['bucket'];
        if (!is_dir($bucketDir) && !mkdir($bucketDir, 0777, true) && !is_dir($bucketDir)) {
            throw new RuntimeException("Unable to create bucket folder: {$bucketDir}");
        }

        $targetName = $rom['filename'];
        $targetPath = $bucketDir . DIRECTORY_SEPARATOR . $targetName;
        $relativeGameFile = $collectionSlug . '/' . $rom['bucket'] . '/' . $targetName;
        $gameUrl = '/ps1/play.html?file=' . ps1_url_from_relative_path($relativeGameFile);

        $selectGame->execute([':game_url' => $gameUrl]);
        $gameId = (int) $selectGame->fetchColumn();
        if ($gameId > 0) {
            $skippedExisting++;
        } else {
            if (is_file($targetPath) && filesize($targetPath) !== $rom['size_bytes']) {
                $targetName = unique_ps1_target_name($bucketDir, $rom['filename'], $rom['relative_source']);
                $targetPath = $bucketDir . DIRECTORY_SEPARATOR . $targetName;
                $relativeGameFile = $collectionSlug . '/' . $rom['bucket'] . '/' . $targetName;
                $gameUrl = '/ps1/play.html?file=' . ps1_url_from_relative_path($relativeGameFile);
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
            $inserted++;
        }

        link_ps1_game_category($pdo, $gameId, $categoryIds['PS1']);
        link_ps1_game_category($pdo, $gameId, $categoryIds['PS1 ' . $rom['bucket']]);
        link_ps1_game_category($pdo, $gameId, $categoryIds['PS1 ' . $rom['size_label']]);
        if ($rom['size_label'] === 'Small') {
            link_ps1_game_category($pdo, $gameId, $categoryIds['PS1 Mobile']);
        }
    }

    $pdo->commit();
} catch (Throwable $exception) {
    $pdo->rollBack();
    fwrite(STDERR, "Import failed: {$exception->getMessage()}\n");
    exit(1);
}

echo "Inserted games: {$inserted}\n";
echo "Skipped existing games: {$skippedExisting}\n";
echo "Copied files: {$copied}\n";
echo "Reused existing files: {$reusedFiles}\n";

if (!$skipAudit) {
    echo "Post-import audit:\n";
    run_catalog_command('audit_catalog_integrity.php', 'Audit');
}

