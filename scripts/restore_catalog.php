<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require __DIR__ . '/../config.php';

$backupPath = $argv[1] ?? '';
$dryRun = in_array('--dry-run', $argv, true);
$apply = in_array('--apply', $argv, true);
$confirmed = in_array('--yes', $argv, true);
$skipPreBackup = in_array('--skip-pre-backup', $argv, true);

if ($backupPath === '' || (!$dryRun && (!$apply || !$confirmed))) {
    fwrite(STDERR, "Usage:\n");
    fwrite(STDERR, "  php scripts/restore_catalog.php <backup.json> --dry-run\n");
    fwrite(STDERR, "  php scripts/restore_catalog.php <backup.json> --apply --yes\n");
    fwrite(STDERR, "Optional: --skip-pre-backup\n");
    fwrite(STDERR, "Apply mode replaces tables included in the backup after checksum validation.\n");
    exit(1);
}

if (!is_file($backupPath)) {
    fwrite(STDERR, "Backup file not found: {$backupPath}\n");
    exit(1);
}

$payload = json_decode((string) file_get_contents($backupPath), true);
if (!is_array($payload) || !isset($payload['tables']) || !is_array($payload['tables'])) {
    fwrite(STDERR, "Invalid backup format.\n");
    exit(1);
}

if (($payload['schema_version'] ?? '') !== 'catalog-backup-v2') {
    fwrite(STDERR, "Unsupported or missing schema_version. Expected catalog-backup-v2.\n");
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

function current_writable_columns(PDO $pdo, string $table): array
{
    $columns = [];
    foreach ($pdo->query("SHOW COLUMNS FROM `{$table}`") as $column) {
        $extra = strtolower((string) ($column['Extra'] ?? ''));
        if (str_contains($extra, 'generated')) {
            continue;
        }
        $columns[(string) $column['Field']] = true;
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

function validate_table_payload(string $table, array $tablePayload): void
{
    if (!isset($tablePayload['columns'], $tablePayload['rows'], $tablePayload['row_count'], $tablePayload['checksum'])) {
        throw new RuntimeException("Table {$table} is missing columns, rows, row_count, or checksum.");
    }
    if (!is_array($tablePayload['columns']) || !is_array($tablePayload['rows'])) {
        throw new RuntimeException("Table {$table} has invalid columns or rows.");
    }
    if ((int) $tablePayload['row_count'] !== count($tablePayload['rows'])) {
        throw new RuntimeException("Table {$table} row_count does not match rows.");
    }

    $actualChecksum = hash('sha256', json_encode([
        'columns' => $tablePayload['columns'],
        'rows' => $tablePayload['rows'],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

    if (!hash_equals((string) $tablePayload['checksum'], $actualChecksum)) {
        throw new RuntimeException("Table {$table} checksum mismatch.");
    }
}

function backup_current_catalog_before_restore(string $siteRoot): string
{
    $backupPath = (getenv('NANDAR_BACKUP_DIR') ?: 'C:\\laragon\\private\\catalog_backups') . DIRECTORY_SEPARATOR . 'pre_restore_backup_' . date('Ymd_His') . '.json';
    if (!is_dir(dirname($backupPath))) {
        mkdir(dirname($backupPath), 0777, true);
    }
    $command = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg(__DIR__ . DIRECTORY_SEPARATOR . 'backup_catalog.php') . ' ' . escapeshellarg($backupPath) . ' --all';
    exec($command, $output, $exitCode);

    if ($exitCode !== 0 || !is_file($backupPath)) {
        throw new RuntimeException("Failed to create pre-restore backup.");
    }

    return $backupPath;
}

function insert_rows(PDO $pdo, string $table, array $tablePayload): int
{
    $currentColumns = current_writable_columns($pdo, $table);
    $rows = isset($tablePayload['rows']) && is_array($tablePayload['rows']) ? $tablePayload['rows'] : [];
    $count = 0;

    foreach ($rows as $row) {
        if (!is_array($row)) {
            continue;
        }

        $columns = array_values(array_filter(array_keys($row), static fn(string $column): bool => isset($currentColumns[$column])));
        if (empty($columns)) {
            continue;
        }

        $quoted = array_map(static fn(string $column): string => "`{$column}`", $columns);
        $placeholders = array_map(static fn(string $column): string => ':' . $column, $columns);
        $stmt = $pdo->prepare("INSERT INTO `{$table}` (" . implode(', ', $quoted) . ') VALUES (' . implode(', ', $placeholders) . ')');
        $params = [];
        foreach ($columns as $column) {
            $params[':' . $column] = $row[$column];
        }
        $stmt->execute($params);
        $count++;
    }

    return $count;
}

$requiredTables = ['categories', 'games', 'game_category'];
foreach ($requiredTables as $table) {
    if (!isset($payload['tables'][$table])) {
        fwrite(STDERR, "Backup is missing table: {$table}\n");
        exit(1);
    }
}

$allowedTables = ['categories', 'games', 'game_category', 'click_stats', 'webarcade_users', 'webarcade_cloud_saves'];
$restoreTables = [];
foreach ($allowedTables as $table) {
    if (isset($payload['tables'][$table])) {
        validate_table_payload($table, $payload['tables'][$table]);
        $restoreTables[] = $table;
    }
}

if (!empty($payload['manifest_checksum'])) {
    $manifestSource = [];
    foreach ($payload['tables'] as $table => $tablePayload) {
        $manifestSource[$table] = [
            'row_count' => $tablePayload['row_count'] ?? null,
            'checksum' => $tablePayload['checksum'] ?? null,
        ];
    }
    $actualManifest = hash('sha256', json_encode($manifestSource, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    if (!hash_equals((string) $payload['manifest_checksum'], $actualManifest)) {
        fwrite(STDERR, "Manifest checksum mismatch.\n");
        exit(1);
    }
}

foreach ($restoreTables as $table) {
    if (!table_exists($pdo, $table)) {
        fwrite(STDERR, "Backup includes table {$table}, but it does not exist in this database.\n");
        exit(1);
    }
}

echo "Backup file: {$backupPath}\n";
echo "Schema version: {$payload['schema_version']}\n";
echo "Mode: " . ($dryRun ? 'dry-run' : 'apply') . "\n";
foreach ($restoreTables as $table) {
    echo "{$table}: " . (int) $payload['tables'][$table]['row_count'] . " rows checksum=" . $payload['tables'][$table]['checksum'] . "\n";
}
echo "Checksum validation: PASS\n";

if ($dryRun) {
    echo "Dry run complete. No database changes were made.\n";
    exit(0);
}

$siteRoot = realpath(__DIR__ . '/..');
if ($siteRoot === false) {
    fwrite(STDERR, "Unable to resolve site root.\n");
    exit(1);
}

if (!$skipPreBackup) {
    $preRestoreBackup = backup_current_catalog_before_restore($siteRoot);
    echo "Pre-restore backup written: {$preRestoreBackup}\n";
}

$pdo->beginTransaction();
try {
    $pdo->exec('SET FOREIGN_KEY_CHECKS=0');
    foreach (array_reverse($restoreTables) as $table) {
        $pdo->exec("DELETE FROM `{$table}`");
    }

    $restored = [];
    foreach ($restoreTables as $table) {
        $restored[$table] = insert_rows($pdo, $table, $payload['tables'][$table]);
    }

    $pdo->exec('SET FOREIGN_KEY_CHECKS=1');
    $pdo->commit();
} catch (Throwable $exception) {
    $pdo->rollBack();
    $pdo->exec('SET FOREIGN_KEY_CHECKS=1');
    fwrite(STDERR, "Restore failed: {$exception->getMessage()}\n");
    exit(1);
}

echo "Restore complete.\n";
foreach ($restored as $table => $count) {
    echo "{$table}: {$count}\n";
}

