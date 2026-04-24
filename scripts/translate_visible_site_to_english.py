#!/usr/bin/env python3
from __future__ import annotations

import argparse
import html
import json
import os
import re
import shutil
import sys
import time
from datetime import datetime
from pathlib import Path

import pymysql
from deep_translator import GoogleTranslator


CATEGORY_TRANSLATIONS = {
    "推荐": "Featured",
    "fc红白机": "FC / Famicom",
    "动作": "Action",
    "休闲": "Casual",
    "射击": "Shooter",
    "棋牌": "Board & Card",
    "益智": "Puzzle",
    "策略": "Strategy",
    "3D": "3D",
    "GBA": "GBA",
    "经典": "Classics",
    "赛车": "Racing",
    "闯关": "Platformer",
    "反应": "Reflex",
    "其他": "Other",
    "精品联运-易起游": "Partner Showcase",
    "最近上新+本站热门": "New & Popular",
}

TITLE_OVERRIDES = {
    "人鱼恋曲 - Pichi Pichi Pitch[千岛&叶子](简)(JP)(136.33Mb)": "Mermaid Melody - Pichi Pichi Pitch [Qiandao & Yezi] (Simplified Chinese) (JP) (136.33Mb)",
    "好狗狗星系(星际好狗)(官中)(简)(256Mb)": "Good Dog Galaxy (Interstellar Good Dog) (Official Chinese) (Simplified Chinese) (256Mb)",
    "最终幻想IV Advance[天幻网+PGCG](v2.7)(简)(US)(64Mb)": "Final Fantasy IV Advance [Tianhuan.net + PGCG] (v2.7) (Simplified Chinese) (US) (64Mb)",
    "最终幻想IV Advance[天幻网+PGCG](v3.0)(简)(US)(64Mb)": "Final Fantasy IV Advance [Tianhuan.net + PGCG] (v3.0) (Simplified Chinese) (US) (64Mb)",
    "最终幻想VI Advance[天幻网](v1.1)(简)(US)(65.4Mb)": "Final Fantasy VI Advance [Tianhuan.net] (v1.1) (Simplified Chinese) (US) (65.4Mb)",
    "神游 Famicom Mini Collection[未发售](简)(32Mb)": "iQue Famicom Mini Collection [Unreleased] (Simplified Chinese) (32Mb)",
    "网球王子2003 - 火红[Kiny](简)(JP)(128Mb)": "The Prince of Tennis 2003 - Fiery Red [Kiny] (Simplified Chinese) (JP) (128Mb)",
    "Mermaid Love Song - Pichi Pichi Pitch[千岛&叶](Simplified Chinese)(JP)(136.33Mb)": "Mermaid Melody - Pichi Pichi Pitch [Qiandao & Yezi] (Simplified Chinese) (JP) (136.33Mb)",
    "Good Dog Galaxy(Interstellar Good Dog)(官中)(Simplified Chinese)(256Mb)": "Good Dog Galaxy (Interstellar Good Dog) (Official Chinese) (Simplified Chinese) (256Mb)",
    "Final Fantasy IV Advance[天仙网+PGCG](v2.7)(Simplified Chinese)(US)(64Mb)": "Final Fantasy IV Advance [Tianhuan.net + PGCG] (v2.7) (Simplified Chinese) (US) (64Mb)",
    "Final Fantasy IV Advance[天仙网+PGCG](v3.0)(Simplified Chinese)(US)(64Mb)": "Final Fantasy IV Advance [Tianhuan.net + PGCG] (v3.0) (Simplified Chinese) (US) (64Mb)",
    "Final Fantasy VI Advance[天仙网](v1.1)(Simplified Chinese)(US)(65.4Mb)": "Final Fantasy VI Advance [Tianhuan.net] (v1.1) (Simplified Chinese) (US) (65.4Mb)",
    "神游 Famicom Mini Collection[Unreleased](Simplified Chinese)(32Mb)": "iQue Famicom Mini Collection [Unreleased] (Simplified Chinese) (32Mb)",
    "Prince of Tennis 2003 - 火红[Kiny](Simplified Chinese)(JP)(128Mb)": "The Prince of Tennis 2003 - Fiery Red [Kiny] (Simplified Chinese) (JP) (128Mb)",
}

GAME_PAGE_DESCRIPTION = (
    "Play this Game Boy Advance title online with EmulatorJS in the English local build."
)
GAME_PAGE_KEYWORDS = (
    "GBA games, Game Boy Advance, EmulatorJS, browser emulator, retro games"
)
GAME_PAGE_AUTHOR = "Local GBA Library"

