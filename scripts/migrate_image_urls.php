<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require __DIR__ . '/../config.php';

$siteRoot = realpath(__DIR__ . '/..');
if ($siteRoot === false) {
    fwrite(STDERR, "Unable to resolve site root.\n");
    exit(1);
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

const IMAGE_URL_OVERRIDES = [
    'å£è¢‹å¦–æ€ª - ç»¿å¶ç‰ˆ' => '/fc/img/å£è¢‹å¦–æ€ªç»¿å¶ç‰ˆ.png',
    'ä¸–ç•Œä¼ è¯´ - æ¢è£…è¿·å®«2ç»¿+ç‰ˆ 64.00' => '/gba/img/ä¸–ç•Œä¼ è¯´ - æ¢è£…è¿·å®«2(CGP)ç»¿+ç‰ˆ 64.00.jpg',
    'ä¾¦æŽ¢å­¦å›­Q - æŒ‘æˆ˜ç©¶æžè¯¡è®¡!å®Œå…¨ç‰ˆ 128.00' => '/gba/img/ä¾¦æŽ¢å­¦å›­Q - æŒ‘æˆ˜ç©¶æžè¯¡è®¡!(nailgo)å®Œå…¨ç‰ˆ 128.00.jpg',
    'æ¶é­”åŸŽä¹‹ä¸‰é¥¶ä¼ å¥‡ åŒäººç‰ˆ 53.00' => '/gba/img/æ¶é­”åŸŽä¹‹ä¸‰é¥¶ä¼ å¥‡ åŒäººç‰ˆ 53.00.jpg',
    'æ•²å‡»æ‰“å¼€å¤©å ‚å¤§é—¨å›¾ç‰‡1.1æ±‰åŒ–ç‰ˆ 128.00' => '/gba/img/æ•²å‡»æ‰“å¼€å¤©å ‚å¤§é—¨(é£Žå°å­)å›¾ç‰‡1.1æ±‰åŒ–ç‰ˆ 128.00.jpg',
    'ç«ç„°çº¹ç«  - åœ£é‚ªçš„æ„å¿—1.4åŒäººç‰ˆ 127.25' => '/gba/img/ç«ç„°çº¹ç«  - åœ£é‚ªçš„æ„å¿—(ç‹¼ç»„+ç«èŠ±å¤©é¾™å‰‘)1.4åŒäººç‰ˆ 127.25.jpg',
    'ç«ç„°çº¹ç«  - å°å°ä¹‹å‰‘v1.1 2006090701ç‰ˆ 64.00' => '/gba/img/ç«ç„°çº¹ç«  - å°å°ä¹‹å‰‘(ç‹¼ç»„+ç«èŠ±å¤©é¾™å‰‘)v1.1 2006090701ç‰ˆ 64.00.jpg',
    'ç«ç„°çº¹ç«  - çƒˆç«ä¹‹å‰‘v1.3 20060908ç‰ˆ' => '/gba/img/ç«ç„°çº¹ç«  - çƒˆç«ä¹‹å‰‘(ç‹¼ç»„+ç«èŠ±å¤©é¾™å‰‘)v1.3 20060908ç‰ˆ.jpg',
    'ç­å“å¡ç¥–ä¼Šæ ¼å…°è’‚çš„å¤ä»‡' => '/gba/img/ç­å“å¡ç¥–ä¼Šæ ¼å…°è’‚çš„å¤ä»‡[Advance-007](v1.01)(ç®€)(70Mb).jpg',
    'çš‡å®¶éª‘å£«å›¢ - åŠ³å¾·æ€çš„éª‘å£«ç®€ä½“ç‰ˆ 64.00' => '/gba/img/çš‡å®¶éª‘å£«å›¢ - åŠ³å¾·æ€çš„éª‘å£«(Då•†)ç®€ä½“ç‰ˆ 64.00.jpg',
    'è¶…çº§æœºå™¨äººå¤§æˆ˜Av1.1' => '/gba/img/è¶…çº§æœºå™¨äººå¤§æˆ˜A(WGF)v1.1.jpg',
    'è¶…çº§æœºå™¨äººå¤§æˆ˜R1.5æ±‰åŒ–ç‰ˆ' => '/gba/img/è¶…çº§æœºå™¨äººå¤§æˆ˜R(å¼ è€æ‰¹)1.5æ±‰åŒ–ç‰ˆ.jpg',
    'é™†è¡Œé¸Ÿå¤§é™†æ±‰åŒ–æµ‹è¯•ç‰ˆv0.1' => '/gba/img/é™†è¡Œé¸Ÿå¤§é™†æ±‰åŒ–æµ‹è¯•ç‰ˆv0.1.jpg',
    'é»„é‡‘å¤ªé˜³ - å¼€å¯çš„å°å°å®Œå…¨å‰§æƒ…ç‰ˆ 71.25' => '/gba/img/é»„é‡‘å¤ªé˜³ - å¼€å¯çš„å°å°(CGP)å®Œå…¨å‰§æƒ…ç‰ˆ 71.25.jpg',
];

function local_path_from_url(string $siteRoot, string $url): string
{
    $path = parse_url($url, PHP_URL_PATH);
    if (!is_string($path) || $path === '') {
        $path = $url;
    }

    $path = rawurldecode(str_replace('\\', '/', $path));
    $path = ltrim($path, '/');

    return $siteRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $path);
}

