# Script Map

This folder contains the operational tooling for the catalog, ROM imports, and cover pipelines.

## Safe maintenance

### `backup_catalog.php`

Creates a JSON backup of the main catalog tables.

```powershell
php scripts\backup_catalog.php --all
```

### `restore_catalog.php`

Validates and restores a catalog backup. Supports dry-run and makes a pre-restore backup by default.

```powershell
php scripts\restore_catalog.php C:\path\to\catalog_backup.json --dry-run
php scripts\restore_catalog.php C:\path\to\catalog_backup.json --apply --yes
```

### `audit_catalog_integrity.php`

Checks the database and local file references for common integrity problems.

```powershell
php scripts\audit_catalog_integrity.php
```

## Importers

### `import_gba_roms.php`

Imports GBA ROMs into the main catalog.

### `import_gb_gbc_roms.php`

Imports GB and GBC ROMs into the main catalog.

### `import_ps1_chd_folder.php`

Imports PS1 CHD folders and applies PS1 category and bucket logic.

### `import_mame_rom_folder.php`

Imports MAME ZIP romsets into the arcade catalog.

### `import_nes_nandar.php`

Legacy NES and FC importer used during the current project migration.

## Cover pipelines

### `cover_libretro_dry_run.php`

Audits the current image situation and performs exact conservative Libretro matching without changing the database.

### `import_libretro_covers.php`

Downloads safe-match covers, converts them to WebP, and updates `games.image_url`.

### `build_cover_review_queue.php`

Generates review and apply queues for fuzzy cover matching.

### `build_ps1_secondary_cover_queue.php`

Builds secondary PS1 queues from alternate sources such as `Named_Titles` or `Named_Snaps`.

### `build_mame_cover_mapping_review.php`

Builds MAME shortname-to-title review queues before applying covers.

### `apply_reviewed_covers.php`

Applies approved or auto-approved cover rows from a queue CSV.

## Other important helpers

### `ensure_game_url_hash.php`

Backfills or verifies `game_url_hash` support in the catalog.

### `migrate_image_urls.php`

Used for image URL cleanup and migration work.

### `import_webarcade_safe.py`

Environment-specific helper for the Webarcade workflow. Review the hard-coded path assumptions before using it in a new environment.

## Notes

- Most CLI tools require the main `config.php` to be working.
- Many scripts assume Laragon-style local paths unless you override them with environment variables.
- Keep generated caches, backups, and logs out of Git.