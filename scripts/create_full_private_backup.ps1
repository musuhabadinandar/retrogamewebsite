param(
    [Parameter(Mandatory = $true)]
    [string]$DestinationRoot,
    [switch]$RunCatalogBackup,
    [switch]$IncludeSecrets,
    [switch]$DryRun
)

$ErrorActionPreference = 'Stop'

function BytesToGB([double]$bytes) {
    return [math]::Round($bytes / 1GB, 2)
}

$siteRoot = Split-Path -Parent $PSScriptRoot
$timestamp = Get-Date -Format 'yyyyMMdd_HHmmss'
$backupRoot = Join-Path $DestinationRoot ("retrogamewebsite_full_backup_" + $timestamp)

$includePaths = @(
    'fc\games',
    'gba\games',
    'gb\games',
    'ps1\games',
    'mame\games',
    'covers',
    'config.example.php',
    'database',
    'docs',
    'scripts',
    'common-file',
    'fc\data',
    'gba\data',
    'gb\data',
    'ps1\data',
    'ps1\bios',
    'mame\data',
    'index.php',
    'admin.php',
    'random_game.php',
    'random_game_advanced.php',
    'update_clicks.php',
    '.htaccess',
    '404.html',
    'README.md'
)

if ($IncludeSecrets) {
    $includePaths += 'config.local.php'
    $includePaths += 'pokemon-vn\napthe\credentials.local.php'
}

$totalBytes = 0
$items = @()
foreach ($rel in $includePaths) {
    $full = Join-Path $siteRoot $rel
    if (-not (Test-Path $full)) {
        continue
    }
    if ((Get-Item $full) -is [System.IO.DirectoryInfo]) {
        $bytes = (Get-ChildItem -LiteralPath $full -Recurse -File -ErrorAction SilentlyContinue | Measure-Object -Property Length -Sum).Sum
        if (-not $bytes) { $bytes = 0 }
        $type = 'directory'
    } else {
        $bytes = (Get-Item $full).Length
        $type = 'file'
    }
    $totalBytes += $bytes
    $items += [pscustomobject]@{
        path = $rel
        type = $type
        size_bytes = [int64]$bytes
        size_gb = BytesToGB $bytes
    }
}

$destDrive = Get-PSDrive -PSProvider FileSystem | Where-Object { $DestinationRoot.StartsWith($_.Root, [System.StringComparison]::OrdinalIgnoreCase) } | Sort-Object Root -Descending | Select-Object -First 1
if (-not $destDrive) {
    throw "Destination drive could not be resolved: $DestinationRoot"
}

if (-not (Test-Path $DestinationRoot)) {
    New-Item -ItemType Directory -Path $DestinationRoot -Force | Out-Null
}

$requiredGB = BytesToGB $totalBytes
$freeGB = [math]::Round($destDrive.Free / 1GB, 2)
if (-not $DryRun -and $destDrive.Free -lt $totalBytes) {
    throw "Not enough free space on destination drive. Required: $requiredGB GB, free: $freeGB GB"
}

$manifest = [ordered]@{
    generated_at = (Get-Date).ToString('o')
    source_root = $siteRoot
    destination_root = $backupRoot
    source_commit = ''
    include_secrets = [bool]$IncludeSecrets
    run_catalog_backup = [bool]$RunCatalogBackup
    total_size_gb = $requiredGB
    destination_free_gb = $freeGB
    items = $items
}

try {
    $manifest.source_commit = (git -C $siteRoot rev-parse HEAD).Trim()
} catch {
    $manifest.source_commit = ''
}

if ($DryRun) {
    $manifestPath = Join-Path $DestinationRoot ("retrogamewebsite_full_backup_manifest_" + $timestamp + '.json')
    $manifest | ConvertTo-Json -Depth 6 | Set-Content -Path $manifestPath -Encoding UTF8
    Write-Output "Dry run complete. Manifest written: $manifestPath"
    exit 0
}

New-Item -ItemType Directory -Path $backupRoot -Force | Out-Null
New-Item -ItemType Directory -Path (Join-Path $backupRoot 'source') -Force | Out-Null
New-Item -ItemType Directory -Path (Join-Path $backupRoot 'artifacts') -Force | Out-Null

if ($RunCatalogBackup) {
    $php = 'C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe'
    $catalogOutput = Join-Path $backupRoot 'artifacts\catalog_backup.json'
    & $php (Join-Path $siteRoot 'scripts\backup_catalog.php') $catalogOutput --all
}

foreach ($item in $items) {
    $src = Join-Path $siteRoot $item.path
    $dest = Join-Path (Join-Path $backupRoot 'source') $item.path
    if ($item.type -eq 'directory') {
        New-Item -ItemType Directory -Path $dest -Force | Out-Null
        robocopy $src $dest /E /R:1 /W:1 /NFL /NDL /NJH /NJS /NP | Out-Null
    } else {
        $destDir = Split-Path -Parent $dest
        if (-not (Test-Path $destDir)) { New-Item -ItemType Directory -Path $destDir -Force | Out-Null }
        Copy-Item -LiteralPath $src -Destination $dest -Force
    }
}

$manifestPath = Join-Path $backupRoot 'backup_manifest.json'
$manifest | ConvertTo-Json -Depth 6 | Set-Content -Path $manifestPath -Encoding UTF8
Write-Output "Full private backup created: $backupRoot"
Write-Output "Manifest: $manifestPath"