function asset_url_from_path(string $siteRoot, string $path): string
{
    $relative = substr($path, strlen($siteRoot));
    $relative = str_replace(DIRECTORY_SEPARATOR, '/', $relative);
    $relative = ltrim($relative, '/');

    return '/' . implode('/', array_map('rawurlencode', explode('/', $relative)));
}

function decode_legacy_file(string $encoded): string
{
    $encoded = str_replace(' ', '+', $encoded);
    $encoded = strtr($encoded, '-_', '+/');
    $encoded .= str_repeat('=', (4 - strlen($encoded) % 4) % 4);

    $decoded = base64_decode($encoded, true);
    if ($decoded === false) {
        return '';
    }

    return $decoded;
}

function candidate_stems_from_game_url(string $gameUrl): array
{
    $urlPath = parse_url($gameUrl, PHP_URL_PATH);
    if (!is_string($urlPath)) {
        $urlPath = '';
    }

    $queryString = parse_url($gameUrl, PHP_URL_QUERY);
    $query = [];
    if (is_string($queryString)) {
        parse_str($queryString, $query);
    }

    $relativeFile = '';
    if (isset($query['file']) && is_string($query['file'])) {
        $relativeFile = $query['file'];
    } elseif (isset($query['f']) && is_string($query['f'])) {
        $relativeFile = decode_legacy_file($query['f']);
    } elseif (preg_match('#^/(?:fc|gba)/games/(.+)$#', $urlPath, $matches)) {
        $relativeFile = rawurldecode($matches[1]);
    }

    $relativeFile = trim(str_replace('\\', '/', $relativeFile), '/');
    if ($relativeFile === '' || str_contains($relativeFile, '..')) {
        return [];
    }

    $parts = array_values(array_filter(explode('/', $relativeFile), static fn($part) => $part !== ''));
    if ($parts === []) {
        return [];
    }

    $folderStem = pathinfo($parts[0], PATHINFO_FILENAME);
    $fileStem = pathinfo(end($parts), PATHINFO_FILENAME);

    return array_values(array_unique(array_filter([$fileStem, $folderStem])));
}

function system_from_game_url(string $gameUrl): string
{
    $path = parse_url($gameUrl, PHP_URL_PATH);
    if (!is_string($path)) {
        return '';
    }

    if (preg_match('#^/(fc|gba)(?:/|$)#', $path, $matches)) {
        return $matches[1];
    }

    return '';
}

