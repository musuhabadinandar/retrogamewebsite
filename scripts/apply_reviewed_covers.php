<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require __DIR__ . '/../config.php';
require_once __DIR__ . '/../common-file/php/game_helpers.php';

function apply_usage(): void
{
    echo "Usage: php scripts/apply_reviewed_covers.php --system=nes [--apply]\n";
    echo "Options:\n";
    echo "  --queue=PATH                         Review CSV. Default: latest cover_review_queue_libretro_*.csv.\n";
    echo "  --system=nes|ps1|mame                Target system. Default: nes.\n";
    echo "  --apply                              Download/convert/update database. Default dry-run.\n";
    echo "  --auto-approve-high-confidence       NES only: apply safe_review rows with top_score >= --min-score.\n";
    echo "  --auto-buckets=a,b                   Auto bucket allow-list. Default: safe_review.\n";
    echo "  --min-score=N                        Default 92.\n";
    echo "  --limit=N                            Limit selected rows.\n";
    echo "  --offset=N                           Skip selected rows.\n";
    echo "  --force                              Re-download existing files.\n";
    echo "  --cover-root=PATH                    Default: <site>/covers.\n";
    echo "  --backup-dir=PATH                    Default: C:\\laragon\\private\\catalog_backups.\n";
    echo "  --skip-backup                        Do not run catalog backup.\n";
    echo "  --help                               Show this help.\n";
}

function apply_arg(array $argv, string $name, ?string $default = null): ?string
{
    $prefix = $name . '=';
    foreach (array_slice($argv, 1) as $arg) {
        if (str_starts_with($arg, $prefix)) {
            return substr($arg, strlen($prefix));
        }
    }
    return $default;
}

function apply_has(array $argv, string $name): bool
{
    return in_array($name, array_slice($argv, 1), true);
}

function apply_mkdir(string $path): void
{
    if (!is_dir($path) && !mkdir($path, 0777, true) && !is_dir($path)) {
        throw new RuntimeException("Unable to create folder: {$path}");
    }
}

function apply_normalize_csv_headers(array $headers): array
{
    foreach ($headers as $index => $header) {
        $header = (string) $header;
        $header = preg_replace('/^\xEF\xBB\xBF/', '', $header) ?? $header;
        $headers[$index] = trim($header, " \t\n\r\0\x0B\"'");
    }
    return $headers;
}

function apply_latest_queue(string $reportRoot): string
{
    $queues = glob($reportRoot . DIRECTORY_SEPARATOR . 'cover_review_queue_libretro_*.csv') ?: [];
    rsort($queues, SORT_STRING);
    if ($queues === []) {
        throw new RuntimeException("No cover review queue CSV found in {$reportRoot}");
    }
    return $queues[0];
}

function apply_slug(string $value): string
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

function apply_download(string $url, int $attempts = 3): string
{
    $context = stream_context_create([
        'http' => [
            'timeout' => 45,
            'header' => "User-Agent: NandarReviewedCoverApply/1.0\r\n",
        ],
    ]);

    $lastError = '';
    for ($attempt = 1; $attempt <= $attempts; $attempt++) {
        $bytes = @file_get_contents($url, false, $context);
        if (is_string($bytes) && $bytes !== '') {
            return $bytes;
        }
        $lastError = "download failed attempt {$attempt}";
        if ($attempt < $attempts) {
            usleep(250000);
        }
    }
    throw new RuntimeException("Download failed: {$url} ({$lastError})");
}

