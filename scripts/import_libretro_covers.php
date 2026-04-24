<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require __DIR__ . '/../config.php';
require_once __DIR__ . '/../common-file/php/game_helpers.php';

function libretro_cover_usage(): void
{
    echo "Usage: php scripts/import_libretro_covers.php --system=gba [--limit=100] [--offset=0] [--apply]\n";
    echo "Options:\n";
    echo "  --system=gba|nes|gb|gbc|ps1|mame   Required target system.\n";
    echo "  --report=PATH                       CSV report from cover_libretro_dry_run.php.\n";
    echo "  --limit=N                           Number of matched rows to process. Default 100.\n";
    echo "  --offset=N                          Skip N matched rows. Default 0.\n";
    echo "  --id=N                              Process one game id from the report.\n";
    echo "  --source=boxart|snap|title          Libretro source type. Default boxart.\n";
    echo "  --target-type=boxart|snap|title     Local cover type folder. Default boxart.\n";
    echo "  --apply                             Download, convert, backup, and update database.\n";
    echo "  --force                             Re-download and overwrite existing local image.\n";
    echo "  --quality=N                         WebP quality. Default 82.\n";
    echo "  --max-width=N                       Max output width. Default 360.\n";
    echo "  --cover-root=PATH                   Public cover folder. Default: <site>/covers.\n";
    echo "  --backup-dir=PATH                   Private backup folder.\n";
    echo "  --skip-backup                       Do not run backup before apply.\n";
    echo "  --help                              Show this help.\n";
}

function libretro_cover_arg(array $argv, string $name, ?string $default = null): ?string
{
    $prefix = $name . '=';
    foreach (array_slice($argv, 1) as $arg) {
        if (str_starts_with($arg, $prefix)) {
            return substr($arg, strlen($prefix));
        }
    }
    return $default;
}

function libretro_cover_has(array $argv, string $name): bool
{
    return in_array($name, array_slice($argv, 1), true);
}

function libretro_cover_mkdir(string $path): void
{
    if (!is_dir($path) && !mkdir($path, 0777, true) && !is_dir($path)) {
        throw new RuntimeException("Unable to create folder: {$path}");
    }
}

function libretro_cover_latest_report(string $reportRoot): string
{
    $reports = glob($reportRoot . DIRECTORY_SEPARATOR . 'cover_audit_libretro_dry_run_*.csv') ?: [];
    rsort($reports, SORT_STRING);
    if ($reports === []) {
        throw new RuntimeException("No dry-run CSV report found in {$reportRoot}. Run cover_libretro_dry_run.php first.");
    }
    return $reports[0];
}

