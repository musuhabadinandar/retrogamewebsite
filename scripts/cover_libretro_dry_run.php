<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require __DIR__ . '/../config.php';
require_once __DIR__ . '/../common-file/php/game_helpers.php';

function cover_usage(): void
{
    echo "Usage: php scripts/cover_libretro_dry_run.php [options]\n";
    echo "Options:\n";
    echo "  --systems=nes,gba,gb,gbc,ps1,mame  Limit systems.\n";
    echo "  --limit=N                          Limit games read from database.\n";
    echo "  --sample=N                         Sample count per report bucket. Default 25.\n";
    echo "  --refresh-index                    Re-download Libretro index cache.\n";
    echo "  --no-network                       Use existing index cache only.\n";
    echo "  --no-init-folders                  Do not create local cover folders.\n";
    echo "  --cover-root=PATH                  Public cover folder. Default: <site>/covers.\n";
    echo "  --cache-dir=PATH                   Private Libretro cache folder.\n";
    echo "  --report-dir=PATH                  Private report folder.\n";
    echo "  --help                             Show this help.\n";
}

function cover_arg_value(array $argv, string $name, ?string $default = null): ?string
{
    $prefix = $name . '=';
    foreach (array_slice($argv, 1) as $arg) {
        if (str_starts_with($arg, $prefix)) {
            return substr($arg, strlen($prefix));
        }
    }
    return $default;
}

function cover_has_arg(array $argv, string $name): bool
{
    return in_array($name, array_slice($argv, 1), true);
}

function cover_safe_filename(string $value): string
{
    $value = strtolower(trim($value));
    $value = preg_replace('/[^a-z0-9._-]+/', '-', $value) ?? $value;
    $value = trim($value, '-');
    return $value !== '' ? $value : 'unknown';
}

function cover_mkdir(string $path): void
{
    if (!is_dir($path) && !mkdir($path, 0777, true) && !is_dir($path)) {
        throw new RuntimeException("Unable to create folder: {$path}");
    }
}

function cover_systems(): array
{
    return [
        'nes' => [
            'label' => 'NES / FC',
            'libretro' => 'Nintendo - Nintendo Entertainment System',
            'public_dir' => 'nes',
            'types' => ['boxart', 'snap', 'title', 'review'],
        ],
        'gba' => [
            'label' => 'Game Boy Advance',
            'libretro' => 'Nintendo - Game Boy Advance',
            'public_dir' => 'gba',
            'types' => ['boxart', 'snap', 'title', 'review'],
        ],
        'gb' => [
            'label' => 'Game Boy',
            'libretro' => 'Nintendo - Game Boy',
            'public_dir' => 'gb',
            'types' => ['boxart', 'snap', 'title', 'review'],
        ],
        'gbc' => [
            'label' => 'Game Boy Color',
            'libretro' => 'Nintendo - Game Boy Color',
            'public_dir' => 'gbc',
            'types' => ['boxart', 'snap', 'title', 'review'],
        ],
        'ps1' => [
            'label' => 'Sony PlayStation',
            'libretro' => 'Sony - PlayStation',
            'public_dir' => 'ps1',
            'types' => ['boxart', 'snap', 'title', 'review'],
        ],
        'mame' => [
            'label' => 'Arcade / MAME',
            'libretro' => 'MAME',
            'public_dir' => 'mame',
            'types' => ['boxart', 'snap', 'title', 'review'],
        ],
    ];
}

function cover_libretro_index_url(string $libretroSystem, string $kind = 'Named_Boxarts'): string
{
    return 'https://thumbnails.libretro.com/' . rawurlencode($libretroSystem) . '/' . rawurlencode($kind) . '/';
}

function cover_image_status(string $imageUrl): string
{
    $trimmed = trim($imageUrl);
    if ($trimmed === '') {
        return 'blank';
    }

    if (preg_match('#^https?://#i', $trimmed) || str_starts_with($trimmed, '//')) {
        return 'remote';
    }

    $normalized = '/' . ltrim(str_replace('\\', '/', $trimmed), '/');
    $defaults = [
        '/common-file/img/default-game.jpg',
        '/ps1/img/default-ps1.svg',
        '/mame/img/default-mame.svg',
    ];
    if (in_array($normalized, $defaults, true)) {
        return 'default';
    }

    return is_file(local_path_from_url($trimmed)) ? 'local_valid' : 'local_missing';
}

