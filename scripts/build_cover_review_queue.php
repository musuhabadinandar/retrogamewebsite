<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

function review_arg(array $argv, string $name, ?string $default = null): ?string
{
    $prefix = $name . '=';
    foreach (array_slice($argv, 1) as $arg) {
        if (str_starts_with($arg, $prefix)) {
            return substr($arg, strlen($prefix));
        }
    }
    return $default;
}

function review_mkdir(string $path): void
{
    if (!is_dir($path) && !mkdir($path, 0777, true) && !is_dir($path)) {
        throw new RuntimeException("Unable to create folder: {$path}");
    }
}

function review_latest_report(string $reportRoot): string
{
    $reports = glob($reportRoot . DIRECTORY_SEPARATOR . 'cover_audit_libretro_dry_run_*.csv') ?: [];
    rsort($reports, SORT_STRING);
    if ($reports === []) {
        throw new RuntimeException("No dry-run CSV report found in {$reportRoot}");
    }
    return $reports[0];
}

function review_cache_name(string $libretroSystem): string
{
    $value = strtolower(trim($libretroSystem));
    $value = preg_replace('/[^a-z0-9._-]+/', '-', $value) ?? $value;
    return trim($value, '-') . '-named-boxarts.json';
}

function review_systems(): array
{
    return [
        'nes' => 'Nintendo - Nintendo Entertainment System',
        'ps1' => 'Sony - PlayStation',
    ];
}