function libretro_cover_slug(string $value): string
{
    $value = html_entity_decode(rawurldecode($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $value = strtolower(trim($value));
    $value = str_replace(['&', '+'], [' and ', ' plus '], $value);
    $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? $value;
    $value = trim($value, '-');
    if ($value === '') {
        return 'cover';
    }
    return strlen($value) > 120 ? substr($value, 0, 120) : $value;
}

function libretro_cover_load_rows(string $csvPath, string $system, int $offset, int $limit, ?int $onlyId): array
{
    $handle = fopen($csvPath, 'rb');
    if ($handle === false) {
        throw new RuntimeException("Unable to read report: {$csvPath}");
    }

    $headers = fgetcsv($handle);
    if (!is_array($headers)) {
        fclose($handle);
        throw new RuntimeException("Invalid CSV report: {$csvPath}");
    }

    $safeStatuses = ['exact', 'exact_case_insensitive', 'normalized_unique'];
    $rows = [];
    $matchedSeen = 0;

    while (($data = fgetcsv($handle)) !== false) {
        if (!is_array($data) || count($data) < count($headers)) {
            continue;
        }
        $row = array_combine($headers, $data);
        if (!is_array($row)) {
            continue;
        }
        if (($row['system'] ?? '') !== $system) {
            continue;
        }
        if ($onlyId !== null && (int) ($row['id'] ?? 0) !== $onlyId) {
            continue;
        }
        if (!in_array((string) ($row['match_status'] ?? ''), $safeStatuses, true)) {
            continue;
        }
        if ((string) ($row['matched_url'] ?? '') === '') {
            continue;
        }
        if ($onlyId === null && $matchedSeen++ < $offset) {
            continue;
        }
        $rows[] = $row;
        if ($onlyId !== null || count($rows) >= $limit) {
            break;
        }
    }

    fclose($handle);
    return $rows;
}

function libretro_cover_download(string $url): string
{
    $url = str_replace('%25', '%', $url);
    $context = stream_context_create([
        'http' => [
            'timeout' => 45,
            'header' => "User-Agent: NandarCoverImport/1.0\r\n",
        ],
    ]);
    $bytes = @file_get_contents($url, false, $context);
    if (!is_string($bytes) || $bytes === '') {
        throw new RuntimeException("Download failed: {$url}");
    }
    return $bytes;
}

function libretro_cover_source_url(string $url, string $source): string
{
    $map = [
        'boxart' => 'Named_Boxarts',
        'snap' => 'Named_Snaps',
        'title' => 'Named_Titles',
    ];
    if (!isset($map[$source])) {
        throw new RuntimeException("Invalid source type: {$source}");
    }

    return str_replace(['/Named_Boxarts/', '/Named_Snaps/', '/Named_Titles/'], '/' . $map[$source] . '/', $url);
}

function libretro_cover_write_webp(string $bytes, string $targetPath, int $maxWidth, int $quality): array
{
    if (!function_exists('imagecreatefromstring') || !function_exists('imagewebp')) {
        throw new RuntimeException('PHP GD WebP support is required for conversion.');
    }

    $source = @imagecreatefromstring($bytes);
    if (!$source instanceof GdImage) {
        throw new RuntimeException('Downloaded image could not be decoded.');
    }

    $width = imagesx($source);
    $height = imagesy($source);
    $output = $source;
    $outWidth = $width;
    $outHeight = $height;

    if ($width > $maxWidth && $maxWidth > 0) {
        $outWidth = $maxWidth;
        $outHeight = max(1, (int) round($height * ($maxWidth / $width)));
        $resized = imagecreatetruecolor($outWidth, $outHeight);
        if (!$resized instanceof GdImage) {
            imagedestroy($source);
            throw new RuntimeException('Unable to allocate resized image.');
        }
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        imagecopyresampled($resized, $source, 0, 0, 0, 0, $outWidth, $outHeight, $width, $height);
        $output = $resized;
    } elseif (!imageistruecolor($source)) {
        $truecolor = imagecreatetruecolor($width, $height);
        if (!$truecolor instanceof GdImage) {
            imagedestroy($source);
            throw new RuntimeException('Unable to allocate truecolor image.');
        }
        imagealphablending($truecolor, false);
        imagesavealpha($truecolor, true);
        imagecopy($truecolor, $source, 0, 0, 0, 0, $width, $height);
        $output = $truecolor;
    }

    libretro_cover_mkdir(dirname($targetPath));
    $ok = imagewebp($output, $targetPath, max(1, min(100, $quality)));
    if ($output !== $source) {
        imagedestroy($output);
    }
    imagedestroy($source);

    if (!$ok || !is_file($targetPath)) {
        throw new RuntimeException("Unable to write WebP: {$targetPath}");
    }

    return [
        'width' => $outWidth,
        'height' => $outHeight,
        'bytes' => filesize($targetPath) ?: 0,
    ];
}

function libretro_cover_asset_url(string $siteRoot, string $path): string
{
    $relative = str_replace('\\', '/', substr($path, strlen($siteRoot)));
    return '/' . ltrim($relative, '/');
}

function libretro_cover_run_backup(string $backupDir): void
{
    libretro_cover_mkdir($backupDir);
    $output = $backupDir . DIRECTORY_SEPARATOR . 'catalog_before_cover_import_' . date('Ymd_His') . '.json';
    $command = '"' . PHP_BINARY . '" "' . __DIR__ . DIRECTORY_SEPARATOR . 'backup_catalog.php" "' . $output . '"';
    passthru($command, $code);
    if ($code !== 0) {
        throw new RuntimeException('Pre-import backup failed.');
    }
}

if (libretro_cover_has($argv, '--help')) {
    libretro_cover_usage();
    exit(0);
}

$system = strtolower((string) libretro_cover_arg($argv, '--system', ''));
$validSystems = ['nes', 'gba', 'gb', 'gbc', 'ps1', 'mame'];
if (!in_array($system, $validSystems, true)) {
    libretro_cover_usage();
    exit(1);
}

$apply = libretro_cover_has($argv, '--apply');
$limit = max(1, (int) libretro_cover_arg($argv, '--limit', '100'));
$offset = max(0, (int) libretro_cover_arg($argv, '--offset', '0'));
$onlyIdRaw = libretro_cover_arg($argv, '--id', '');
$onlyId = $onlyIdRaw !== '' ? max(1, (int) $onlyIdRaw) : null;
$sourceType = strtolower((string) libretro_cover_arg($argv, '--source', 'boxart'));
$targetType = strtolower((string) libretro_cover_arg($argv, '--target-type', 'boxart'));
foreach ([$sourceType, $targetType] as $type) {
    if (!in_array($type, ['boxart', 'snap', 'title'], true)) {
        libretro_cover_usage();
        exit(1);
    }
}
$quality = max(1, min(100, (int) libretro_cover_arg($argv, '--quality', '82')));
$maxWidth = max(120, (int) libretro_cover_arg($argv, '--max-width', '360'));
$siteRoot = game_site_root();
$privateRoot = getenv('NANDAR_COVER_PRIVATE_DIR') ?: 'C:\\laragon\\private\\cover_pipeline';
$reportRoot = $privateRoot . DIRECTORY_SEPARATOR . 'reports';
$reportPath = (string) libretro_cover_arg($argv, '--report', libretro_cover_latest_report($reportRoot));
$coverRoot = (string) libretro_cover_arg($argv, '--cover-root', $siteRoot . DIRECTORY_SEPARATOR . 'covers');
$backupDir = (string) libretro_cover_arg($argv, '--backup-dir', 'C:\\laragon\\private\\catalog_backups');
$skipBackup = libretro_cover_has($argv, '--skip-backup');
$force = libretro_cover_has($argv, '--force');

$rows = libretro_cover_load_rows($reportPath, $system, $offset, $limit, $onlyId);
if ($rows === []) {
    echo "No safe matched rows selected.\n";
    exit(0);
}

echo "Mode: " . ($apply ? 'apply' : 'dry-run') . "\n";
echo "System: {$system}\n";
echo "Report: {$reportPath}\n";
echo "Offset: {$offset}\n";
echo "Limit: {$limit}\n";
echo "ID: " . ($onlyId === null ? 'none' : (string) $onlyId) . "\n";
echo "Source type: {$sourceType}\n";
echo "Target type: {$targetType}\n";
echo "Selected rows: " . count($rows) . "\n";

if (!$apply) {
    foreach (array_slice($rows, 0, 20) as $row) {
        echo "[dry-run] #{$row['id']} {$row['match_status']} {$row['name']} -> {$row['matched_filename']}\n";
    }
    if (count($rows) > 20) {
        echo "[dry-run] ... " . (count($rows) - 20) . " more rows\n";
    }
    echo "Dry run complete. Pass --apply to download covers and update database.\n";
    exit(0);
}

if (!$skipBackup) {
    echo "Pre-import backup:\n";
    libretro_cover_run_backup($backupDir);
}

$pdo = new PDO(
    "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
    $username,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
);

$targetDir = $coverRoot . DIRECTORY_SEPARATOR . $system . DIRECTORY_SEPARATOR . $targetType;
libretro_cover_mkdir($targetDir);
$update = $pdo->prepare('UPDATE games SET image_url = :image_url WHERE id = :id');

$downloaded = 0;
$converted = 0;
$updated = 0;
$skippedExisting = 0;
$failed = 0;
$failures = [];
$results = [];

$pdo->beginTransaction();
try {
    foreach ($rows as $row) {
        $id = (int) $row['id'];
        $title = (string) ($row['matched_title'] !== '' ? $row['matched_title'] : $row['name']);
        $targetPath = $targetDir . DIRECTORY_SEPARATOR . $id . '-' . libretro_cover_slug($title) . '.webp';
        $assetUrl = libretro_cover_asset_url($siteRoot, $targetPath);

        try {
            if (is_file($targetPath) && !$force) {
                $skippedExisting++;
                $info = [
                    'width' => 0,
                    'height' => 0,
                    'bytes' => filesize($targetPath) ?: 0,
                ];
            } else {
                $bytes = libretro_cover_download(libretro_cover_source_url((string) $row['matched_url'], $sourceType));
                $downloaded++;
                $info = libretro_cover_write_webp($bytes, $targetPath, $maxWidth, $quality);
                $converted++;
            }

            $update->execute([
                ':image_url' => $assetUrl,
                ':id' => $id,
            ]);
            $updated++;
            $results[] = [
                'id' => $id,
                'name' => (string) $row['name'],
                'image_url' => $assetUrl,
                'bytes' => $info['bytes'],
            ];
            echo "[ok] #{$id} {$row['name']} -> {$assetUrl}\n";
        } catch (Throwable $exception) {
            $failed++;
            $failures[] = [
                'id' => $id,
                'name' => (string) $row['name'],
                'url' => (string) $row['matched_url'],
                'error' => $exception->getMessage(),
            ];
            echo "[failed] #{$id} {$row['name']} :: {$exception->getMessage()}\n";
        }
    }

    $pdo->commit();
} catch (Throwable $exception) {
    $pdo->rollBack();
    throw $exception;
}

$reportOutDir = $privateRoot . DIRECTORY_SEPARATOR . 'imports';
libretro_cover_mkdir($reportOutDir);
$importReport = [
    'generated_at' => date(DATE_ATOM),
    'system' => $system,
    'source_type' => $sourceType,
    'target_type' => $targetType,
    'source_report' => $reportPath,
    'selected_rows' => count($rows),
    'downloaded' => $downloaded,
    'converted_webp' => $converted,
    'updated_database' => $updated,
    'skipped_existing_files' => $skippedExisting,
    'failed' => $failed,
    'results' => $results,
    'failures' => $failures,
];
$importReportPath = $reportOutDir . DIRECTORY_SEPARATOR . 'libretro_cover_import_' . $system . '_' . date('Ymd_His') . '.json';
file_put_contents($importReportPath, json_encode($importReport, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

echo "Downloaded: {$downloaded}\n";
echo "Converted WebP: {$converted}\n";
echo "Updated database: {$updated}\n";
echo "Skipped existing files: {$skippedExisting}\n";
echo "Failed: {$failed}\n";
echo "Import report: {$importReportPath}\n";
