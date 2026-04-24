# Database Bootstrap

The main catalog schema lives in [schema.sql](schema.sql).

This file creates the baseline tables used by the main portal:

- `categories`
- `games`
- `game_category`
- `click_stats`

Typical bootstrap flow:

```powershell
mysql -u root -p gba < database\schema.sql
```

Then either:

1. restore a catalog backup with `scripts\restore_catalog.php`, or
2. import fresh ROM folders with the importer scripts.