function resolve_image_url(string $siteRoot, array $game): string
{
    $storedImage = isset($game['image_url']) ? (string) $game['image_url'] : '';
    if ($storedImage !== '' && $storedImage !== '/common-file/img/default-game.jpg') {
        $storedPath = local_path_from_url($siteRoot, $storedImage);
        if (is_file($storedPath)) {
            return asset_url_from_path($siteRoot, $storedPath);
        }
    }

    $gameUrl = isset($game['game_url']) ? (string) $game['game_url'] : '';
    $system = system_from_game_url($gameUrl);
    $stems = candidate_stems_from_game_url($gameUrl);

    $directories = [];
    $extensions = [];
    if ($system === 'fc') {
        $directories = [$siteRoot . DIRECTORY_SEPARATOR . 'fc' . DIRECTORY_SEPARATOR . 'img'];
        $extensions = ['png', 'jpg', 'jpeg'];
    } elseif ($system === 'gba') {
        $directories = [
            $siteRoot . DIRECTORY_SEPARATOR . 'gba' . DIRECTORY_SEPARATOR . 'img',
            $siteRoot . DIRECTORY_SEPARATOR . 'gba' . DIRECTORY_SEPARATOR . 'img_big',
        ];
        $extensions = ['jpg', 'png', 'jpeg'];
    }

    foreach ($directories as $directory) {
        foreach ($stems as $stem) {
            foreach ($extensions as $extension) {
                $candidate = $directory . DIRECTORY_SEPARATOR . $stem . '.' . $extension;
                if (is_file($candidate)) {
                    return asset_url_from_path($siteRoot, $candidate);
                }
            }
        }
    }

    $name = isset($game['name']) ? (string) $game['name'] : '';
    if ($name !== '' && isset(IMAGE_URL_OVERRIDES[$name])) {
        $overrideUrl = IMAGE_URL_OVERRIDES[$name];
        if (is_file(local_path_from_url($siteRoot, $overrideUrl))) {
            return $overrideUrl;
        }
    }

    return '/common-file/img/default-game.jpg';
}

$timestamp = date('Ymd_His');
$backupPath = (getenv('NANDAR_IMPORT_BACKUP_DIR') ?: 'C:\\laragon\\private\\import_backups') . DIRECTORY_SEPARATOR . "image_url_migration_backup_{$timestamp}.json";

$rows = $pdo->query('SELECT id, name, game_url, image_url FROM games ORDER BY id')->fetchAll();
if (!is_dir(dirname($backupPath))) {
    mkdir(dirname($backupPath), 0777, true);
}

file_put_contents(
    $backupPath,
    json_encode([
        'generated_at' => date(DATE_ATOM),
        'database' => $dbname,
        'table' => 'games',
        'rows' => $rows,
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
);

$updates = [];
$fallbacks = 0;
foreach ($rows as $row) {
    $newImageUrl = resolve_image_url($siteRoot, $row);
    if ($newImageUrl === '/common-file/img/default-game.jpg') {
        $fallbacks++;
    }

    if ((string) $row['image_url'] !== $newImageUrl) {
        $updates[] = [
            'id' => (int) $row['id'],
            'old' => (string) $row['image_url'],
            'new' => $newImageUrl,
        ];
    }
}

$pdo->beginTransaction();
try {
    $stmt = $pdo->prepare('UPDATE games SET image_url = :image_url WHERE id = :id');
    foreach ($updates as $update) {
        $stmt->execute([
            ':image_url' => $update['new'],
            ':id' => $update['id'],
        ]);
    }
    $pdo->commit();
} catch (Throwable $exception) {
    $pdo->rollBack();
    throw $exception;
}

echo "Backup: {$backupPath}\n";
echo "Rows scanned: " . count($rows) . "\n";
echo "Rows updated: " . count($updates) . "\n";
echo "Fallback images: {$fallbacks}\n";

