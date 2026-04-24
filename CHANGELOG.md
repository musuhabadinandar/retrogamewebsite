# Changelog

## 2026-04-24 - Stable restore snapshot

- Prepared the project as a safe public source backup in GitHub.
- Added setup, schema bootstrap, and full-data restore documentation.
- Added private full-backup helper script with manifest and dry-run support.
- Hardened shared config so the public repo uses environment variables or local overrides instead of shipping live local secrets.
- Added example credential files for safer local reconstruction.
- Created release checkpoint and stable restore tag workflow.

## 2026-04-24 - Cover and presentation milestone

- Added premium system fallback artwork for NES, GBA, GB/GBC, PS1, and MAME.
- Expanded GBA local cover coverage with the Libretro pipeline.
- Expanded NES local cover coverage with fuzzy reviewed apply.
- Expanded PS1 local cover coverage through primary and secondary source queues.
- Started MAME cover mapping and apply pipeline.
- Polished homepage and category presentation for clearer system hierarchy and stronger MAME presentation.

## 2026-04-24 - Emulator and catalog stabilization

- Restored broken FC/NES runtime cores after launcher failures.
- Smoke-audited NES, GBA, PS1, and MAME runtime boot flow.
- Fixed category routing so top-level NES / FC and GBA buttons point to the full parent categories instead of only `0-9` buckets.
- Re-synced parent category links for `NES / FC` and `GBA`.
- Imported the one missing GBA file that existed on disk but was not yet in the catalog.

## 2026-04-23 - PS1 and MAME buildout

- Added PS1 launcher improvements, BIOS selector workflow, and visual preset system.
- Imported the PS1 CHD catalog and improved fallback handling.
- Added MAME runtime, importer workflow, and early control/presentation polish.

## 2026-04-22 - Source backup baseline

- Initialized git tracking for the Laragon project snapshot.
- Published the source snapshot to GitHub.