function cover_game_context(array $game): array
{
    $gameUrl = (string) ($game['game_url'] ?? '');
    $path = parse_url($gameUrl, PHP_URL_PATH);
    $query = parse_url($gameUrl, PHP_URL_QUERY);
    $urlSystem = is_string($path) ? strtok(trim($path, '/'), '/') : '';

    $file = '';
    if (is_string($query)) {
        parse_str($query, $params);
        if (isset($params['file']) && is_string($params['file'])) {
            $file = $params['file'];
        } elseif (isset($params['f']) && is_string($params['f'])) {
            $file = decode_legacy_game_file($params['f']);
        }
    }

    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $system = 'unsupported';
    if ($urlSystem === 'fc') {
        $system = 'nes';
    } elseif ($urlSystem === 'gba') {
        $system = 'gba';
    } elseif ($urlSystem === 'gb') {
        $system = $extension === 'gbc' ? 'gbc' : 'gb';
    } elseif ($urlSystem === 'ps1') {
        $system = 'ps1';
    } elseif ($urlSystem === 'mame') {
        $system = 'mame';
    }

    return [
        'system' => $system,
        'url_system' => is_string($urlSystem) ? $urlSystem : '',
        'file' => str_replace('\\', '/', $file),
        'extension' => $extension,
    ];
}