_CJK_PATTERN = re.compile(r"[\u3400-\u4DBF\u4E00-\u9FFF\uF900-\uFAFF]")
_WHITESPACE_PATTERN = re.compile(r"\s+")


def contains_cjk(text: str) -> bool:
    return bool(_CJK_PATTERN.search(text))


def normalize_spaces(text: str) -> str:
    text = text.replace("（", "(").replace("）", ")")
    text = text.replace("【", "[").replace("】", "]")
    text = text.replace("：", ":").replace("，", ",")
    text = _WHITESPACE_PATTERN.sub(" ", text)
    return text.strip()


def prepare_for_translation(text: str) -> str:
    prepared = normalize_spaces(text)
    token_replacements = {
        "(简)": "(Simplified Chinese)",
        "(繁)": "(Traditional Chinese)",
        "(汉化)": "(Chinese Translation)",
        "未发售": "Unreleased",
        "修正版": "Revised",
        "测试版": "Test Build",
        "体验版": "Demo",
        "大字体": "Large Font",
        "小字修正": "Small Font Fix",
        "中文解说": "Chinese Commentary",
        "中文": "Chinese",
        "官中": "Official Chinese",
        "天幻网": "Tianhuan.net",
        "天仙网": "Tianhuan.net",
        "千岛": "Qiandao",
        "叶子": "Yezi",
        "神游": "iQue",
        "火红": "Fiery Red",
        "美版": "US Version",
        "日版": "JP Version",
    }
    for source, target in token_replacements.items():
        prepared = prepared.replace(source, target)
    return prepared


def cleanup_translation(text: str) -> str:
    cleaned = normalize_spaces(text)
    cleaned = cleaned.replace(" ,", ",").replace(" .", ".")
    cleaned = cleaned.replace("( ", "(").replace(" )", ")")
    cleaned = cleaned.replace("[ ", "[").replace(" ]", "]")
    cleaned = cleaned.replace(" - ", " - ")
    return cleaned.strip(" -")


class TranslatorCache:
    def __init__(self, cache_path: Path) -> None:
        self.cache_path = cache_path
        self.cache: dict[str, str] = {}
        if cache_path.exists():
            self.cache = json.loads(cache_path.read_text(encoding="utf-8"))
        self.translator = GoogleTranslator(source="auto", target="en")

    def save(self) -> None:
        self.cache_path.write_text(
            json.dumps(self.cache, ensure_ascii=False, indent=2),
            encoding="utf-8",
        )

    def translate(self, text: str) -> str:
        text = text.strip()
        if not text:
            return text
        if text in CATEGORY_TRANSLATIONS:
            return CATEGORY_TRANSLATIONS[text]
        if text in TITLE_OVERRIDES:
            return TITLE_OVERRIDES[text]
        if not contains_cjk(text):
            return cleanup_translation(text)
        if text in self.cache:
            return self.cache[text]

        prepared = prepare_for_translation(text)
        last_error: Exception | None = None
        for attempt in range(3):
            try:
                translated = self.translator.translate(prepared)
                if translated:
                    translated = cleanup_translation(translated)
                    if translated:
                        self.cache[text] = translated
                        return translated
            except Exception as exc:  # pragma: no cover - network-dependent
                last_error = exc
                time.sleep(1 + attempt)

        if last_error is not None:
            print(f"Translation fallback for: {text} ({last_error})")

        fallback = cleanup_translation(prepared)
        self.cache[text] = fallback
        return fallback


def load_db_rows(connection: pymysql.Connection) -> tuple[list[dict], list[dict]]:
    with connection.cursor() as cursor:
        cursor.execute("SELECT id, category_name, sort_order, created_at FROM categories ORDER BY id")
        categories = cursor.fetchall()
        cursor.execute("SELECT id, name, game_url, image_url, clicks, created_at FROM games ORDER BY id")
        games = cursor.fetchall()
    return categories, games


def write_backup(backup_path: Path, categories: list[dict], games: list[dict]) -> None:
    backup = {
        "generated_at": datetime.now().isoformat(timespec="seconds"),
        "categories": categories,
        "games": games,
    }
    backup_path.write_text(
        json.dumps(backup, ensure_ascii=False, indent=2, default=str),
        encoding="utf-8",
    )


def repair_nested_game_folders(games_root: Path) -> list[str]:
    repaired: list[str] = []
    for folder in sorted(p for p in games_root.iterdir() if p.is_dir()):
        index_path = folder / "index.html"
        if index_path.exists():
            continue

        child_dirs = [p for p in folder.iterdir() if p.is_dir()]
        if len(child_dirs) != 1:
            continue

        child = child_dirs[0]
        child_index = child / "index.html"
        child_roms = list(child.glob("*.gba"))
        if not child_index.exists() and not child_roms:
            continue

        if child.resolve().parent != folder.resolve():
            continue

        for item in child.iterdir():
            target = folder / item.name
            if target.exists():
                continue
            shutil.move(str(item), str(target))

        try:
            child.rmdir()
        except OSError:
            pass

        repaired.append(folder.name)
    return repaired