function review_clean_title(string $title): string
{
    $title = html_entity_decode(rawurldecode($title), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $title = preg_replace('/\.[a-z0-9]{2,5}$/i', '', $title) ?? $title;
    $title = str_replace(['_', '+'], ' ', $title);
    $title = preg_replace('/\s+/', ' ', $title) ?? $title;
    return trim($title);
}

function review_normalize(string $title): string
{
    $title = review_clean_title($title);
    $title = strtolower($title);
    $title = str_replace(['&'], [' and '], $title);
    $title = preg_replace('/\((?:usa|europe|japan|world|rev[^)]*|beta|proto|demo|disc [^)]+)[^)]*\)/i', ' ', $title) ?? $title;
    $title = preg_replace('/[^a-z0-9]+/', ' ', $title) ?? $title;
    return trim(preg_replace('/\s+/', ' ', $title) ?? $title);
}

function review_tokens(string $title): array
{
    $tokens = preg_split('/\s+/', review_normalize($title)) ?: [];
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

function review_region(string $title): string
{
    if (preg_match('/\((USA|Europe|Japan|World)\)/i', $title, $m)) {
        return strtolower($m[1]);
    }
    return '';
}

function review_load_index(string $cacheRoot, string $libretroSystem): array
{
    $path = $cacheRoot . DIRECTORY_SEPARATOR . review_cache_name($libretroSystem);
    $payload = is_file($path) ? json_decode((string) file_get_contents($path), true) : null;
    $entries = is_array($payload) && isset($payload['entries']) && is_array($payload['entries']) ? $payload['entries'] : [];
    $items = [];
    $tokenMap = [];
    foreach ($entries as $idx => $entry) {
        if (!is_array($entry) || !isset($entry['title'])) {
            continue;
        }
        $title = (string) $entry['title'];
        $tokens = review_tokens($title);
        $items[$idx] = [
            'title' => $title,
            'filename' => (string) ($entry['filename'] ?? ''),
            'url' => str_replace('%25', '%', (string) ($entry['url'] ?? '')),
            'normalized' => review_normalize($title),
            'tokens' => $tokens,
            'region' => review_region($title),
        ];
        foreach ($tokens as $token) {
            $tokenMap[$token][] = $idx;
        }
    }
    return ['items' => $items, 'token_map' => $tokenMap, 'path' => $path];
}

function review_score(string $query, array $queryTokens, string $queryRegion, array $candidate): float
{
    $queryNorm = review_normalize($query);
    $candidateNorm = (string) $candidate['normalized'];
    similar_text($queryNorm, $candidateNorm, $similarity);

    $candidateTokens = array_flip($candidate['tokens']);
    $overlap = 0;
    foreach ($queryTokens as $token) {
        if (isset($candidateTokens[$token])) {
            $overlap++;
        }
    }
    $tokenScore = count($queryTokens) > 0 ? ($overlap / count($queryTokens)) * 100 : 0;
    $regionScore = $queryRegion !== '' && $queryRegion === $candidate['region'] ? 100 : 0;
    return round(($similarity * 0.65) + ($tokenScore * 0.25) + ($regionScore * 0.10), 2);
}

function review_candidates(string $query, array $index, int $maxCandidates): array
{
    $tokens = review_tokens($query);
    $region = review_region($query);
    $candidateIds = [];
    foreach ($tokens as $token) {
        foreach ($index['token_map'][$token] ?? [] as $id) {
            $candidateIds[$id] = true;
        }
    }

    if ($candidateIds === []) {
        return [];
    }

    $scored = [];
    foreach (array_keys($candidateIds) as $id) {
        $entry = $index['items'][$id] ?? null;
        if (!is_array($entry)) {
            continue;
        }
        $score = review_score($query, $tokens, $region, $entry);
        if ($score < 55) {
            continue;
        }
        $scored[] = [
            'score' => $score,
            'title' => $entry['title'],
            'filename' => $entry['filename'],
            'url' => $entry['url'],
        ];
    }
    usort($scored, static fn(array $a, array $b): int => $b['score'] <=> $a['score']);
    return array_slice($scored, 0, $maxCandidates);
}

function review_bucket(string $system, array $candidates): array
{
    if ($candidates === []) {
        return ['no_candidate', 'No fuzzy candidate above threshold.', 'manual_search'];
    }
    $top = (float) $candidates[0]['score'];
    $second = isset($candidates[1]) ? (float) $candidates[1]['score'] : 0.0;
    $gap = $top - $second;
    if ($system === 'ps1') {
        return $top >= 90 && $gap >= 5 ? ['strict_review', 'PS1 fuzzy candidate needs human review.', 'review'] : ['manual_search', 'PS1 score/gap too weak for safe suggestion.', 'manual_search'];
    }
    if ($top >= 92 && $gap >= 6) {
        return ['safe_review', 'High-confidence NES candidate, still review before apply.', 'review'];
    }
    if ($top >= 80) {
        return ['strict_review', 'Medium-confidence NES candidate.', 'review'];
    }
    return ['manual_search', 'Low-confidence candidate.', 'manual_search'];
}

$privateRoot = getenv('NANDAR_COVER_PRIVATE_DIR') ?: 'C:\\laragon\\private\\cover_pipeline';
$reportRoot = $privateRoot . DIRECTORY_SEPARATOR . 'reports';
$cacheRoot = $privateRoot . DIRECTORY_SEPARATOR . 'libretro_index_cache';
$reportPath = (string) review_arg($argv, '--report', review_latest_report($reportRoot));
$systemsArg = strtolower((string) review_arg($argv, '--systems', 'nes,ps1'));
$limitPerSystem = max(1, (int) review_arg($argv, '--limit-per-system', '500'));
$maxCandidates = max(1, min(8, (int) review_arg($argv, '--candidates', '5')));
$htmlLimit = max(0, (int) review_arg($argv, '--html-limit', '1000'));
$systems = array_intersect_key(review_systems(), array_flip(array_filter(array_map('trim', explode(',', $systemsArg)))));
if ($systems === []) {
    throw new RuntimeException('No valid systems selected.');
}

$indexes = [];
foreach ($systems as $system => $libretro) {
    $indexes[$system] = review_load_index($cacheRoot, $libretro);
}

$handle = fopen($reportPath, 'rb');
if ($handle === false) {
    throw new RuntimeException("Unable to read report: {$reportPath}");
}
$headers = fgetcsv($handle);
if (!is_array($headers)) {
    throw new RuntimeException("Invalid report CSV: {$reportPath}");
}

$counts = array_fill_keys(array_keys($systems), 0);
$queue = [];
while (($data = fgetcsv($handle)) !== false) {
    if (!is_array($data) || count($data) < count($headers)) {
        continue;
    }
    $row = array_combine($headers, $data);
    if (!is_array($row)) {
        continue;
    }
    $system = (string) ($row['system'] ?? '');
    if (!isset($systems[$system]) || $counts[$system] >= $limitPerSystem) {
        continue;
    }
    $matchStatus = (string) ($row['match_status'] ?? '');
    if (!in_array($matchStatus, ['normalized_unique', 'ambiguous', 'no_match'], true)) {
        continue;
    }
    $query = (string) (($row['candidate'] ?? '') !== '' ? $row['candidate'] : $row['name']);
    $candidates = review_candidates($query, $indexes[$system], $maxCandidates);
    [$bucket, $reason, $priority] = review_bucket($system, $candidates);
    $queue[] = [
        'id' => (string) $row['id'],
        'system' => $system,
        'name' => (string) $row['name'],
        'file' => (string) $row['file'],
        'image_status' => (string) $row['image_status'],
        'original_match_status' => $matchStatus,
        'query' => $query,
        'review_bucket' => $bucket,
        'review_reason' => $reason,
        'review_priority' => $priority,
        'top_score' => isset($candidates[0]) ? (string) $candidates[0]['score'] : '',
        'candidate_count' => (string) count($candidates),
        'candidates' => $candidates,
    ];
    $counts[$system]++;
}
fclose($handle);

review_mkdir($reportRoot);
$timestamp = date('Ymd_His');
$csvPath = $reportRoot . DIRECTORY_SEPARATOR . "cover_review_queue_libretro_{$timestamp}.csv";
$htmlPath = $reportRoot . DIRECTORY_SEPARATOR . "cover_review_queue_libretro_{$timestamp}.html";

$csv = fopen($csvPath, 'wb');
if ($csv === false) {
    throw new RuntimeException("Unable to write CSV: {$csvPath}");
}
$csvHeaders = ['id', 'system', 'name', 'file', 'image_status', 'original_match_status', 'query', 'review_bucket', 'review_reason', 'review_priority', 'top_score', 'candidate_count'];
for ($i = 1; $i <= $maxCandidates; $i++) {
    $csvHeaders[] = "candidate_{$i}_score";
    $csvHeaders[] = "candidate_{$i}_title";
    $csvHeaders[] = "candidate_{$i}_url";
}
$csvHeaders[] = 'decision';
$csvHeaders[] = 'review_notes';
fputcsv($csv, $csvHeaders);
foreach ($queue as $item) {
    $line = [];
    foreach (array_slice($csvHeaders, 0, 12) as $header) {
        $line[] = $item[$header] ?? '';
    }
    for ($i = 0; $i < $maxCandidates; $i++) {
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

$html = "<!doctype html><meta charset=\"utf-8\"><title>Cover Review Queue</title><style>body{font-family:Arial,sans-serif;background:#10131a;color:#edf2ff;padding:24px}.card{background:#191f2b;border:1px solid #2e3a52;border-radius:14px;padding:16px;margin:14px 0}.candidates{display:flex;gap:12px;flex-wrap:wrap}.cand{width:150px;background:#0f141f;border-radius:10px;padding:8px}img{width:100%;height:120px;object-fit:contain;background:#05070b;border-radius:8px}.muted{color:#9aa8c7}.badge{display:inline-block;padding:4px 8px;border-radius:999px;background:#27446f;margin-right:6px}</style>";
$html .= "<h1>Cover Review Queue</h1><p class=\"muted\">Source: " . htmlspecialchars($reportPath, ENT_QUOTES) . "</p>";
$html .= "<p class=\"muted\">CSV rows: " . count($queue) . ". HTML preview rows: " . ($htmlLimit === 0 ? 0 : min($htmlLimit, count($queue))) . ".</p>";
foreach (($htmlLimit === 0 ? [] : array_slice($queue, 0, $htmlLimit)) as $item) {
    $html .= '<div class="card">';
    $html .= '<h2>#' . htmlspecialchars($item['id'], ENT_QUOTES) . ' ' . htmlspecialchars($item['name'], ENT_QUOTES) . '</h2>';
    $html .= '<p><span class="badge">' . htmlspecialchars($item['system'], ENT_QUOTES) . '</span><span class="badge">' . htmlspecialchars($item['review_bucket'], ENT_QUOTES) . '</span><span class="badge">score ' . htmlspecialchars($item['top_score'], ENT_QUOTES) . '</span></p>';
    $html .= '<p class="muted">' . htmlspecialchars($item['review_reason'], ENT_QUOTES) . '</p><div class="candidates">';
    foreach ($item['candidates'] as $candidate) {
        $html .= '<div class="cand"><img src="' . htmlspecialchars((string) $candidate['url'], ENT_QUOTES) . '"><strong>' . htmlspecialchars((string) $candidate['score'], ENT_QUOTES) . '</strong><br>' . htmlspecialchars((string) $candidate['title'], ENT_QUOTES) . '</div>';
    }
    $html .= '</div></div>';
}
file_put_contents($htmlPath, $html);

echo "Cover review queue generated.\n";
echo "Source report: {$reportPath}\n";
foreach ($counts as $system => $count) {
    echo strtoupper($system) . " queued={$count}\n";
}
echo "CSV: {$csvPath}\n";
echo "HTML: {$htmlPath}\n";
