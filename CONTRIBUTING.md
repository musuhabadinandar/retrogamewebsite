# Contributing

Thanks for helping improve this retro game website project.

This repository is a source snapshot and rebuild control center for the Laragon project, not a complete ROM mirror.

## Core rules

1. Do not commit ROM or CHD libraries into normal Git history.
2. Do not commit `config.local.php`, card credentials, or any other live secrets.
3. Do not commit private backup folders from outside the repo.
4. Prefer reversible changes and document operational impact.
5. After large import, restore, or cover changes, run the catalog audit.

## What should stay out of Git

- `fc/games`
- `gba/games`
- `gb/games`
- `ps1/games`
- `mame/games`
- `config.local.php`
- `pokemon-vn/napthe/credentials.local.php`
- generated local caches and backup artifacts

## Recommended contribution flow

1. Pull the latest `main`.
2. Make a focused change.
3. Update docs if the workflow changed.
4. Run:

```powershell
php scripts\audit_catalog_integrity.php
```

5. Smoke-check the affected system or page.
6. Commit with a clear message.

## If you touch import or restore logic

Please update the relevant docs too:

- `README.md`
- `docs/SETUP.md`
- `docs/INSTALL_FULL_DATA.md`
- `docs/RESTORE_SMOKE_CHECKLIST.md`
- `scripts/README.md`

## If you touch cover pipelines

Document:

- source used
- exact vs fuzzy logic
- thresholds
- whether the change is safe-match only or may add “pemanis” covers

## If you touch emulator runtime files

Be careful with:

- `fc/data`
- `gba/data`
- `gb/data`
- `ps1/data`
- `mame/data`

Those files affect boot behavior directly.

## Preferred safety checks

At minimum:

```powershell
php scripts\audit_catalog_integrity.php
```

And then manually verify at least:

- homepage
- one NES game
- one GBA game
- one PS1 game
- one MAME game

## Notes for collaborators

- This project was built around Laragon on Windows.
- Many scripts assume Windows paths unless documented otherwise.
- The GitHub repo is the source checkpoint, not the complete media archive.
