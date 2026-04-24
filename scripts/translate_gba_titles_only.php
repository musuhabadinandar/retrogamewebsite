<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require __DIR__ . '/../config.php';

$options = getopt('', ['apply', 'limit::', 'sleep-ms::', 'force']);
$apply = array_key_exists('apply', $options);
$limit = isset($options['limit']) ? max(1, (int) $options['limit']) : 20;
$sleepMs = isset($options['sleep-ms']) ? max(0, (int) $options['sleep-ms']) : 250;
$force = array_key_exists('force', $options);

$cachePath = __DIR__ . '/gba_title_translation_cache.json';

$pdo = new PDO(
    "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
    $username,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);

function contains_cjk(string $text): bool
{
    return preg_match('/[\x{3400}-\x{4DBF}\x{4E00}-\x{9FFF}\x{F900}-\x{FAFF}]/u', $text) === 1;
}

function cleanup_translation(string $text): string
{
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = preg_replace('/\s+/u', ' ', $text) ?? $text;
    $text = str_replace(['ï¼š', 'ï¼Œ', 'ï¼'], [':', ',', '!'], $text);
    $text = trim($text);

    $replacements = [
        'Advance' => 'Advance',
        'G Century' => 'G Generation',
        'Steel bomb' => 'Gundam',
        'Gundam G Century' => 'Gundam G Generation',
        'High -level war' => 'Advance Wars',
        'High-level war' => 'Advance Wars',
        'Dragon Ball Z' => 'Dragon Ball Z',
    ];

    $text = strtr($text, $replacements);
    $text = preg_replace_callback('/\b[a-z][a-zA-Z]*\b/', static function (array $matches): string {
        $lowerWords = ['a', 'an', 'and', 'as', 'at', 'but', 'by', 'for', 'in', 'nor', 'of', 'on', 'or', 'the', 'to', 'vs', 'with'];
        $word = $matches[0];
        if (in_array(strtolower($word), $lowerWords, true)) {
            return strtolower($word);
        }
        return strtoupper($word[0]) . substr($word, 1);
    }, $text) ?? $text;
    $text = preg_replace('/^([a-z])/', strtoupper($text[0]), $text) ?? $text;
    $text = str_replace("'S", "'s", $text);

    return $text;
}

function manual_override(string $text): ?string
{
    $map = [
        '007æœ«æ—¥å±æœº' => '007 Doomsday Crisis',
        'CTç‰¹ç§éƒ¨é˜Ÿ' => 'CT Special Forces',
        'CTç‰¹ç§éƒ¨é˜Ÿ2é‡è¿”æˆ˜å£•' => 'CT Special Forces 2: Back to the Trenches',
        'CTç‰¹ç§éƒ¨é˜Ÿ3-ç”ŸåŒ–ææ€–' => 'CT Special Forces 3: Bioterror',
        'F-Zero - æžé€Ÿä¼ è¯´' => 'F-Zero: Legend of Maximum Speed',
        'KONAMIå¿«ä¹å°èµ›è½¦' => 'Konami Krazy Racers',
        'RPGåˆ¶é€ Advance' => 'RPG Maker Advance',
        'SDé’¢å¼¹Gä¸–çºªAdvance' => 'SD Gundam G Generation Advance',
        'SDé«˜è¾¾Gä¸–çºªA' => 'SD Gundam G Generation Advance',
        'Xæˆ˜è­¦' => 'X-Men',
        'ä¸‰å›½å¿—' => 'Romance of the Three Kingdoms',
        'ä¸‰å›½å¿— - å­”æ˜Žä¼ ' => "Romance of the Three Kingdoms: Kongming's Biography",
        'ä¸‰å›½å¿— - è‹±æ°ä¼ ' => 'Romance of the Three Kingdoms: Heroes',
        'ä¸–ç•Œä¼ è¯´ - å¬å”¤è€…çš„è¡€ç»Ÿ' => "Tales of the World: Summoner's Lineage",
        'ä¸–ç•Œä¼ è¯´ - æ¢è£…è¿·å®«2' => 'Tales of the World: Narikiri Dungeon 2',
        'ä¸–ç•Œä¼ è¯´ - æ¢è£…è¿·å®«2ç»¿+ç‰ˆ 64.00' => 'Tales of the World: Narikiri Dungeon 2 Green+ Edition 64.00',
        'é¾™ç Z - å¸ƒæ¬§çš„æ„¤æ€’' => "Dragon Ball Z: Buu's Fury",
        'é¾™æˆ˜å£«' => 'Breath of Fire',
        'é¾™æˆ˜å£«2' => 'Breath of Fire II',
        'é«˜çº§æˆ˜äº‰' => 'Advance Wars',
        'é»„é‡‘å¤ªé˜³ - å¼€å¯çš„å°å°' => 'Golden Sun',
        'é»„é‡‘å¤ªé˜³ - å¤±è½çš„æ—¶ä»£' => 'Golden Sun: The Lost Age',
    ];

    return $map[$text] ?? null;
}