def choose_rom_path(folder: Path) -> Path | None:
    preferred = folder / f"{folder.name}.gba"
    if preferred.exists():
        return preferred
    roms = sorted(folder.glob("*.gba"))
    if roms:
        return roms[0]
    nested_roms = sorted(folder.rglob("*.gba"))
    return nested_roms[0] if nested_roms else None


def build_game_page(display_name: str, rom_filename: str) -> str:
    title = html.escape(display_name, quote=True)
    rom_json = json.dumps(rom_filename, ensure_ascii=False)
    name_json = json.dumps(display_name, ensure_ascii=False)
    return f"""<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>{title} - Play Online GBA Game</title>
        <meta name="description" content="{html.escape(GAME_PAGE_DESCRIPTION, quote=True)}">
        <meta name="keywords" content="{html.escape(GAME_PAGE_KEYWORDS, quote=True)}">
        <link rel="shortcut icon" href="../../docs/favicon.ico" sizes="16x16 32x32 48x48 64x64" type="image/vnd.microsoft.icon">
        <meta name="author" content="{html.escape(GAME_PAGE_AUTHOR, quote=True)}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body, html {{
                height: 100%;
                background-color: black;
                color: white;
                margin: 0;
                overflow: hidden;
                font-family: Arial, sans-serif;
            }}

            #game-container {{
                width: 100%;
                height: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }}

            #loading {{
                font-size: 20px;
                text-align: center;
                margin-bottom: 20px;
            }}

            #game {{
                display: none;
            }}
        </style>
    </head>
    <body>
        <div id="game-container">
            <div id="loading">Loading game, please wait...</div>
            <div id="game"></div>
        </div>

        <script>
            window.EJS_player = "#game";
            window.EJS_language = "en-US";
            window.EJS_gameName = {name_json};
            window.EJS_gameUrl = {rom_json};
            window.EJS_core = "gba";
            window.EJS_pathtodata = "../../data/";
            window.EJS_startOnLoaded = true;
            window.EJS_DEBUG_XX = false;
            window.EJS_disableDatabases = true;
            window.EJS_threads = false;

            const script = document.createElement("script");
            script.src = "../../data/loader.js";
            script.onload = function() {{
                document.getElementById("loading").textContent = "Preparing game...";
                setTimeout(() => {{
                    document.getElementById("loading").style.display = "none";
                    document.getElementById("game").style.display = "block";
                }}, 1000);
            }};
            script.onerror = function() {{
                document.getElementById("loading").textContent = "Failed to load the emulator. Please refresh and try again.";
            }};
            document.body.appendChild(script);

            function encodeFilename(filename) {{
                return encodeURIComponent(filename).replace(/%20/g, " ");
            }}

            window.EJS_gameUrl = encodeFilename(window.EJS_gameUrl);
        </script>
    </body>
</html>
"""


def build_missing_page(display_name: str) -> str:
    title = html.escape(display_name, quote=True)
    return f"""<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>{title} - Files Missing</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body {{
                margin: 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, #111827, #1f2937);
                color: #f9fafb;
                font-family: Arial, sans-serif;
                padding: 24px;
                text-align: center;
            }}
            .card {{
                max-width: 560px;
                background: rgba(17, 24, 39, 0.92);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 20px;
                padding: 32px;
                box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
            }}
            a {{
                color: #93c5fd;
            }}
        </style>
    </head>
    <body>
        <div class="card">
            <h1>{title}</h1>
            <p>This entry is missing its ROM file or launcher assets.</p>
            <p>The folder needs repair before the game can be played.</p>
            <p><a href="/">Return to the home page</a></p>
        </div>
    </body>
</html>
"""


def rewrite_game_pages(
    games_root: Path,
    display_name_by_folder: dict[str, str],
) -> tuple[int, int]:
    rewritten = 0
    placeholders = 0

    for folder in sorted(p for p in games_root.iterdir() if p.is_dir()):
        display_name = display_name_by_folder.get(folder.name, folder.name)
        rom_path = choose_rom_path(folder)
        index_path = folder / "index.html"

        if rom_path is None:
            index_path.write_text(build_missing_page(display_name), encoding="utf-8")
            placeholders += 1
            continue

        if rom_path.parent != folder:
            target = folder / rom_path.name
            if not target.exists():
                shutil.move(str(rom_path), str(target))
            rom_path = target

        index_path.write_text(
            build_game_page(display_name, rom_path.name),
            encoding="utf-8",
        )
        rewritten += 1

    return rewritten, placeholders


