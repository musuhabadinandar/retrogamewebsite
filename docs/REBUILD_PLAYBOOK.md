# Rebuild Playbook

This playbook is for the worst-case scenario:

- the server is gone
- the Laragon folder is gone
- the database is gone
- we need to rebuild the site from scratch as fast and safely as possible

This document is intentionally operational and ordered.

## Mission goal

Restore a usable state where:

1. homepage loads
2. admin works
3. NES boots
4. GBA boots
5. PS1 boots
6. MAME boots
7. covers show correctly
8. integrity audit returns `PASS`

## Inputs you should gather first

Before touching anything, try to collect these:

### Best case

- GitHub repo source:
  - `https://github.com/musuhabadinandar/retrogamewebsite`
- latest stable release/tag
- latest catalog backup JSON
- full ROM/CHD backup
- `config.local.php`
- `pokemon-vn/napthe/credentials.local.php` if Pokemon payment flow matters

### Acceptable fallback

- GitHub repo source
- raw ROM folders from other storage
- enough information to recreate DB credentials

## Phase 1: rebuild the codebase

1. Install Laragon or equivalent PHP + MySQL stack.
2. Clone the repo into a web root:

```powershell
git clone https://github.com/musuhabadinandar/retrogamewebsite.git C:\laragon\www\retrogamewebsite
```

3. Checkout the latest stable restore point if needed:

```powershell
git checkout stable-restore-point-2026-04-24
```

4. Confirm these files exist:

- `README.md`
- `config.example.php`
- `database/schema.sql`
- `docs/SETUP.md`
- `docs/INSTALL_FULL_DATA.md`
- `docs/RESTORE_SMOKE_CHECKLIST.md`

## Phase 2: rebuild configuration

1. Create `config.local.php` from `config.example.php`.
2. Set:

- DB host
- DB name
- DB user
- DB password
- admin username
- admin password hash

3. If Pokemon VN is needed, restore:

- `pokemon-vn/napthe/credentials.local.php`

Or set these environment variables:

- `POKEMON_CARD_MERCHANT_ID`
- `POKEMON_CARD_API_USER`
- `POKEMON_CARD_API_PASSWORD`

## Phase 3: rebuild database

### Fastest path

1. Create the database.
2. Apply:

```powershell
mysql -u root -p gba < database\schema.sql
```

3. Restore the latest catalog backup:

```powershell
php scripts\restore_catalog.php C:\path\to\catalog_backup.json --apply --yes
```

### Slower path if backup JSON is missing

1. Apply `database/schema.sql`.
2. Re-import ROMs using the importer scripts.
3. Rebuild covers.

This works, but takes much longer.

## Phase 4: restore media

Restore these folders into the project root if you have the private media backup:

```text
fc\games\
gba\games\
gb\games\
ps1\games\
mame\games\
covers\
```

If you do not have them all, prioritize in this order:

1. `fc/games`
2. `gba/games`
3. `ps1/games`
4. `mame/games`
5. `gb/games`
6. `covers`

## Phase 5: restore system-critical runtime assets

Check these folders carefully:

- `fc/data`
- `gba/data`
- `gb/data`
- `ps1/data`
- `ps1/bios`
- `mame/data`

Especially for PS1:

- verify BIOS files exist in `ps1/bios`
- verify PS1 core files exist in `ps1/data/cores`

## Phase 6: first integrity pass

Run:

```powershell
php scripts\audit_catalog_integrity.php
```

Desired result:

- `status=PASS`
- `missing_local_game_files=0`
- `missing_local_images=0`

If not, stop and fix the reported path or DB mismatch before moving on.

## Phase 7: manual smoke restore test

Use the restore smoke checklist:

- [RESTORE_SMOKE_CHECKLIST.md](RESTORE_SMOKE_CHECKLIST.md)

At minimum test:

1. homepage
2. one NES game
3. one GBA game
4. one PS1 game
5. one MAME game
6. one category page with cover-heavy content
7. admin login

## Phase 8: if no catalog backup exists

Rebuild in this order:

1. import NES / FC
2. import GBA
3. import GB / GBC
4. import PS1
5. import MAME
6. rebuild covers
7. audit integrity again

Relevant scripts include:

- `scripts/import_nes_nandar.php`
- `scripts/import_gba_roms.php`
- `scripts/import_gb_gbc_roms.php`
- `scripts/import_ps1_chd_folder.php`
- `scripts/import_mame_rom_folder.php`
- `scripts/cover_libretro_dry_run.php`
- `scripts/import_libretro_covers.php`
- `scripts/apply_reviewed_covers.php`

## Phase 9: if only GitHub exists and no private media exists

Be realistic:

- you can restore source
- you can restore docs
- you can restore schema
- you cannot fully restore the playable library without the ROM and CHD media

In that case, the correct mission is:

1. restore repo
2. restore config
3. restore schema
4. locate original ROM sources again
5. re-import
6. rebuild covers

## Recovery priorities if time is limited

If you only have a short window, do this:

1. get homepage working
2. restore admin
3. restore NES and GBA first
4. restore PS1 next
5. restore MAME last

That order gives the fastest visible recovery for users.

## Final definition of success

The rebuild is considered successful when:

- `git status` is clean or intentionally understood
- `php scripts\audit_catalog_integrity.php` returns `status=PASS`
- homepage loads without fatal errors
- core launchers work
- category pages show covers or premium fallbacks
- repo points to a known stable tag or commit