function translate_with_google_endpoint(string $text): string
{
    $url = 'https://translate.googleapis.com/translate_a/single?' . http_build_query([
        'client' => 'gtx',
        'sl' => 'zh-CN',
        'tl' => 'en',
        'dt' => 't',
        'q' => $text,
    ]);

    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: LaragonLocalTitleTranslator/1.0\r\n",
            'timeout' => 15,
        ],
    ]);

    $body = @file_get_contents($url, false, $context);

    if ($body === false && function_exists('curl_init')) {
        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_USERAGENT => 'LaragonLocalTitleTranslator/1.0',
        ]);
        $body = curl_exec($curl);
        curl_close($curl);
    }

    if (!is_string($body) || $body === '') {
        throw new RuntimeException('Translation request failed.');
    }

    $json = json_decode($body, true);
    if (!is_array($json) || !isset($json[0]) || !is_array($json[0])) {
        throw new RuntimeException('Unexpected translation response.');
    }

    $translated = '';
    foreach ($json[0] as $segment) {
        if (isset($segment[0]) && is_string($segment[0])) {
            $translated .= $segment[0];
        }
    }

    return cleanup_translation($translated);
}

function load_cache(string $cachePath): array
{
    if (!is_file($cachePath)) {
        return [];
    }

    $data = json_decode((string) file_get_contents($cachePath), true);
    return is_array($data) ? $data : [];
}

function save_cache(string $cachePath, array $cache): void
{
    ksort($cache);
    file_put_contents(
        $cachePath,
        json_encode($cache, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
    );
}

function backup_gba_titles(PDO $pdo): string
{
    $backupPath = (getenv('NANDAR_IMPORT_BACKUP_DIR') ?: 'C:\\laragon\\private\\import_backups') . DIRECTORY_SEPARATOR . 'gba_title_translation_backup_' . date('Ymd_His') . '.json';
    $stmt = $pdo->query(
        "SELECT id, name, game_url, image_url, clicks, created_at
         FROM games
         WHERE game_url LIKE '/gba/%'
         ORDER BY id"
    );

    if (!is_dir(dirname($backupPath))) {
        mkdir(dirname($backupPath), 0777, true);
    }

    file_put_contents(
        $backupPath,
        json_encode([
            'generated_at' => date(DATE_ATOM),
            'scope' => 'GBA title display names only',
            'rows' => $stmt->fetchAll(),
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
    );

    return $backupPath;
}

$sql = "SELECT id, name, game_url
        FROM games
        WHERE game_url LIKE '/gba/%'
          AND name REGEXP '[ä¸€-é¿¿]'
        ORDER BY id";
if (!$apply && !$force) {
    $sql .= ' LIMIT ' . $limit;
}

$rows = $pdo->query($sql)->fetchAll();
$cache = load_cache($cachePath);
$translations = [];
$errors = [];

foreach ($rows as $row) {
    $oldName = (string) $row['name'];

    if (!contains_cjk($oldName)) {
        continue;
    }

    try {
        $newName = manual_override($oldName);
        if ($newName === null) {
            if (!isset($cache[$oldName])) {
                $cache[$oldName] = translate_with_google_endpoint($oldName);
                if ($sleepMs > 0) {
                    usleep($sleepMs * 1000);
                }
            }
            $newName = (string) $cache[$oldName];
        } else {
            $cache[$oldName] = $newName;
        }

        $newName = cleanup_translation($newName);
        if ($newName !== '' && $newName !== $oldName) {
            $translations[] = [
                'id' => (int) $row['id'],
                'old' => $oldName,
                'new' => $newName,
            ];
        }
    } catch (Throwable $exception) {
        $errors[] = [
            'id' => (int) $row['id'],
            'name' => $oldName,
            'error' => $exception->getMessage(),
        ];
    }
}

save_cache($cachePath, $cache);

echo $apply ? "Mode: APPLY\n" : "Mode: PREVIEW\n";
echo "Rows scanned: " . count($rows) . "\n";
echo "Translations ready: " . count($translations) . "\n";
echo "Errors: " . count($errors) . "\n";

foreach (array_slice($translations, 0, $limit) as $translation) {
    echo "[{$translation['id']}] {$translation['old']} => {$translation['new']}\n";
}

if ($errors !== []) {
    echo "\nErrors:\n";
    foreach (array_slice($errors, 0, 10) as $error) {
        echo "[{$error['id']}] {$error['name']}: {$error['error']}\n";
    }
}

if (!$apply) {
    echo "\nNo database changes were made. Use --apply --force to update all translated GBA titles.\n";
    exit(0);
}

if (!$force) {
    echo "\nApply mode requires --force so accidental updates do not happen.\n";
    exit(1);
}

$backupPath = backup_gba_titles($pdo);
$stmt = $pdo->prepare('UPDATE games SET name = :name WHERE id = :id');

$pdo->beginTransaction();
try {
    foreach ($translations as $translation) {
        $stmt->execute([
            ':name' => $translation['new'],
            ':id' => $translation['id'],
        ]);
    }
    $pdo->commit();
} catch (Throwable $exception) {
    $pdo->rollBack();
    throw $exception;
}

echo "\nBackup: {$backupPath}\n";
echo "Updated rows: " . count($translations) . "\n";

