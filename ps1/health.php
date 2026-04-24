<?php
declare(strict_types=1);

require __DIR__ . '/../config.php';

function is_private_client(string $ip): bool
{
    if (in_array($ip, ['127.0.0.1', '::1'], true)) {
        return true;
    }
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false) {
        return false;
    }
    $long = ip2long($ip);
    return ($long >= ip2long('10.0.0.0') && $long <= ip2long('10.255.255.255'))
        || ($long >= ip2long('172.16.0.0') && $long <= ip2long('172.31.255.255'))
        || ($long >= ip2long('192.168.0.0') && $long <= ip2long('192.168.255.255'));
}

$clientIp = $_SERVER['REMOTE_ADDR'] ?? '';
if (!is_private_client($clientIp)) {
    http_response_code(403);
    echo 'PS1 health check is local-network only.';
    exit;
}

$root = realpath(__DIR__ . '/..');
if ($root === false) {
    http_response_code(500);
    echo 'Unable to resolve site root.';
    exit;
}

$checks = [];
$addCheck = static function (string $name, bool $pass, string $detail) use (&$checks): void {
    $checks[] = [
        'name' => $name,
        'pass' => $pass,
        'detail' => $detail,
        'required' => true,
    ];
};

$addOptionalCheck = static function (string $name, bool $pass, string $detail) use (&$checks): void {
    $checks[] = [
        'name' => $name,
        'pass' => $pass,
        'detail' => $detail,
        'required' => false,
    ];
};

$relativeExists = static function (string $relative) use ($root): bool {
    return is_file($root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative));
};

$isUnsafeGameFilePath = static function (string $file): bool {
    $normalized = str_replace('\\', '/', $file);
    if ($normalized === '' || str_starts_with($normalized, '/') || preg_match('#^[A-Za-z]:/#', $normalized)) {
        return true;
    }
    foreach (explode('/', $normalized) as $part) {
        if ($part === '..') {
            return true;
        }
    }
    return false;
};

$addCheck('PCSX core', $relativeExists('ps1/data/cores/pcsx_rearmed-legacy-wasm.data'), 'ps1/data/cores/pcsx_rearmed-legacy-wasm.data');
$addCheck('PCSX report', $relativeExists('ps1/data/cores/reports/pcsx_rearmed.json'), 'ps1/data/cores/reports/pcsx_rearmed.json');
$addOptionalCheck('Mednafen PSX HW core', $relativeExists('ps1/data/cores/mednafen_psx_hw-legacy-wasm.data'), 'Optional HD Experimental: ps1/data/cores/mednafen_psx_hw-legacy-wasm.data');
$addOptionalCheck('Mednafen PSX HW report', $relativeExists('ps1/data/cores/reports/mednafen_psx_hw.json'), 'Optional HD Experimental: ps1/data/cores/reports/mednafen_psx_hw.json');
$addCheck('CHD MIME header config', str_contains((string) @file_get_contents($root . DIRECTORY_SEPARATOR . '.htaccess'), 'application/x-chd'), '.htaccess contains application/x-chd');
$addCheck('Inline ROM header config', str_contains((string) @file_get_contents($root . DIRECTORY_SEPARATOR . '.htaccess'), 'Content-Disposition "inline"'), '.htaccess sets Content-Disposition inline');

foreach (['scph5500.bin', 'scph5501.bin', 'scph5502.bin', 'scph101.bin', 'scph7001.bin', 'psxonpsp660.bin'] as $bios) {
    $addCheck("BIOS {$bios}", $relativeExists('ps1/bios/' . $bios), 'ps1/bios/' . $bios);
}

foreach (['ps1/games', 'ps1/img', 'ps1/img_big'] as $folder) {
    $path = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $folder);
    $addCheck("Folder {$folder}", is_dir($path), $folder);
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

$ps1Rows = $pdo->query("SELECT id, name, game_url FROM games WHERE game_url LIKE '/ps1/%' ORDER BY id ASC")->fetchAll();
$missing = 0;
foreach ($ps1Rows as $row) {
    $query = parse_url((string) $row['game_url'], PHP_URL_QUERY);
    parse_str(is_string($query) ? $query : '', $params);
    $file = isset($params['file']) && is_string($params['file']) ? $params['file'] : '';
    if ($isUnsafeGameFilePath($file)) {
        $missing++;
        continue;
    }
    $candidate = $root . DIRECTORY_SEPARATOR . 'ps1' . DIRECTORY_SEPARATOR . 'games' . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, str_replace('\\', '/', $file));
    if (!is_file($candidate)) {
        $missing++;
    }
}

$chdFiles = iterator_count(new RegexIterator(
    new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/games', FilesystemIterator::SKIP_DOTS)),
    '/\.chd$/i'
));

$addCheck('PS1 database rows', count($ps1Rows) > 0, count($ps1Rows) . ' rows');
$addCheck('PS1 local CHD files', $chdFiles > 0, $chdFiles . ' CHD files');
$addCheck('PS1 missing local game files', $missing === 0, $missing . ' missing');

$overallPass = array_reduce($checks, static fn(bool $carry, array $check): bool => $carry && (!$check['required'] || $check['pass']), true);

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PS1 Health Check</title>
  <style>
    body { margin: 0; font-family: Arial, sans-serif; background: #10131a; color: #ecf2ff; }
    main { max-width: 980px; margin: 0 auto; padding: 28px; }
    h1 { margin: 0 0 8px; }
    .status { display: inline-block; padding: 8px 12px; border-radius: 999px; font-weight: 700; background: <?= $overallPass ? '#123d2c' : '#4a1b1b' ?>; color: <?= $overallPass ? '#80ffbf' : '#ff9a9a' ?>; }
    table { width: 100%; border-collapse: collapse; margin-top: 22px; background: #171c26; border-radius: 14px; overflow: hidden; }
    th, td { padding: 12px; border-bottom: 1px solid rgba(255,255,255,.08); text-align: left; }
    th { color: #9fb0ca; font-size: 12px; text-transform: uppercase; letter-spacing: .08em; }
    .pass { color: #7cffb5; font-weight: 700; }
    .fail { color: #ff8d8d; font-weight: 700; }
    .note { color: #9fb0ca; line-height: 1.6; }
  </style>
</head>
<body>
<main>
  <h1>PS1 Health Check</h1>
  <p class="note">Read-only local-network diagnostics for EmulatorJS PS1 setup.</p>
  <span class="status"><?= $overallPass ? 'PASS' : 'FAIL' ?></span>
  <table>
    <thead><tr><th>Check</th><th>Status</th><th>Detail</th></tr></thead>
    <tbody>
    <?php foreach ($checks as $check): ?>
      <tr>
        <td><?= htmlspecialchars($check['name']) ?><?= $check['required'] ? '' : ' (optional)' ?></td>
        <td class="<?= $check['pass'] ? 'pass' : 'fail' ?>"><?= $check['pass'] ? 'PASS' : 'FAIL' ?></td>
        <td><?= htmlspecialchars($check['detail']) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</main>
</body>
</html>
