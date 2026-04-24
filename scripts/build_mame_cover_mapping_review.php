<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require __DIR__ . '/../config.php';
require_once __DIR__ . '/../common-file/php/game_helpers.php';

function mame_arg(array $argv, string $name, ?string $default = null): ?string
{
    $prefix = $name . '=';
    foreach (array_slice($argv, 1) as $arg) {
        if (str_starts_with($arg, $prefix)) {
            return substr($arg, strlen($prefix));
        }
    }
    return $default;
}

function mame_mkdir(string $path): void
{
    if (!is_dir($path) && !mkdir($path, 0777, true) && !is_dir($path)) {
        throw new RuntimeException("Unable to create folder: {$path}");
    }
}

function mame_normalize(string $title): string
{
    $title = html_entity_decode(rawurldecode($title), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $title = strtolower($title);
    $title = str_replace(['&'], [' and '], $title);
    $title = preg_replace('/[^a-z0-9]+/', ' ', $title) ?? $title;
    return trim(preg_replace('/\s+/', ' ', $title) ?? $title);
}

function mame_tokens(string $title): array
{
    $tokens = preg_split('/\s+/', mame_normalize($title)) ?: [];
    $out = [];
    foreach ($tokens as $token) {
        if (strlen($token) >= 2) {
            $out[$token] = true;
        }
    }
    return array_keys($out);
}

function mame_decode_file(string $gameUrl): string
{
    $query = parse_url($gameUrl, PHP_URL_QUERY);
    if (!is_string($query)) {
        return '';
    }
    parse_str($query, $params);
    return isset($params['file']) && is_string($params['file']) ? str_replace('\\', '/', $params['file']) : '';
}

function mame_load_index(string $cacheRoot): array
{
    $path = $cacheRoot . DIRECTORY_SEPARATOR . 'mame-named-boxarts.json';
    $payload = is_file($path) ? json_decode((string) file_get_contents($path), true) : null;
    $entries = is_array($payload) && isset($payload['entries']) && is_array($payload['entries']) ? $payload['entries'] : [];
    $items = [];
    $tokenMap = [];
    foreach ($entries as $idx => $entry) {
        if (!is_array($entry) || !isset($entry['title'])) {
            continue;
        }
        $title = (string) $entry['title'];
        $tokens = mame_tokens($title);
        $items[$idx] = [
            'title' => $title,
            'url' => str_replace('%25', '%', (string) ($entry['url'] ?? '')),
            'normalized' => mame_normalize($title),
            'tokens' => $tokens,
        ];
        foreach ($tokens as $token) {
            $tokenMap[$token][] = $idx;
        }
    }
    return ['items' => $items, 'token_map' => $tokenMap, 'path' => $path];
}

function mame_score(string $query, array $queryTokens, array $candidate): float
{
    similar_text(mame_normalize($query), (string) $candidate['normalized'], $similarity);
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

function mame_candidates(string $query, array $index, int $limit): array
{
    $tokens = mame_tokens($query);
    $ids = [];
    foreach ($tokens as $token) {
        foreach ($index['token_map'][$token] ?? [] as $id) {
            $ids[$id] = true;
        }
    }
    $scored = [];
    foreach (array_keys($ids) as $id) {
        $entry = $index['items'][$id] ?? null;
        if (!is_array($entry)) {
            continue;
        }
        $score = mame_score($query, $tokens, $entry);
        if ($score < 45) {
            continue;
        }
        $scored[] = ['score' => $score, 'title' => $entry['title'], 'url' => $entry['url']];
    }
    usort($scored, static fn(array $a, array $b): int => $b['score'] <=> $a['score']);
    return array_slice($scored, 0, $limit);
}

$privateRoot = getenv('NANDAR_COVER_PRIVATE_DIR') ?: 'C:\\laragon\\private\\cover_pipeline';
$reportRoot = $privateRoot . DIRECTORY_SEPARATOR . 'reports';
$cacheRoot = $privateRoot . DIRECTORY_SEPARATOR . 'libretro_index_cache';
$limit = max(1, (int) mame_arg($argv, '--limit', '500'));
$candidateLimit = max(1, min(8, (int) mame_arg($argv, '--candidates', '5')));
$index = mame_load_index($cacheRoot);

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

$rows = $pdo->query("SELECT id, name, game_url, image_url FROM games WHERE game_url LIKE '/mame/%' ORDER BY id ASC LIMIT {$limit}")->fetchAll();
$queue = [];
foreach ($rows as $row) {
    $file = mame_decode_file((string) $row['game_url']);
    $shortname = pathinfo($file, PATHINFO_FILENAME);
    $query = trim((string) $row['name'] . ' ' . $shortname);
    $candidates = mame_candidates($query, $index, $candidateLimit);
    $top = isset($candidates[0]) ? (float) $candidates[0]['score'] : 0.0;
    $bucket = $top >= 90 ? 'safe_review' : ($top >= 70 ? 'strict_review' : 'manual_search');
    $queue[] = [
        'id' => (string) $row['id'],
        'name' => (string) $row['name'],
        'file' => $file,
        'shortname' => $shortname,
        'image_url' => (string) $row['image_url'],
        'query' => $query,
        'bucket' => $bucket,
        'top_score' => (string) $top,
        'candidates' => $candidates,
    ];
}

mame_mkdir($reportRoot);
$timestamp = date('Ymd_His');
$csvPath = $reportRoot . DIRECTORY_SEPARATOR . "mame_cover_mapping_review_{$timestamp}.csv";
$htmlPath = $reportRoot . DIRECTORY_SEPARATOR . "mame_cover_mapping_review_{$timestamp}.html";

$csv = fopen($csvPath, 'wb');
if ($csv === false) {
    throw new RuntimeException("Unable to write CSV: {$csvPath}");
}
$headers = ['id', 'name', 'file', 'shortname', 'image_url', 'query', 'bucket', 'top_score'];
for ($i = 1; $i <= $candidateLimit; $i++) {
    $headers[] = "candidate_{$i}_score";
    $headers[] = "candidate_{$i}_title";
    $headers[] = "candidate_{$i}_url";
}
$headers[] = 'decision';
$headers[] = 'review_notes';
fputcsv($csv, $headers);
foreach ($queue as $item) {
    $line = [];
    foreach (array_slice($headers, 0, 8) as $header) {
        $line[] = $item[$header] ?? '';
    }
    for ($i = 0; $i < $candidateLimit; $i++) {
        $candidate = $item['candidates'][$i] ?? null;
        $line[] = is_array($candidate) ? $candidate['score'] : '';
        $line[] = is_array($candidate) ? $candidate['title'] : '';
        $line[] = is_array($candidate) ? $candidate['url'] : '';
    }
    $line[] = '';
    $line[] = '';
    fputcsv($csv, $line);
}
fclose($csv);

$html = "<!doctype html><meta charset=\"utf-8\"><title>MAME Cover Mapping Review</title><style>body{font-family:Arial,sans-serif;background:#111;color:#eee;padding:24px}.card{background:#1b1b1b;border:1px solid #333;border-radius:14px;padding:16px;margin:14px 0}.candidates{display:flex;gap:12px;flex-wrap:wrap}.cand{width:150px;background:#0b0b0b;border-radius:10px;padding:8px}img{width:100%;height:120px;object-fit:contain;background:#000;border-radius:8px}.muted{color:#aaa}.badge{display:inline-block;padding:4px 8px;border-radius:999px;background:#375a34;margin-right:6px}</style>";
$html .= "<h1>MAME Cover Mapping Review</h1><p class=\"muted\">Index: " . htmlspecialchars($index['path'], ENT_QUOTES) . "</p>";
foreach ($queue as $item) {
    $html .= '<div class="card"><h2>#' . htmlspecialchars($item['id'], ENT_QUOTES) . ' ' . htmlspecialchars($item['name'], ENT_QUOTES) . '</h2>';
    $html .= '<p><span class="badge">' . htmlspecialchars($item['shortname'], ENT_QUOTES) . '</span><span class="badge">' . htmlspecialchars($item['bucket'], ENT_QUOTES) . '</span><span class="badge">score ' . htmlspecialchars($item['top_score'], ENT_QUOTES) . '</span></p><div class="candidates">';
    foreach ($item['candidates'] as $candidate) {
        $html .= '<div class="cand"><img src="' . htmlspecialchars((string) $candidate['url'], ENT_QUOTES) . '"><strong>' . htmlspecialchars((string) $candidate['score'], ENT_QUOTES) . '</strong><br>' . htmlspecialchars((string) $candidate['title'], ENT_QUOTES) . '</div>';
    }
    $html .= '</div></div>';
}
file_put_contents($htmlPath, $html);

echo "MAME mapping review generated.\n";
echo "Games queued: " . count($queue) . "\n";
echo "CSV: {$csvPath}\n";
echo "HTML: {$htmlPath}\n";