def update_database(
    connection: pymysql.Connection,
    categories: list[dict],
    games: list[dict],
    translator: TranslatorCache,
) -> tuple[dict[int, str], dict[int, str]]:
    translated_categories: dict[int, str] = {}
    translated_games: dict[int, str] = {}

    with connection.cursor() as cursor:
        for category in categories:
            translated = CATEGORY_TRANSLATIONS.get(
                category["category_name"],
                translator.translate(category["category_name"]),
            )
            translated_categories[category["id"]] = translated
            if translated != category["category_name"]:
                cursor.execute(
                    "UPDATE categories SET category_name = %s WHERE id = %s",
                    (translated, category["id"]),
                )

        for game in games:
            translated = translator.translate(game["name"])
            translated_games[game["id"]] = translated
            if translated != game["name"]:
                cursor.execute(
                    "UPDATE games SET name = %s WHERE id = %s",
                    (translated, game["id"]),
                )

    connection.commit()
    return translated_categories, translated_games


def build_display_name_map(
    games: list[dict],
    translated_games: dict[int, str],
    translator: TranslatorCache,
) -> dict[str, str]:
    display_name_by_folder: dict[str, str] = {}

    for game in games:
        folder_name = Path(game["game_url"]).name
        display_name_by_folder[folder_name] = translated_games.get(
            game["id"],
            translator.translate(game["name"]),
        )

    return display_name_by_folder


def add_extra_folder_translations(
    games_root: Path,
    display_name_by_folder: dict[str, str],
    translator: TranslatorCache,
) -> None:
    for folder in sorted(p for p in games_root.iterdir() if p.is_dir()):
        display_name_by_folder.setdefault(folder.name, translator.translate(folder.name))


def parse_args() -> argparse.Namespace:
    parser = argparse.ArgumentParser(
        description="Translate visible game metadata and static pages to English.",
    )
    parser.add_argument(
        "--site-root",
        default=r"C:\laragon\www",
        help="Root path of the Laragon site",
    )
    parser.add_argument("--db-host", default="localhost")
    parser.add_argument("--db-name", default="gba")
    parser.add_argument("--db-user", default="root")
    parser.add_argument("--db-password", default="")
    return parser.parse_args()


def main() -> int:
    args = parse_args()
    site_root = Path(args.site_root)
    scripts_dir = site_root / "scripts"
    scripts_dir.mkdir(parents=True, exist_ok=True)

    games_root = site_root / "gba" / "games"
    if not games_root.exists():
        print(f"Game folder not found: {games_root}")
        return 1

    cache_path = scripts_dir / "english_translation_cache.json"
    backup_dir = Path(os.environ.get("NANDAR_IMPORT_BACKUP_DIR", r"C:\laragon\private\import_backups"))
    backup_dir.mkdir(parents=True, exist_ok=True)
    backup_path = backup_dir / f"gba_metadata_backup_{datetime.now():%Y%m%d_%H%M%S}.json"
    translator = TranslatorCache(cache_path)

    connection = pymysql.connect(
        host=args.db_host,
        user=args.db_user,
        password=args.db_password,
        database=args.db_name,
        charset="utf8mb4",
        cursorclass=pymysql.cursors.DictCursor,
        autocommit=False,
    )

    try:
        categories, games = load_db_rows(connection)
        write_backup(backup_path, categories, games)

        repaired_folders = repair_nested_game_folders(games_root)
        translated_categories, translated_games = update_database(
            connection,
            categories,
            games,
            translator,
        )

        display_name_by_folder = build_display_name_map(games, translated_games, translator)
        add_extra_folder_translations(games_root, display_name_by_folder, translator)
        rewritten_pages, placeholder_pages = rewrite_game_pages(
            games_root,
            display_name_by_folder,
        )

        translator.save()

    finally:
        connection.close()

    print(f"Backup written to: {backup_path}")
    print(f"Category translations applied: {len(translated_categories)}")
    print(f"Game title translations applied: {len(translated_games)}")
    print(f"Nested folders repaired: {len(repaired_folders)}")
    if repaired_folders:
        for folder in repaired_folders:
            print(f"  - {folder}")
    print(f"Game pages rewritten: {rewritten_pages}")
    print(f"Missing-file placeholders created: {placeholder_pages}")
    return 0


if __name__ == "__main__":
    sys.exit(main())
