<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require __DIR__ . '/../config.php';

$privateBackupRoot = getenv('NANDAR_BACKUP_DIR') ?: 'C:\\laragon\\private\\catalog_backups';
$siteRoot = realpath(__DIR__ . '/..');
if ($siteRoot === false) {
    fwrite(STDERR, "Unable to resolve site root.\n");
    exit(1);
}

$includeClickStats = in_array('--include-click-stats', $argv, true) || in_array('--all', $argv, true);
$includeWebarcade = in_array('--include-webarcade', $argv, true) || in_array('--all', $argv, true);
$explicitOutput = '';

foreach (array_slice($argv, 1) as $arg) {
    if (!str_starts_with($arg, '--')) {
        $explicitOutput = $arg;
        break;
    }
}

$output = $explicitOutput !== '' ? $explicitOutput : ($privateBackupRoot . DIRECTORY_SEPARATOR . 'catalog_backup_' . date('Ymd_His') . '.json');

$pdo = new PDO(
    "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
    $username,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);

function writable_columns(PDO $pdo, string $table): array
{
    $columns = [];
    foreach ($pdo->query("SHOW COLUMNS FROM `{$table}`") as $column) {
        $extra = strtolower((string) ($column['Extra'] ?? ''));
        if (str_contains($extra, 'generated')) {
            continue;
        }
        $columns[] = (string) $column['Field'];
    }
    return $columns;
}

function table_exists(PDO $pdo, string $table): bool
{
    $stmt = $pdo->prepare(
        "SELECT COUNT(*)
         FROM information_schema.tables
         WHERE table_schema = DATABASE()
           AND table_name = :table"
    );
    $stmt->execute([':table' => $table]);
    return (int) $stmt->fetchColumn() > 0;
}

function dump_table(PDO $pdo, string $table, string $orderBy): array
{
    $columns = writable_columns($pdo, $table);
    $quoted = array_map(static fn(string $column): string => "`{$column}`", $columns);
    $rows = $pdo->query('SELECT ' . implode(', ', $quoted) . " FROM `{$table}` ORDER BY {$orderBy}")->fetchAll();

    $tablePayload = [
        'columns' => $columns,
        'rows' => $rows,
    ];

    $tablePayload['row_count'] = count($rows);
    $tablePayload['checksum'] = hash('sha256', json_encode([
        'columns' => $tablePayload['columns'],
        'rows' => $tablePayload['rows'],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

    return $tablePayload;
}

$tables = [
    'categories' => '`id` ASC',
    'games' => '`id` ASC',
    'game_category' => '`game_id` ASC, `category_id` ASC',
];

if ($includeClickStats && table_exists($pdo, 'click_stats')) {
    $tables['click_stats'] = '`id` ASC';
}

if ($includeWebarcade) {
    foreach (['webarcade_users', 'webarcade_cloud_saves'] as $table) {
        if (table_exists($pdo, $table)) {
            $tables[$table] = '`id` ASC';
        }
    }
}

$payload = [
    'schema_version' => 'catalog-backup-v2',
    'generated_at' => date(DATE_ATOM),
    'database' => $dbname,
    'options' => [
        'include_click_stats' => $includeClickStats,
        'include_webarcade' => $includeWebarcade,
    ],
    'tables' => [],
];

foreach ($tables as $table => $orderBy) {
    $payload['tables'][$table] = dump_table($pdo, $table, $orderBy);
}

$manifestSource = [];
foreach ($payload['tables'] as $table => $tablePayload) {
    $manifestSource[$table] = [
        'row_count' => $tablePayload['row_count'],
        'checksum' => $tablePayload['checksum'],
    ];
}
$payload['manifest_checksum'] = hash('sha256', json_encode($manifestSource, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

if (!is_dir(dirname($output)) && !mkdir(dirname($output), 0777, true) && !is_dir(dirname($output))) {
    fwrite(STDERR, "Unable to create backup folder: " . dirname($output) . "\n");
    exit(1);
}

file_put_contents($output, json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo "Backup written: {$output}\n";
echo "Schema version: {$payload['schema_version']}\n";
foreach ($payload['tables'] as $table => $tablePayload) {
    echo "{$table}: {$tablePayload['row_count']} rows checksum={$tablePayload['checksum']}\n";
}
echo "Manifest checksum: {$payload['manifest_checksum']}\n";