function cover_clean_title(string $title): string
{
    $title = html_entity_decode(rawurldecode($title), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $title = preg_replace('/\.[a-z0-9]{2,5}$/i', '', $title) ?? $title;
    $title = str_replace(['_', '+'], ' ', $title);
    $title = preg_replace('/\s+/', ' ', $title) ?? $title;
    return trim($title);
}

function cover_title_candidates(array $game, array $context): array
{
    $raw = [];
    $raw[] = (string) ($game['name'] ?? '');

    $file = (string) ($context['file'] ?? '');
    if ($file !== '') {
        $raw[] = pathinfo($file, PATHINFO_FILENAME);
        $parent = basename(dirname($file));
        if ($parent !== '' && $parent !== '.' && $parent !== DIRECTORY_SEPARATOR) {
            $raw[] = $parent;
        }
    }

    $candidates = [];
    foreach ($raw as $title) {
        $clean = cover_clean_title($title);
        if ($clean === '') {
            continue;
        }
        $candidates[] = $clean;
        $candidates[] = str_replace(['[Disc ', ']'], ['(Disc ', ')'], $clean);
        $candidates[] = preg_replace('/\s+\((?:USA|Europe|Japan|World|En|Fr|De|Es|It|Rev[^)]*|Beta|Proto|Demo)[^)]*\)$/i', '', $clean) ?? $clean;
    }

    return array_values(array_unique(array_filter(array_map('trim', $candidates))));
}

function cover_normalize_title(string $title): string
{
    $title = cover_clean_title($title);
    $title = str_replace([':', ';', ',', "'", '"', '`', '.', '_'], ' ', $title);
    $title = str_replace(['-', '&'], [' ', ' and '], $title);
    $title = preg_replace('/\s+/', ' ', $title) ?? $title;
    return strtolower(trim($title));
}

function cover_fetch_libretro_index(array $systemConfig, string $cacheRoot, bool $refresh, bool $network): array
{
    cover_mkdir($cacheRoot);

    $cacheFile = $cacheRoot . DIRECTORY_SEPARATOR . cover_safe_filename((string) $systemConfig['libretro']) . '-named-boxarts.json';
    if (!$refresh && is_file($cacheFile)) {
        $payload = json_decode((string) file_get_contents($cacheFile), true);
        if (is_array($payload) && isset($payload['entries']) && is_array($payload['entries'])) {
            return cover_build_index_maps($payload['entries'], (string) ($payload['source_url'] ?? ''));
        }
    }

    if (!$network) {
        return [
            'source_url' => cover_libretro_index_url((string) $systemConfig['libretro']),
            'entries' => [],
            'exact' => [],
            'exact_lower' => [],
            'normalized' => [],
            'error' => 'No cache and --no-network was used.',
        ];
    }

    $sourceUrl = cover_libretro_index_url((string) $systemConfig['libretro']);
    $context = stream_context_create([
        'http' => [
            'timeout' => 30,
            'header' => "User-Agent: NandarCoverAudit/1.0\r\n",
        ],
    ]);
    $html = @file_get_contents($sourceUrl, false, $context);
    if (!is_string($html) || $html === '') {
        return [
            'source_url' => $sourceUrl,
            'entries' => [],
            'exact' => [],
            'exact_lower' => [],
            'normalized' => [],
            'error' => 'Unable to fetch Libretro index.',
        ];
    }

    preg_match_all('/href=["\']([^"\']+\.(?:png|jpg|jpeg|webp))["\']/i', $html, $matches);
    $entries = [];
    foreach ($matches[1] ?? [] as $href) {
        $href = html_entity_decode((string) $href, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if (str_starts_with($href, '../') || str_starts_with($href, '/')) {
            continue;
        }
        $filename = rawurldecode(basename($href));
        $title = preg_replace('/\.(?:png|jpg|jpeg|webp)$/i', '', $filename) ?? $filename;
        $encodedHref = str_replace('%2F', '/', rawurlencode(rawurldecode($href)));
        $entries[] = [
            'title' => $title,
            'filename' => $filename,
            'url' => preg_match('#^https?://#i', $href) ? $href : $sourceUrl . $encodedHref,
        ];
    }

    $payload = [
        'generated_at' => date(DATE_ATOM),
        'source_url' => $sourceUrl,
        'entries' => $entries,
    ];
    file_put_contents($cacheFile, json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

    return cover_build_index_maps($entries, $sourceUrl);
}

function cover_build_index_maps(array $entries, string $sourceUrl): array
{
    $exact = [];
    $exactLower = [];
    $normalized = [];

    foreach ($entries as $entry) {
        if (!is_array($entry) || !isset($entry['title'])) {
            continue;
        }
        $title = (string) $entry['title'];
        $exact[$title] = $entry;
        $lower = strtolower($title);
        $exactLower[$lower][] = $entry;
        $normalized[cover_normalize_title($title)][] = $entry;
    }

    return [
        'source_url' => $sourceUrl,
        'entries' => $entries,
        'exact' => $exact,
        'exact_lower' => $exactLower,
        'normalized' => $normalized,
        'error' => '',
    ];
}

function cover_find_match(array $candidates, array $index): array
{
    foreach ($candidates as $candidate) {
        if (isset($index['exact'][$candidate])) {
            return [
                'status' => 'exact',
                'candidate' => $candidate,
                'match' => $index['exact'][$candidate],
            ];
        }
    }

    foreach ($candidates as $candidate) {
        $lower = strtolower($candidate);
        $matches = $index['exact_lower'][$lower] ?? [];
        if (count($matches) === 1) {
            return [
                'status' => 'exact_case_insensitive',
                'candidate' => $candidate,
                'match' => $matches[0],
            ];
        }
    }

    $ambiguous = [];
    foreach ($candidates as $candidate) {
        $normalized = cover_normalize_title($candidate);
        $matches = $index['normalized'][$normalized] ?? [];
        if (count($matches) === 1) {
            return [
                'status' => 'normalized_unique',
                'candidate' => $candidate,
                'match' => $matches[0],
            ];
        }
        if (count($matches) > 1) {
            $ambiguous[] = [
                'candidate' => $candidate,
                'count' => count($matches),
                'samples' => array_slice(array_map(static fn(array $entry): string => (string) ($entry['title'] ?? ''), $matches), 0, 5),
            ];
        }
    }

    if ($ambiguous !== []) {
        return [
            'status' => 'ambiguous',
            'candidate' => $ambiguous[0]['candidate'],
            'match' => null,
            'ambiguous' => $ambiguous[0],
        ];
    }

    return [
        'status' => 'no_match',
        'candidate' => $candidates[0] ?? '',
        'match' => null,
    ];
}

function cover_increment(array &$array, string $key): void
{
    $array[$key] = ($array[$key] ?? 0) + 1;
}

function cover_sample_push(array &$samples, string $bucket, array $row, int $limit): void
{
    if (!isset($samples[$bucket])) {
        $samples[$bucket] = [];
    }
    if (count($samples[$bucket]) < $limit) {
        $samples[$bucket][] = $row;
    }
}

if (cover_has_arg($argv, '--help')) {
    cover_usage();
    exit(0);
}

$siteRoot = game_site_root();
$privateRoot = getenv('NANDAR_COVER_PRIVATE_DIR') ?: 'C:\\laragon\\private\\cover_pipeline';
$cacheRoot = cover_arg_value($argv, '--cache-dir', $privateRoot . DIRECTORY_SEPARATOR . 'libretro_index_cache');
$reportRoot = cover_arg_value($argv, '--report-dir', $privateRoot . DIRECTORY_SEPARATOR . 'reports');
$coverRoot = cover_arg_value($argv, '--cover-root', $siteRoot . DIRECTORY_SEPARATOR . 'covers');
$sampleLimit = max(1, (int) cover_arg_value($argv, '--sample', '25'));
$limit = (int) cover_arg_value($argv, '--limit', '0');
$refresh = cover_has_arg($argv, '--refresh-index');
$network = !cover_has_arg($argv, '--no-network');
$initFolders = !cover_has_arg($argv, '--no-init-folders');
$systemFilterArg = cover_arg_value($argv, '--systems', '');

$systems = cover_systems();
if ($systemFilterArg !== '') {
    $wanted = array_filter(array_map('trim', explode(',', strtolower($systemFilterArg))));
    $systems = array_intersect_key($systems, array_flip($wanted));
}
if ($systems === []) {
    fwrite(STDERR, "No valid systems selected.\n");
    exit(1);
}

cover_mkdir($reportRoot);
if ($initFolders) {
    foreach ($systems as $systemKey => $systemConfig) {
        foreach ($systemConfig['types'] as $type) {
            cover_mkdir($coverRoot . DIRECTORY_SEPARATOR . (string) $systemConfig['public_dir'] . DIRECTORY_SEPARATOR . $type);
        }
    }
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

try {
    $pdo->exec('SET SESSION TRANSACTION READ ONLY');
} catch (Throwable $exception) {
    // Some MySQL/MariaDB builds ignore or reject this in autocommit mode. The script still only performs SELECT queries.
}

$indexes = [];
foreach ($systems as $systemKey => $systemConfig) {
    $indexes[$systemKey] = cover_fetch_libretro_index($systemConfig, (string) $cacheRoot, $refresh, $network);
}

$sql = 'SELECT id, name, game_url, image_url FROM games ORDER BY id ASC';
if ($limit > 0) {
    $sql .= ' LIMIT ' . $limit;
}

$summary = [
    'generated_at' => date(DATE_ATOM),
    'mode' => 'audit+libretro-dry-run',
    'database' => $dbname,
    'site_root' => $siteRoot,
    'cover_root' => $coverRoot,
    'cache_root' => $cacheRoot,
    'report_root' => $reportRoot,
    'database_updates' => 0,
    'downloads' => 0,
    'total_games_read' => 0,
    'supported_games' => 0,
    'unsupported_games' => 0,
    'image_status' => [],
    'systems' => [],
];

foreach ($systems as $systemKey => $systemConfig) {
    $summary['systems'][$systemKey] = [
        'label' => $systemConfig['label'],
        'libretro_system' => $systemConfig['libretro'],
        'libretro_source' => $indexes[$systemKey]['source_url'] ?? '',
        'libretro_entries' => count($indexes[$systemKey]['entries'] ?? []),
        'libretro_error' => $indexes[$systemKey]['error'] ?? '',
        'games' => 0,
        'image_status' => [],
        'match_status' => [],
    ];
}

$samples = [];
$csvRows = [];
$stmt = $pdo->query($sql);
foreach ($stmt as $game) {
    $summary['total_games_read']++;
    $imageStatus = cover_image_status((string) ($game['image_url'] ?? ''));
    cover_increment($summary['image_status'], $imageStatus);

    $context = cover_game_context($game);
    $systemKey = (string) $context['system'];
    if (!isset($systems[$systemKey])) {
        $summary['unsupported_games']++;
        continue;
    }

    $summary['supported_games']++;
    $summary['systems'][$systemKey]['games']++;
    cover_increment($summary['systems'][$systemKey]['image_status'], $imageStatus);

    $candidates = cover_title_candidates($game, $context);
    $match = cover_find_match($candidates, $indexes[$systemKey]);
    $matchStatus = (string) $match['status'];
    cover_increment($summary['systems'][$systemKey]['match_status'], $matchStatus);

    $matchEntry = is_array($match['match'] ?? null) ? $match['match'] : [];
    $row = [
        'id' => (int) $game['id'],
        'system' => $systemKey,
        'name' => (string) $game['name'],
        'file' => (string) $context['file'],
        'image_status' => $imageStatus,
        'match_status' => $matchStatus,
        'candidate' => (string) ($match['candidate'] ?? ''),
        'matched_title' => (string) ($matchEntry['title'] ?? ''),
        'matched_filename' => (string) ($matchEntry['filename'] ?? ''),
        'matched_url' => (string) ($matchEntry['url'] ?? ''),
    ];
    $csvRows[] = $row;

    if (in_array($matchStatus, ['exact', 'exact_case_insensitive', 'normalized_unique', 'ambiguous', 'no_match'], true)) {
        cover_sample_push($samples, $systemKey . ':' . $matchStatus, $row, $sampleLimit);
    }
    if (in_array($imageStatus, ['blank', 'default', 'local_missing'], true)) {
        cover_sample_push($samples, 'image:' . $imageStatus, $row, $sampleLimit);
    }
}

$timestamp = date('Ymd_His');
$jsonPath = $reportRoot . DIRECTORY_SEPARATOR . "cover_audit_libretro_dry_run_{$timestamp}.json";
$csvPath = $reportRoot . DIRECTORY_SEPARATOR . "cover_audit_libretro_dry_run_{$timestamp}.csv";

$payload = [
    'summary' => $summary,
    'samples' => $samples,
];
file_put_contents($jsonPath, json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

$csv = fopen($csvPath, 'wb');
if ($csv === false) {
    throw new RuntimeException("Unable to write CSV report: {$csvPath}");
}
fputcsv($csv, ['id', 'system', 'name', 'file', 'image_status', 'match_status', 'candidate', 'matched_title', 'matched_filename', 'matched_url']);
foreach ($csvRows as $row) {
    fputcsv($csv, $row);
}
fclose($csv);

echo "Cover pipeline dry-run complete.\n";
echo "Games read: {$summary['total_games_read']}\n";
echo "Supported games: {$summary['supported_games']}\n";
echo "Unsupported games: {$summary['unsupported_games']}\n";
echo "Image status: ";
$imageParts = [];
foreach ($summary['image_status'] as $status => $count) {
    $imageParts[] = "{$status}={$count}";
}
echo implode(', ', $imageParts) . "\n";
foreach ($summary['systems'] as $systemKey => $systemSummary) {
    $matchParts = [];
    foreach ($systemSummary['match_status'] as $status => $count) {
        $matchParts[] = "{$status}={$count}";
    }
    echo strtoupper($systemKey) . ": games={$systemSummary['games']} libretro_entries={$systemSummary['libretro_entries']} matches=" . implode(', ', $matchParts);
    if ($systemSummary['libretro_error'] !== '') {
        echo " error={$systemSummary['libretro_error']}";
    }
    echo "\n";
}
echo "JSON report: {$jsonPath}\n";
echo "CSV report: {$csvPath}\n";
echo "Database updates: 0\n";
echo "Downloads: 0\n";
