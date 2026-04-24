# Full Data Install and Rebuild Guide

This guide is for restoring the complete working site, including large local ROM/CHD data that is intentionally excluded from GitHub.

## Current local library snapshot

At the time this backup guide was created, the live local catalog contains:

- NES / FC: 16,436
- GBA: 4,559
- GB / GBC: 26
- PS1: 1,459
- MAME: 281
- Total catalog rows: 22,761

The local media footprint is a little over 100 GB, mostly from:

- `ps1/games`
- `gba/games`
- `fc/games`
- `mame/games`

## Recommended disaster-recovery package

A full private backup should contain all of these parts together:

1. GitHub source snapshot from this repository
2. Catalog database backup JSON
3. ROM and CHD libraries
4. Generated local cover library
5. Local override credentials and config files
6. Optional Pokemon VN database dump and credentials if you use that app

## Folder groups that matter

### Main source snapshot

Clone this repo first:

```powershell
git clone https://github.com/musuhabadinandar/retrogamewebsite.git
```

### Main media libraries

Restore these folders into the project root:

```text
fc\games\
gba\games\
gb\games\
ps1\games\
mame\games\
```

### Covers

Restore:

```text
covers\
```

### Local config

Restore or recreate:

```text
config.local.php
pokemon-vn\napthe\credentials.local.php
```

### Database

Bootstrap schema from:

```text
database\schema.sql
```

Then restore a catalog backup JSON using:

```powershell
php scripts\restore_catalog.php C:\path\to\catalog_backup.json --apply --yes
```

## Fastest full rebuild path

1. Clone repo from GitHub.
2. Restore `config.local.php`.
3. Restore private ROM folders.
4. Restore `covers\`.
5. Create database from `database\schema.sql`.
6. Restore latest `catalog_backup_*.json` or `pre_restore_backup_*.json`.
7. Run integrity audit.

```powershell
php scripts\audit_catalog_integrity.php
```

## If you do not have a catalog backup

You can still rebuild from ROM folders, but it takes longer:

1. Import NES/FC
2. Import GBA
3. Import GB/GBC
4. Import PS1
5. Import MAME
6. Rebuild covers from the cover scripts

This is slower than restoring the catalog JSON.

## Recommended private backup workflow

Use the PowerShell helper script:

```powershell
powershell -ExecutionPolicy Bypass -File scripts\create_full_private_backup.ps1 -DestinationRoot E:\RetroBackups -RunCatalogBackup -IncludeSecrets
```

That script will:

- create a timestamped backup folder
- export a fresh catalog backup JSON if requested
- mirror the large media folders with `robocopy`
- write a manifest file with commit hash and included paths

## Important note about storage

A full offline backup needs a destination with plenty of free space. The current local machine does not have enough free space on `C:` to make a second full copy on the same drive.

Use one of these instead:

- external SSD or HDD
- network share
- cloud sync folder on a different volume
- NAS

## Post-restore verification checklist

After restoring everything:

```powershell
php scripts\audit_catalog_integrity.php
```

Check manually:

1. Homepage loads
2. NES launches
3. GBA launches
4. PS1 launches
5. MAME launches
6. Covers appear in category pages
7. Admin login works with your local admin credentials