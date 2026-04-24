# AI Restore Notes

This file is meant for future AI agents or automation systems that need to rebuild this project quickly and safely.

## First truth to remember

The GitHub repository is not the full machine image.

It contains:

- source code
- docs
- schema bootstrap
- cover pipeline logic
- many generated local covers

It does not contain:

- the full ROM and CHD library
- local secret override files

## Current known project shape

Main systems:

- NES / FC
- GBA
- GB / GBC
- PS1
- MAME
- optional Pokemon VN side app

Important root files:

- `config.php`
- `config.example.php`
- `README.md`
- `CHANGELOG.md`
- `database/schema.sql`

Important docs:

- `docs/SETUP.md`
- `docs/INSTALL_FULL_DATA.md`
- `docs/RESTORE_SMOKE_CHECKLIST.md`
- `docs/GITHUB_ONLY_BACKUP_NOTES.md`
- `scripts/README.md`

## Fast rebuild order

1. Clone repository
2. Create `config.local.php`
3. Apply `database/schema.sql`
4. Restore catalog backup if available
5. Restore ROM folders if available
6. Restore `covers/`
7. Run catalog integrity audit
8. Smoke-check homepage + one game per system

## Best path when private media exists

If the operator has the large private media backup, restore these first:

- `fc/games`
- `gba/games`
- `gb/games`
- `ps1/games`
- `mame/games`
- `covers`

Then restore the catalog backup JSON with:

```powershell
php scripts\restore_catalog.php C:\path\to\catalog_backup.json --apply --yes
```

Then run:

```powershell
php scripts\audit_catalog_integrity.php
```

## Best path when private media does not exist

Rebuild in this order:

1. import NES / FC
2. import GBA
3. import GB / GBC
4. import PS1
5. import MAME
6. rebuild covers

This is slower and depends on the operator having the raw source ROM folders elsewhere.

## Cover system notes

Known cover sources/workflows in this project:

- conservative Libretro dry-run
- safe-match import apply
- fuzzy reviewed queue apply
- PS1 secondary queues from title/snap
- MAME shortname review mapping

Important scripts:

- `scripts/cover_libretro_dry_run.php`
- `scripts/import_libretro_covers.php`
- `scripts/build_cover_review_queue.php`
- `scripts/build_ps1_secondary_cover_queue.php`
- `scripts/build_mame_cover_mapping_review.php`
- `scripts/apply_reviewed_covers.php`

## High-risk files

These affect runtime directly:

- `fc/data/cores/*`
- `gba/data/cores/*`
- `gb/data/cores/*`
- `ps1/data/cores/*`
- `mame/data/cores/*`
- `ps1/play.html`
- `mame/play.html`
- `common-file/php/game_helpers.php`
- `index.php`

## Known operational habits

- The project is Windows/Laragon-oriented.
- Local path assumptions appear in several scripts.
- Full private backups should be done outside GitHub.
- GitHub is the source checkpoint and documentation anchor.

## Minimum restore success definition

An AI should consider the restore successful when:

1. `php scripts\audit_catalog_integrity.php` returns `status=PASS`
2. homepage loads
3. one NES game boots
4. one GBA game boots
5. one PS1 game boots
6. one MAME game boots
7. category pages show covers or premium fallbacks cleanly

## If something breaks

Use this order:

1. inspect `config.local.php`
2. verify database/schema
3. verify ROM folder placement
4. verify BIOS for PS1
5. run integrity audit
6. inspect recent changes in `index.php`, helpers, launcher pages, and core files
