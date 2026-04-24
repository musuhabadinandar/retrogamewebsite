# Setup Guide

This project was originally developed under Laragon on Windows. The easiest path is still:

- Apache or Nginx
- PHP 8.0+
- MySQL or MariaDB
- A writable local filesystem for ROM imports and cover generation

## 1. Clone location

Recommended Windows path:

```text
C:\laragon\www\retrogamewebsite
```

## 2. Main configuration

The main portal reads config from:

- `config.php`
- optional local override `config.local.php`

Supported environment variables:

- `NANDAR_DB_HOST`
- `NANDAR_DB_NAME`
- `NANDAR_DB_USER`
- `NANDAR_DB_PASS`
- `NANDAR_ADMIN_USER`
- `NANDAR_ADMIN_PASS_HASH`

Recommended local setup:

1. Copy `config.example.php` to `config.local.php`.
2. Replace the admin hash with your own value.
3. Keep `config.local.php` out of source control.

## 3. Pokemon VN configuration

Pokemon VN keeps its main bootstrap in `pokemon-vn/templates/config.php`.

Supported environment variables:

- `POKEMON_DB_HOST`
- `POKEMON_DB_USER`
- `POKEMON_DB_PASS`
- `POKEMON_DB_NAME`

Card charging is optional and reads:

- `POKEMON_CARD_MERCHANT_ID`
- `POKEMON_CARD_API_USER`
- `POKEMON_CARD_API_PASSWORD`

Optional local override file:

- `pokemon-vn/napthe/credentials.local.php`

You can start without card charging. The page now fails safely when those credentials are missing.

## 4. ROM directories

This repository does not include ROM libraries. Create or restore these folders locally:

```text
fc\games\
gba\games\
gb\games\
ps1\games\
mame\games\
```

## 5. Catalog database

The main site expects a `games`, `categories`, and `game_category` schema. The safest workflow is:

1. Restore from a local catalog backup if you have one.
2. Or re-import your ROMs with the scripts in `scripts/`.

Useful commands:

```powershell
php scripts\backup_catalog.php --all
php scripts\restore_catalog.php C:\path\to\catalog_backup.json --dry-run
php scripts\restore_catalog.php C:\path\to\catalog_backup.json --apply --yes
php scripts\audit_catalog_integrity.php
```

## 6. Import workflows

Examples:

```powershell
php scripts\import_gba_roms.php C:\path\to\gba\roms --apply
php scripts\import_gb_gbc_roms.php C:\path\to\gb\roms --apply
php scripts\import_ps1_chd_folder.php C:\path\to\ps1\chd --apply
php scripts\import_mame_rom_folder.php C:\path\to\mame\roms --apply
```

## 7. Cover workflows

The cover system supports dry-run matching, reviewed apply, and secondary PS1 sources.

Examples:

```powershell
php scripts\cover_libretro_dry_run.php --system=gba
php scripts\import_libretro_covers.php --system=gba --limit=100 --apply
php scripts\build_cover_review_queue.php --system=nes
php scripts\build_ps1_secondary_cover_queue.php --source=title
php scripts\apply_reviewed_covers.php C:\path\to\queue.csv --apply
```

## 8. Audit after any large change

After a restore, import, or cover batch:

```powershell
php scripts\audit_catalog_integrity.php
```

This is the quickest way to confirm:

- no orphan category links
- no duplicate `game_url`
- no missing local game files
- no missing local images