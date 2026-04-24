# Restore Smoke Checklist

Use this after a fresh clone, restore, ROM import, or catalog restore.

## 1. Config and database

- `config.local.php` exists and points to the right database
- `database/schema.sql` has been applied if this is a clean database
- latest catalog backup has been restored if available

Run:

```powershell
php scripts\audit_catalog_integrity.php
```

Expected:

- `status=PASS`
- `missing_local_game_files=0`
- `missing_local_images=0`

## 2. Homepage

Check:

- homepage loads without PHP fatal errors
- system chips render correctly
- premium cover fallbacks render instead of broken images
- section counts feel plausible

## 3. NES / FC

Open one sample:

```text
/fc/play.html?file=_nes_megapack201808/Z/ZZZ_UNK_zelda.nes
```

Check:

- launcher boots
- no `Failed to start game`
- game reaches core load and becomes playable

## 4. GBA

Open one sample from the GBA library.

Check:

- game launches
- image and title appear correctly
- category `GBA` shows the full parent collection, not only `0-9`

## 5. GB / GBC

Open one `.gb` and one `.gbc` sample.

Check:

- no `Outdated EmulatorJS version`
- launcher reaches game boot

## 6. PS1

Open one smaller CHD and one heavier CHD.

Check:

- BIOS is detected
- no missing firmware screen for the expected BIOS mode
- audio and controls work
- page does not stall forever at `99%`

## 7. MAME

Open one arcade game that was already tested locally.

Check:

- game boots into play, not only the menu
- `COIN` and `START` work
- mobile controller is usable

## 8. Pokemon VN

Open:

```text
/pokemon-vn/
```

Check:

- page loads
- no fatal error from DB bootstrap
- app progresses past the old stuck-loader state

## 9. Covers and category pages

Check category pages:

- `NES / FC`
- `GBA`
- `GB / GBC`
- `PS1`
- `Arcade MAME`

Look for:

- real cover images appearing where expected
- premium fallbacks showing cleanly when real covers are unavailable
- no obvious broken image icons

## 10. Admin

Open:

```text
/admin.php
```

Check:

- login works with your local admin credentials
- category/game management page opens

## 11. If something fails

Use this order:

1. `php scripts\audit_catalog_integrity.php`
2. verify `config.local.php`
3. verify ROM folders exist in the expected `games/` paths
4. verify PS1 BIOS files exist in `ps1/bios`
5. re-check `.htaccess` and runtime `data/cores` files
