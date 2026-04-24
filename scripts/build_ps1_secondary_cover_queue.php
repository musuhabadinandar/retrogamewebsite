<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require __DIR__ . '/../config.php';

function ps1_secondary_arg(array $argv, string $name, ?string $default = null): ?string
{
    $prefix = $name . '=';
    foreach (array_slice($argv, 1) as $arg) {
        if (str_starts_with($arg, $prefix)) {
            return substr($arg, strlen($prefix));
        }
    }
    return $default;
}

function ps1_secondary_mkdir(string $path): void
{
    if (!is_dir($path) && !mkdir($path, 0777, true) && !is_dir($path)) {
        throw new RuntimeException("Unable to create folder: {$path}");
    }
}

function ps1_secondary_slug(string $value): string
{
    $value = strtolower(trim($value));
    $value = preg_replace('/[^a-z0-9._-]+/', '-', $value) ?? $value;
    return trim($value, '-');
}

function ps1_secondary_normalize(string $title): string
{
    $title = html_entity_decode(rawurldecode($title), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $title = preg_replace('/\.[a-z0-9]{2,5}$/i', '', $title) ?? $title;
    $title = str_replace(['_', '+'], ' ', $title);
    $title = strtolower($title);
    $title = str_replace(['&'], [' and '], $title);
    $title = preg_replace('/[^a-z0-9]+/', ' ', $title) ?? $title;
    return trim(preg_replace('/\s+/', ' ', $title) ?? $title);
}

function ps1_secondary_tokens(string $title): array
{
    $tokens = preg_split('/\s+/', ps1_secondary_normalize($title)) ?: [];
    $stop = ['the' => true, 'and' => true, 'of' => true, 'a' => true, 'an' => true, 'to' => true, 'in' => true, 'for' => true, 'no' => true];
    $out = [];
    foreach ($tokens as $token) {
        if (strlen($token) < 3 || isset($stop[$token])) {
            continue;
        }
        $out[$token] = true;
    }
    return array_keys($out);
}

function ps1_secondary_fetch_index(string $cachePath, string $sourceUrl): array
{
    if (is_file($cachePath)) {
        $payload = json_decode((string) file_get_contents($cachePath), true);
        if (is_array($payload) && isset($payload['entries']) && is_array($payload['entries'])) {
            return $payload['entries'];
        }
    }

    $context = stream_context_create([
        'http' => [
            'timeout' => 120,
            'header' => "User-Agent: NandarPS1SecondaryCover/1.0\r\n",
        ],
    ]);
    $html = @file_get_contents($sourceUrl, false, $context);
    if (!is_string($html) || $html === '') {
        throw new RuntimeException("Unable to fetch source listing: {$sourceUrl}");
    }

    preg_match_all('/href="([^"]+\.png)"/i', $html, $matches);
    $entries = [];
    $seen = [];
    foreach ($matches[1] ?? [] as $href) {
        $href = html_entity_decode((string) $href, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if ($href === '' || isset($seen[$href])) {
            continue;
        }
        $seen[$href] = true;
        $filename = basename(rawurldecode($href));
        $title = preg_replace('/\.png$/i', '', $filename) ?? $filename;
        $entries[] = [
            'title' => $title,
            'filename' => $filename,
            'url' => str_starts_with($href, 'http') ? $href : rtrim($sourceUrl, '/') . '/' . ltrim($href, '/'),
        ];
    }

    file_put_contents($cachePath, json_encode([
        'generated_at' => date(DATE_ATOM),
        'source_url' => $sourceUrl,
        'entries' => $entries,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

    return $entries;
}

function ps1_secondary_build_index(array $entries): array
{
    $items = [];
    $tokenMap = [];
    foreach ($entries as $idx => $entry) {
        if (!is_array($entry) || !isset($entry['title'], $entry['url'])) {
            continue;
        }
        $tokens = ps1_secondary_tokens((string) $entry['title']);
        $items[$idx] = [
            'title' => (string) $entry['title'],
            'url' => (string) $entry['url'],
            'normalized' => ps1_secondary_normalize((string) $entry['title']),
            'tokens' => $tokens,
        ];
        foreach ($tokens as $token) {
            $tokenMap[$token][] = $idx;
        }
    }
    return ['items' => $items, 'token_map' => $tokenMap];
}

function ps1_secondary_score(string $query, array $queryTokens, array $candidate): float
{
    similar_text(ps1_secondary_normalize($query), (string) $candidate['normalized'], $similarity);
    $candidateTokens = array_flip($candidate['tokens']);
    $overlap = 0;
    foreach ($queryTokens as $token) {
        if (isset($candidateTokens[$token])) {
            $overlap++;
        }
    }
    $tokenScore = count($queryTokens) > 0 ? ($overlap / count($queryTokens)) * 100 : 0;
    return round(($similarity * 0.7) + ($tokenScore * 0.3), 2);
}

function ps1_secondary_candidates(string $query, array $index, int $limit): array
{
    $tokens = ps1_secondary_tokens($query);
    $candidateIds = [];
    foreach ($tokens as $token) {
        foreach ($index['token_map'][$token] ?? [] as $id) {
            $candidateIds[$id] = true;
        }
    }

    $scored = [];
    foreach (array_keys($candidateIds) as $id) {
        $entry = $index['items'][$id] ?? null;
        if (!is_array($entry)) {
            continue;
        }
        $score = ps1_secondary_score($query, $tokens, $entry);
        if ($score < 45) {
            continue;
        }
        $scored[] = [
            'score' => $score,
            'title' => $entry['title'],
            'url' => $entry['url'],
        ];
    }

    usort($scored, static fn(array $a, array $b): int => $b['score'] <=> $a['score']);
    return array_slice($scored, 0, $limit);
}

$asset = strtolower((string) ps1_secondary_arg($argv, '--asset', 'title'));
if (!in_array($asset, ['title', 'snap'], true)) {
    throw new RuntimeException('Valid assets: title, snap');
}
$candidateLimit = max(1, min(8, (int) ps1_secondary_arg($argv, '--candidates', '5')));
$minScore = (float) ps1_secondary_arg($argv, '--min-score', '70');
$privateRoot = getenv('NANDAR_COVER_PRIVATE_DIR') ?: 'C:\\laragon\\private\\cover_pipeline';
$reportRoot = $privateRoot . DIRECTORY_SEPARATOR . 'reports';
$cacheRoot = $privateRoot . DIRECTORY_SEPARATOR . 'libretro_index_cache';
ps1_secondary_mkdir($reportRoot);
ps1_secondary_mkdir($cacheRoot);

$folder = $asset === 'title' ? 'Named_Titles' : 'Named_Snaps';
$sourceUrl = 'https://thumbnails.libretro.com/Sony%20-%20PlayStation/' . $folder . '/';
$cachePath = $cacheRoot . DIRECTORY_SEPARATOR . 'sony---playstation-' . ps1_secondary_slug(strtolower($folder)) . '.json';
$index = ps1_secondary_build_index(ps1_secondary_fetch_index($cachePath, $sourceUrl));

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

$rows = $pdo->query("SELECT id, name, game_url, image_url FROM games WHERE game_url LIKE '/ps1/%' AND image_url NOT LIKE '/covers/ps1/%' ORDER BY id ASC")->fetchAll();

$timestamp = date('Ymd_His');
$csvPath = $reportRoot . DIRECTORY_SEPARATOR . "ps1_secondary_cover_queue_{$asset}_{$timestamp}.csv";
$csv = fopen($csvPath, 'wb');
if ($csv === false) {
    throw new RuntimeException("Unable to write CSV: {$csvPath}");
}

$headers = ['id', 'system', 'name', 'file', 'image_status', 'original_match_status', 'query', 'review_bucket', 'review_reason', 'review_priority', 'top_score', 'candidate_count'];
for ($i = 1; $i <= $candidateLimit; $i++) {
    $headers[] = "candidate_{$i}_score";
    $headers[] = "candidate_{$i}_title";
    $headers[] = "candidate_{$i}_url";
}
$headers[] = 'decision';
$headers[] = 'review_notes';
fputcsv($csv, $headers);

$approved = 0;
$withCandidates = 0;
foreach ($rows as $row) {
    $query = (string) $row['name'];
    $file = '';
    $queryString = parse_url((string) $row['game_url'], PHP_URL_QUERY);
    if (is_string($queryString)) {
        parse_str($queryString, $params);
        $file = isset($params['file']) && is_string($params['file']) ? $params['file'] : '';
    }

    $candidates = ps1_secondary_candidates($query, $index, $candidateLimit);
    $topScore = isset($candidates[0]) ? (float) $candidates[0]['score'] : 0.0;
    $decision = '';
    $bucket = 'manual_search';
    $reason = 'No fallback candidate above threshold.';
    if ($candidates !== []) {
        $withCandidates++;
        $bucket = $topScore >= $minScore ? 'secondary_auto' : 'secondary_review';
        $reason = $topScore >= $minScore ? 'Secondary source auto-approved by score threshold.' : 'Secondary source candidate found but below threshold.';
        if ($topScore >= $minScore) {
            $decision = 'approve';
            $approved++;
        }
    }

    $line = [
        (string) $row['id'],
        'ps1',
        (string) $row['name'],
        $file,
        'default',
        'secondary_' . $asset,
        $query,
        $bucket,
        $reason,
        $topScore >= $minScore ? 'apply' : 'review',
        $topScore > 0 ? (string) $topScore : '',
        (string) count($candidates),
    ];

    for ($i = 0; $i < $candidateLimit; $i++) {
        $candidate = $candidates[$i] ?? null;
        $line[] = is_array($candidate) ? (string) $candidate['score'] : '';
        $line[] = is_array($candidate) ? (string) $candidate['title'] : '';
        $line[] = is_array($candidate) ? (string) $candidate['url'] : '';
    }

    $line[] = $decision;
    $line[] = $decision === 'approve' ? "auto-approved secondary {$asset}" : '';
    fputcsv($csv, $line);
}

fclose($csv);

echo "PS1 secondary queue generated.\n";
echo "Asset: {$asset}\n";
echo "Rows: " . count($rows) . "\n";
echo "Rows with candidates: {$withCandidates}\n";
echo "Approved: {$approved}\n";
echo "CSV: {$csvPath}\n";