function apply_write_webp(string $bytes, string $targetPath, int $maxWidth, int $quality): array
{
    if (!function_exists('imagecreatefromstring') || !function_exists('imagewebp')) {
        throw new RuntimeException('PHP GD WebP support is required.');
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

    apply_mkdir(dirname($targetPath));
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

function apply_asset_url(string $siteRoot, string $path): string
{
    $relative = str_replace('\\', '/', substr($path, strlen($siteRoot)));
    return '/' . ltrim($relative, '/');
}

function apply_run_backup(string $backupDir): void
{
    apply_mkdir($backupDir);
    $output = $backupDir . DIRECTORY_SEPARATOR . 'catalog_before_reviewed_cover_apply_' . date('Ymd_His') . '.json';
    $command = '"' . PHP_BINARY . '" "' . __DIR__ . DIRECTORY_SEPARATOR . 'backup_catalog.php" "' . $output . '"';
    passthru($command, $code);
    if ($code !== 0) {
        throw new RuntimeException('Pre-apply backup failed.');
    }
}

function apply_selected_rows(string $queuePath, string $system, bool $autoHighConfidence, array $autoBuckets, float $minScore, int $offset, int $limit): array
{
    $handle = fopen($queuePath, 'rb');
    if ($handle === false) {
        throw new RuntimeException("Unable to read queue: {$queuePath}");
    }
    $headers = fgetcsv($handle);
    if (!is_array($headers)) {
        fclose($handle);
        throw new RuntimeException("Invalid queue CSV: {$queuePath}");
    }
    $headers = apply_normalize_csv_headers($headers);

    $rows = [];
    $seen = 0;
    while (($data = fgetcsv($handle)) !== false) {
        if (!is_array($data) || count($data) < count($headers)) {
            continue;
        }
        $row = array_combine($headers, $data);
        if (!is_array($row) || (string) ($row['system'] ?? '') !== $system) {
            continue;
        }

        $decision = strtolower(trim((string) ($row['decision'] ?? '')));
        $candidateUrl = (string) ($row['candidate_1_url'] ?? '');
        $candidateTitle = (string) ($row['candidate_1_title'] ?? '');
        $topScore = (float) ($row['top_score'] ?? 0);
        $reviewBucket = (string) ($row['review_bucket'] ?? '');
        $isApproved = $decision === 'approve';
        $isAutoApproved = $autoHighConfidence
            && $system === 'nes'
            && in_array($reviewBucket, $autoBuckets, true)
            && $topScore >= $minScore
            && $candidateUrl !== ''
            && $candidateTitle !== '';

        if (!$isApproved && !$isAutoApproved) {
            continue;
        }
        if ($seen++ < $offset) {
            continue;
        }

        $rows[] = [
            'id' => (int) ($row['id'] ?? 0),
            'system' => $system,
            'name' => (string) ($row['name'] ?? ''),
            'candidate_title' => $candidateTitle,
            'candidate_url' => $candidateUrl,
            'top_score' => $topScore,
            'mode' => $isApproved ? 'approved' : 'auto_high_confidence',
        ];
        if ($rows[array_key_last($rows)]['id'] <= 0) {
            array_pop($rows);
            continue;
        }
        if (count($rows) >= $limit) {
            break;
        }
    }
    fclose($handle);
    return $rows;
}

if (apply_has($argv, '--help')) {
    apply_usage();
    exit(0);
}

$system = strtolower((string) apply_arg($argv, '--system', 'nes'));
if (!in_array($system, ['nes', 'ps1', 'mame'], true)) {
    apply_usage();
    exit(1);
}

$apply = apply_has($argv, '--apply');
$autoHighConfidence = apply_has($argv, '--auto-approve-high-confidence');
$autoBuckets = array_values(array_filter(array_map('trim', explode(',', (string) apply_arg($argv, '--auto-buckets', 'safe_review')))));
if ($autoBuckets === []) {
    $autoBuckets = ['safe_review'];
}
$minScore = (float) apply_arg($argv, '--min-score', '92');
$limit = max(1, (int) apply_arg($argv, '--limit', '500'));
$offset = max(0, (int) apply_arg($argv, '--offset', '0'));
$force = apply_has($argv, '--force');
$skipBackup = apply_has($argv, '--skip-backup');
$quality = max(1, min(100, (int) apply_arg($argv, '--quality', '82')));
$maxWidth = max(120, (int) apply_arg($argv, '--max-width', '360'));
$siteRoot = game_site_root();
$privateRoot = getenv('NANDAR_COVER_PRIVATE_DIR') ?: 'C:\\laragon\\private\\cover_pipeline';
$reportRoot = $privateRoot . DIRECTORY_SEPARATOR . 'reports';
$queuePath = (string) apply_arg($argv, '--queue', apply_latest_queue($reportRoot));
$coverRoot = (string) apply_arg($argv, '--cover-root', $siteRoot . DIRECTORY_SEPARATOR . 'covers');
$backupDir = (string) apply_arg($argv, '--backup-dir', 'C:\\laragon\\private\\catalog_backups');

$rows = apply_selected_rows($queuePath, $system, $autoHighConfidence, $autoBuckets, $minScore, $offset, $limit);
echo "Mode: " . ($apply ? 'apply' : 'dry-run') . "\n";
echo "System: {$system}\n";
echo "Queue: {$queuePath}\n";
echo "Auto high confidence: " . ($autoHighConfidence ? 'yes' : 'no') . "\n";
echo "Auto buckets: " . implode(',', $autoBuckets) . "\n";
echo "Min score: {$minScore}\n";
echo "Offset: {$offset}\n";
echo "Limit: {$limit}\n";
echo "Selected rows: " . count($rows) . "\n";

if ($rows === []) {
    echo "No rows selected.\n";
    exit(0);
}

if (!$apply) {
    foreach (array_slice($rows, 0, 25) as $row) {
        echo "[dry-run] #{$row['id']} {$row['top_score']} {$row['name']} -> {$row['candidate_title']}\n";
    }
    if (count($rows) > 25) {
        echo "[dry-run] ... " . (count($rows) - 25) . " more rows\n";
    }
    exit(0);
}

if (!$skipBackup) {
    echo "Pre-apply backup:\n";
    apply_run_backup($backupDir);
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

$targetDir = $coverRoot . DIRECTORY_SEPARATOR . $system . DIRECTORY_SEPARATOR . 'boxart';
apply_mkdir($targetDir);
$update = $pdo->prepare('UPDATE games SET image_url = :image_url WHERE id = :id');

$downloaded = 0;
$converted = 0;
$updated = 0;
$skippedExisting = 0;
$failed = 0;
$failures = [];
$results = [];
$downloadCacheDir = $privateRoot . DIRECTORY_SEPARATOR . 'download_cache';
apply_mkdir($downloadCacheDir);

$pdo->beginTransaction();
try {
    foreach ($rows as $row) {
        $targetPath = $targetDir . DIRECTORY_SEPARATOR . $row['id'] . '-' . apply_slug($row['candidate_title']) . '.webp';
        $assetUrl = apply_asset_url($siteRoot, $targetPath);
        try {
            if (is_file($targetPath) && !$force) {
                $skippedExisting++;
                $info = ['bytes' => filesize($targetPath) ?: 0];
            } else {
                $cacheKey = str_replace('%25', '%', $row['candidate_url']);
                $cachePath = $downloadCacheDir . DIRECTORY_SEPARATOR . sha1($cacheKey) . '.img';
                if (is_file($cachePath)) {
                    $bytes = (string) file_get_contents($cachePath);
                } else {
                    $bytes = apply_download($row['candidate_url']);
                    file_put_contents($cachePath, $bytes);
                    $downloaded++;
                }
                $info = apply_write_webp($bytes, $targetPath, $maxWidth, $quality);
                $converted++;
            }
            $update->execute([':image_url' => $assetUrl, ':id' => $row['id']]);
            $updated++;
            $results[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'candidate_title' => $row['candidate_title'],
                'image_url' => $assetUrl,
                'bytes' => $info['bytes'],
                'mode' => $row['mode'],
            ];
            echo "[ok] #{$row['id']} {$row['name']} -> {$assetUrl}\n";
        } catch (Throwable $exception) {
            $failed++;
            $failures[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'candidate_title' => $row['candidate_title'],
                'candidate_url' => $row['candidate_url'],
                'error' => $exception->getMessage(),
            ];
            echo "[failed] #{$row['id']} {$row['name']} :: {$exception->getMessage()}\n";
        }
    }
    $pdo->commit();
} catch (Throwable $exception) {
    $pdo->rollBack();
    throw $exception;
}

$importRoot = $privateRoot . DIRECTORY_SEPARATOR . 'imports';
apply_mkdir($importRoot);
$reportPath = $importRoot . DIRECTORY_SEPARATOR . 'reviewed_cover_apply_' . $system . '_' . date('Ymd_His') . '.json';
file_put_contents($reportPath, json_encode([
    'generated_at' => date(DATE_ATOM),
    'system' => $system,
    'queue' => $queuePath,
    'auto_high_confidence' => $autoHighConfidence,
    'auto_buckets' => $autoBuckets,
    'min_score' => $minScore,
    'selected_rows' => count($rows),
    'downloaded' => $downloaded,
    'converted_webp' => $converted,
    'updated_database' => $updated,
    'skipped_existing_files' => $skippedExisting,
    'failed' => $failed,
    'results' => $results,
    'failures' => $failures,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

echo "Downloaded: {$downloaded}\n";
echo "Converted WebP: {$converted}\n";
echo "Updated database: {$updated}\n";
echo "Skipped existing files: {$skippedExisting}\n";
echo "Failed: {$failed}\n";
echo "Apply report: {$reportPath}\n";
