#!/usr/bin/env python3
from __future__ import annotations

import argparse
import base64
import html
import json
import os
import re
import shutil
import sys
from datetime import datetime
from pathlib import Path
from typing import Iterable
from urllib.parse import parse_qs, unquote, urlsplit
from urllib.request import Request, urlopen

import pymysql

from translate_visible_site_to_english import TranslatorCache, contains_cjk


def console_safe(value: object) -> str:
    encoding = sys.stdout.encoding or "utf-8"
    return str(value).encode(encoding, errors="backslashreplace").decode(
        encoding, errors="ignore"
    )


FC_DESCRIPTION = (
    "Play this FC / Famicom game online with EmulatorJS in the English local build."
)
FC_KEYWORDS = (
    "FC games, Famicom, NES, EmulatorJS, browser emulator, retro games"
)
FC_AUTHOR = "Local Retro Library"

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

FC_TITLE_OVERRIDES = {
    "1chaojimali": "Super Mario Bros.",
    "2hundouluo": "Contra",
    "CT": "Dragon Spirit",
    "klkd": "Cadillacs and Dinosaurs (Unsupported Package)",
}

IMAGE_URL_OVERRIDES = {
    "口袋妖怪 - 绿叶版": "/fc/img/口袋妖怪绿叶版.png",
    "世界传说 - 换装迷宫2绿+版 64.00": "/gba/img/世界传说 - 换装迷宫2(CGP)绿+版 64.00.jpg",
    "侦探学园Q - 挑战究极诡计!完全版 128.00": "/gba/img/侦探学园Q - 挑战究极诡计!(nailgo)完全版 128.00.jpg",
    "恶魔城之三饶传奇 同人版 53.00": "/gba/img/恶魔城之三饶传奇 同人版 53.00.jpg",
    "敲击打开天堂大门图片1.1汉化版 128.00": "/gba/img/敲击打开天堂大门(风小子)图片1.1汉化版 128.00.jpg",
    "火焰纹章 - 圣邪的意志1.4同人版 127.25": "/gba/img/火焰纹章 - 圣邪的意志(狼组+火花天龙剑)1.4同人版 127.25.jpg",
    "火焰纹章 - 封印之剑v1.1 2006090701版 64.00": "/gba/img/火焰纹章 - 封印之剑(狼组+火花天龙剑)v1.1 2006090701版 64.00.jpg",
    "火焰纹章 - 烈火之剑v1.3 20060908版": "/gba/img/火焰纹章 - 烈火之剑(狼组+火花天龙剑)v1.3 20060908版.jpg",
    "班卓卡祖伊格兰蒂的复仇": "/gba/img/班卓卡祖伊格兰蒂的复仇[Advance-007](v1.01)(简)(70Mb).jpg",
    "皇家骑士团 - 劳德思的骑士简体版 64.00": "/gba/img/皇家骑士团 - 劳德思的骑士(D商)简体版 64.00.jpg",
    "超级机器人大战Av1.1": "/gba/img/超级机器人大战A(WGF)v1.1.jpg",
    "超级机器人大战R1.5汉化版": "/gba/img/超级机器人大战R(张老批)1.5汉化版.jpg",
    "陆行鸟大陆汉化测试版v0.1": "/gba/img/陆行鸟大陆汉化测试版v0.1.jpg",
    "黄金太阳 - 开启的封印完全剧情版 71.25": "/gba/img/黄金太阳 - 开启的封印(CGP)完全剧情版 71.25.jpg",
}

FC_TEXT_REPLACEMENTS = {
    "\u5c0f\u5df4\u738b": "Subor",
    "TV\u9a6c\u734d": "TV Mahjong",
    "\u7e40\u77f3": "Wanshi",
    "无名汉化组中文字幕": "Unnamed Translation Group Chinese Subtitles",
    "无名+汉化yourmei": "Unnamed + Ni Mei Translation Group",
    "汉化你妹": "Ni Mei Translation Group",
    "汉化你 sister": "Ni Mei Translation Group",
    "汉化your sister": "Ni Mei Translation Group",
    "汉化yourmei": "Ni Mei Translation Group",
    "MM之神": "MM's God",
    "MM的神": "MM's God",
    "小黑Ben": "Little Black Ben",
    "小BD": "Little BD",
    "小天之尊": "Xiao Tian Zhizun",
    "小世巴": "Xiao Shiba",
    "小霸王": "Subor",
    "小宝王": "Little Treasure King",
    "小鬼鬼": "Little Ghost",
    "小田": "Oda",
    "小古": "Xiao Gu",
    "TV马鸡": "TV Mahjong",
    "hoe大D": "hoe Big D",
    "一揆": "Ikki",
    "兵蜂": "TwinBee",
    "挖金": "Gold Digger",
    "踢王": "Kick Master",
    "汉化": "Chinese Translation",
    "星空": "Starry Sky",
    "中伟": "Zhong Wei",
    "金明": "Jin Ming",
    "来福": "Laifu",
    "无极": "Wuji",
    "鱼鱼猫猫": "Fishy Cat",
    "雷神": "Thor",
    "王龙": "Wang Long",
    "无名": "Unnamed",
    "新科": "Xinke",
    "王一晓": "Wang Yixiao",
    "元水探花": "Yuan Shui Tanhua",
    "奇玉": "Qiyu",
    "马鸡": "Mahjong",
    "繁石": "Fan Shi",
    "东生": "Dong Sheng",
    "三佳": "Sanjia",
    "圣谦": "Sheng Qian",
    "水火": "Water & Fire",
}

SUPPORTED_CORE_BY_EXT = {
    ".fds": "nes",
    ".nes": "nes",
    ".unf": "nes",
    ".unif": "nes",
    ".gba": "gba",
    ".gb": "gb",
    ".gbc": "gb",
}
SUPPORTED_ROM_PRIORITY = [".nes", ".fds", ".unf", ".unif", ".gba", ".gbc", ".gb"]
DEFAULT_EMULATORJS_RELEASE = "4.2.1"
ROM_STEM_CLEANUP = [
    (re.compile(r"[_]+"), " "),
    (re.compile(r"\s+"), " "),
]


def parse_args() -> argparse.Namespace:
    parser = argparse.ArgumentParser(
        description="Import FC/Famicom games into the Laragon portal and translate visible metadata to English.",
    )
    parser.add_argument("--site-root", default=r"C:\laragon\www")
    parser.add_argument(
        "--source-root",
        default=r"C:\Users\arishat\Documents\MEGA downloads\lyzwlkjvip_在线GBA和FC游戏\在线FC游戏\服务端\Gserver\Gserver\phpstudy_pro\WWW",
    )
    parser.add_argument(
        "--source-sql",
        default=r"C:\Users\arishat\Documents\MEGA downloads\lyzwlkjvip_在线GBA和FC游戏\在线FC游戏\服务端\Gserver\Gserver\运行环境\gba.sql",
    )
    parser.add_argument("--db-host", default="localhost")
    parser.add_argument("--db-name", default="gba")
    parser.add_argument("--db-user", default="root")
    parser.add_argument("--db-password", default="")
    return parser.parse_args()


def read_sql_text(path: Path) -> str:
    raw = path.read_bytes()
    for encoding in ("utf-8", "utf-8-sig", "gb18030"):
        try:
            return raw.decode(encoding)
        except UnicodeDecodeError:
            continue
    return raw.decode("utf-8", errors="replace")


def split_sql_statements(sql_text: str) -> list[str]:
    statements: list[str] = []
    current: list[str] = []
    in_block_comment = False
    for line in sql_text.splitlines():
        stripped = line.strip()
        if in_block_comment:
            if "*/" in stripped:
                in_block_comment = False
            continue
        if stripped.startswith("/*"):
            if "*/" not in stripped:
                in_block_comment = True
            continue
        if not stripped or stripped.startswith("--"):
            continue
        current.append(line)
        if stripped.endswith(";"):
            statement = "\n".join(current).strip()
            if statement:
                statements.append(statement)
            current = []
    if current:
        statements.append("\n".join(current).strip())
    return statements


def stage_source_sql(sql_path: Path, connection_params: dict[str, str]) -> str:
    db_name = "gba_fc_stage"
    admin_conn = pymysql.connect(
        host=connection_params["host"],
        user=connection_params["user"],
        password=connection_params["password"],
        charset="utf8mb4",
        cursorclass=pymysql.cursors.DictCursor,
        autocommit=True,
    )
    try:
        with admin_conn.cursor() as cursor:
            cursor.execute(f"DROP DATABASE IF EXISTS `{db_name}`")
            cursor.execute(f"CREATE DATABASE `{db_name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")
    finally:
        admin_conn.close()

    statements = split_sql_statements(read_sql_text(sql_path))
    stage_conn = pymysql.connect(
        host=connection_params["host"],
        user=connection_params["user"],
        password=connection_params["password"],
        database=db_name,
        charset="utf8mb4",
        cursorclass=pymysql.cursors.DictCursor,
        autocommit=False,
    )
    try:
        with stage_conn.cursor() as cursor:
            for statement in statements:
                if statement.upper() == "SET FOREIGN_KEY_CHECKS=0;":
                    cursor.execute("SET FOREIGN_KEY_CHECKS=0")
                else:
                    cursor.execute(statement)
        stage_conn.commit()
    finally:
        stage_conn.close()
    return db_name


def fetch_rows(connection: pymysql.Connection, query: str) -> list[dict]:
    with connection.cursor() as cursor:
        cursor.execute(query)
        return cursor.fetchall()


def local_image_exists(site_root: Path, image_url: object) -> str | None:
    if not isinstance(image_url, str) or not image_url.strip():
        return None

    path = urlsplit(image_url).path or image_url
    if path in {"/common-file/img/default-game.jpg", "common-file/img/default-game.jpg"}:
        return None

    local_path = site_root / unquote(path).replace("\\", "/").lstrip("/")
    if local_path.is_file():
        return "/" + local_path.relative_to(site_root).as_posix()
    return None


def decode_legacy_game_file(encoded: str) -> str:
    encoded = encoded.replace(" ", "+")
    padded = encoded + ("=" * (-len(encoded) % 4))
    try:
        return base64.urlsafe_b64decode(padded.encode("ascii")).decode("utf-8")
    except Exception:
        try:
            return base64.b64decode(padded.encode("ascii")).decode("utf-8")
        except Exception:
            return ""


def candidate_stems_from_game_url(game_url: object) -> list[str]:
    if not isinstance(game_url, str):
        return []

    parsed = urlsplit(game_url)
    query = parse_qs(parsed.query)
    relative_file = ""

    if query.get("file"):
        relative_file = query["file"][0]
    elif query.get("f"):
        relative_file = decode_legacy_game_file(query["f"][0])
    else:
        match = re.match(r"^/(?:fc|gba)/games/(.+)$", parsed.path)
        if match:
            relative_file = unquote(match.group(1))

    relative_file = relative_file.replace("\\", "/").strip("/")
    if not relative_file or ".." in relative_file:
        return []

    parts = [part for part in relative_file.split("/") if part]
    if not parts:
        return []

    stems = [Path(parts[-1]).stem, Path(parts[0]).stem]
    return list(dict.fromkeys(stem for stem in stems if stem))


def system_from_game_url(game_url: object) -> str:
    if not isinstance(game_url, str):
        return ""

    match = re.match(r"^/(fc|gba)(?:/|$)", urlsplit(game_url).path)
    return match.group(1) if match else ""


def resolve_existing_game_image_url(game: dict, site_root: Path) -> str:
    existing = local_image_exists(site_root, game.get("image_url"))
    if existing:
        return existing

    system = system_from_game_url(game.get("game_url"))
    stems = candidate_stems_from_game_url(game.get("game_url"))

    if system == "fc":
        directories = [site_root / "fc" / "img"]
        extensions = ["png", "jpg", "jpeg"]
    elif system == "gba":
        directories = [site_root / "gba" / "img", site_root / "gba" / "img_big"]
        extensions = ["jpg", "png", "jpeg"]
    else:
        directories = []
        extensions = []

    for directory in directories:
        for stem in stems:
            for extension in extensions:
                candidate = directory / f"{stem}.{extension}"
                if candidate.is_file():
                    return "/" + candidate.relative_to(site_root).as_posix()

    override = IMAGE_URL_OVERRIDES.get(str(game.get("name", "")))
    if override:
        override_path = site_root / override.lstrip("/")
        if override_path.is_file():
            return override

    return "/common-file/img/default-game.jpg"


def backup_current_state(site_root: Path, connection: pymysql.Connection) -> Path:
    backup_dir = Path(os.environ.get("NANDAR_IMPORT_BACKUP_DIR", r"C:\laragon\private\import_backups"))
    backup_dir.mkdir(parents=True, exist_ok=True)
    backup_path = backup_dir / f"fc_import_backup_{datetime.now():%Y%m%d_%H%M%S}.json"

    with connection.cursor() as cursor:
        payload = {"generated_at": datetime.now().isoformat(timespec="seconds")}
        for table in ("categories", "games", "game_category", "click_stats"):
            cursor.execute(f"SELECT * FROM {table}")
            payload[table] = cursor.fetchall()

    backup_path.write_text(
        json.dumps(payload, ensure_ascii=False, indent=2, default=str),
        encoding="utf-8",
    )
    return backup_path


def copy_fc_assets(source_root: Path, site_root: Path) -> Path:
    source_fc = source_root / "fc"
    target_fc = site_root / "fc"
    shutil.copytree(source_fc, target_fc, dirs_exist_ok=True)
    return target_fc


def download_file(url: str, destination: Path) -> None:
    destination.parent.mkdir(parents=True, exist_ok=True)
    request = Request(url, headers={"User-Agent": "Mozilla/5.0"})
    with urlopen(request) as response, destination.open("wb") as handle:
        shutil.copyfileobj(response, handle)


def get_emulatorjs_release(fc_root: Path) -> str:
    version_path = fc_root / "data" / "version.json"
    if not version_path.exists():
        return DEFAULT_EMULATORJS_RELEASE

    try:
        payload = json.loads(version_path.read_text(encoding="utf-8"))
    except (OSError, json.JSONDecodeError):
        return DEFAULT_EMULATORJS_RELEASE

    version = payload.get("version")
    if isinstance(version, str) and version.strip():
        return version.strip()
    return DEFAULT_EMULATORJS_RELEASE


def ensure_fc_cores(fc_root: Path) -> list[str]:
    downloaded: list[str] = []
    cores_dir = fc_root / "data" / "cores"
    reports_dir = cores_dir / "reports"
    release = get_emulatorjs_release(fc_root)

    nes_core_downloads = {
        "fceumm-legacy-wasm.data": f"https://cdn.emulatorjs.org/{release}/data/cores/fceumm-legacy-wasm.data",
        "nestopia-legacy-wasm.data": f"https://cdn.emulatorjs.org/{release}/data/cores/nestopia-legacy-wasm.data",
    }
    nes_report_downloads = {
        "fceumm.json": f"https://cdn.emulatorjs.org/{release}/data/cores/reports/fceumm.json",
        "nestopia.json": f"https://cdn.emulatorjs.org/{release}/data/cores/reports/nestopia.json",
    }

    for filename, url in nes_core_downloads.items():
        path = cores_dir / filename
        if not path.exists():
            download_file(url, path)
            downloaded.append(str(path))

    for filename, url in nes_report_downloads.items():
        path = reports_dir / filename
        if not path.exists():
            download_file(url, path)
            downloaded.append(str(path))

    return downloaded


def build_category_id_map(
    current_categories: list[dict],
    staged_categories: list[dict],
) -> dict[int, int]:
    current_by_sort = {int(row["sort_order"]): int(row["id"]) for row in current_categories}
    mapping: dict[int, int] = {}
    for row in staged_categories:
        sort_order = int(row["sort_order"])
        if sort_order not in current_by_sort:
            raise RuntimeError(f"Missing category with sort_order={sort_order} in active database")
        mapping[int(row["id"])] = current_by_sort[sort_order]
    return mapping


def cleanup_rom_stem(name: str) -> str:
    cleaned = Path(name).stem
    for pattern, replacement in ROM_STEM_CLEANUP:
        cleaned = pattern.sub(replacement, cleaned)
    return cleaned.strip()


def apply_fc_text_replacements(text: str) -> str:
    updated = text
    for source, target in FC_TEXT_REPLACEMENTS.items():
        updated = updated.replace(source, target)
    return updated


def infer_better_title(folder: Path, existing_title: str) -> str:
    if existing_title in FC_TITLE_OVERRIDES:
        return FC_TITLE_OVERRIDES[existing_title]

    if contains_cjk(existing_title):
        return existing_title

    if folder.exists() and re.fullmatch(r"[A-Za-z0-9_-]{1,32}", existing_title):
        rom_candidates = [
            p for p in folder.iterdir()
            if p.is_file() and p.suffix.lower() in SUPPORTED_CORE_BY_EXT
        ]
        if rom_candidates:
            best = sorted(rom_candidates, key=lambda p: SUPPORTED_ROM_PRIORITY.index(p.suffix.lower()))[0]
            better = cleanup_rom_stem(best.name)
            if better:
                return better
    return existing_title


def translate_title(text: str, translator: TranslatorCache, folder: Path) -> str:
    prepared = infer_better_title(folder, text)
    if prepared in FC_TITLE_OVERRIDES:
        return FC_TITLE_OVERRIDES[prepared]
    translated = translator.translate(prepared)
    translated = apply_fc_text_replacements(translated)
    return FC_TITLE_OVERRIDES.get(translated, translated)


def sync_fc_games(
    active_conn: pymysql.Connection,
    staged_games: list[dict],
    staged_game_categories: list[dict],
    category_id_map: dict[int, int],
    translator: TranslatorCache,
    fc_games_root: Path,
) -> tuple[int, int, int, dict[str, str]]:
    inserted = 0
    updated = 0
    category_links = 0
    display_name_by_folder: dict[str, str] = {}
    site_root = fc_games_root.parent.parent

    with active_conn.cursor() as cursor:
        cursor.execute("SELECT id, game_url FROM games WHERE game_url LIKE '/fc/%'")
        existing_fc_rows = cursor.fetchall()
        existing_id_by_url = {row["game_url"]: int(row["id"]) for row in existing_fc_rows}

        cursor.execute("SELECT COALESCE(MAX(id), 0) AS max_id FROM games")
        next_game_id = int(cursor.fetchone()["max_id"]) + 1

        game_id_map: dict[int, int] = {}
        for game in staged_games:
            folder_name = Path(game["game_url"]).name
            folder = fc_games_root / folder_name
            translated_name = translate_title(game["name"], translator, folder)
            resolved_image_url = resolve_existing_game_image_url(game, site_root)
            display_name_by_folder[folder_name] = translated_name

            if game["game_url"] in existing_id_by_url:
                active_id = existing_id_by_url[game["game_url"]]
                cursor.execute(
                    """
                    UPDATE games
                    SET name = %s, image_url = %s, updated_at = CURRENT_TIMESTAMP
                    WHERE id = %s
                    """,
                    (translated_name, resolved_image_url, active_id),
                )
                updated += 1
            else:
                active_id = next_game_id
                next_game_id += 1
                cursor.execute(
                    """
                    INSERT INTO games (id, name, game_url, image_url, clicks, created_at, updated_at)
                    VALUES (%s, %s, %s, %s, 0, %s, %s)
                    """,
                    (
                        active_id,
                        translated_name,
                        game["game_url"],
                        resolved_image_url,
                        game["created_at"],
                        game["updated_at"],
                    ),
                )
                inserted += 1

            game_id_map[int(game["id"])] = active_id

        if game_id_map:
            cursor.execute(
                """
                DELETE gc
                FROM game_category gc
                INNER JOIN games g ON g.id = gc.game_id
                WHERE g.game_url LIKE '/fc/%'
                """
            )

            for row in staged_game_categories:
                source_game_id = int(row["game_id"])
                source_category_id = int(row["category_id"])
                if source_game_id not in game_id_map:
                    continue
                cursor.execute(
                    "INSERT INTO game_category (game_id, category_id) VALUES (%s, %s)",
                    (game_id_map[source_game_id], category_id_map[source_category_id]),
                )
                category_links += 1

    active_conn.commit()
    return inserted, updated, category_links, display_name_by_folder


def iter_supported_roms(folder: Path) -> Iterable[Path]:
    for item in sorted(folder.iterdir()):
        if item.is_file() and item.suffix.lower() in SUPPORTED_CORE_BY_EXT:
            yield item


def extract_nes_from_executable(folder: Path) -> Path | None:
    for exe in sorted(folder.glob("*.exe")):
        data = exe.read_bytes()
        offset = data.find(b"NES\x1a")
        if offset == -1:
            continue

        header = data[offset : offset + 16]
        if len(header) < 16:
            continue

        prg_units = header[4]
        chr_units = header[5]
        flags6 = header[6]
        trainer_size = 512 if (flags6 & 0x04) else 0
        rom_size = 16 + trainer_size + (prg_units * 16384) + (chr_units * 8192)
        rom_data = data[offset : offset + rom_size]
        if len(rom_data) < rom_size:
            continue

        output_path = folder / f"{folder.name}.nes"
        output_path.write_bytes(rom_data)
        return output_path
    return None


def repair_nested_rom_folders(games_root: Path) -> list[str]:
    repaired: list[str] = []
    for folder in sorted(p for p in games_root.iterdir() if p.is_dir()):
        if any(iter_supported_roms(folder)):
            continue

        extracted_rom = extract_nes_from_executable(folder)
        if extracted_rom is not None:
            repaired.append(folder.name)
            continue

        child_dirs = [p for p in folder.iterdir() if p.is_dir()]
        if len(child_dirs) != 1:
            continue

        child = child_dirs[0]
        child_roms = list(iter_supported_roms(child))
        if not child_roms:
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


def choose_rom_path(folder: Path) -> tuple[Path | None, str | None]:
    roms = list(iter_supported_roms(folder))
    if not roms:
        roms = [
            path for path in sorted(folder.rglob("*"))
            if path.is_file() and path.suffix.lower() in SUPPORTED_CORE_BY_EXT
        ]
    if not roms:
        return None, None

    def sort_key(path: Path) -> tuple[int, str]:
        ext = path.suffix.lower()
        return SUPPORTED_ROM_PRIORITY.index(ext), path.name.lower()

    rom_path = sorted(roms, key=sort_key)[0]
    return rom_path, SUPPORTED_CORE_BY_EXT[rom_path.suffix.lower()]


def build_game_page(display_name: str, rom_filename: str, core: str) -> str:
    title = html.escape(display_name, quote=True)
    rom_json = json.dumps(rom_filename, ensure_ascii=False)
    name_json = json.dumps(display_name, ensure_ascii=False)
    core_json = json.dumps(core)
    return f"""<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>{title} - Play Online FC / Famicom Game</title>
        <meta name="description" content="{html.escape(FC_DESCRIPTION, quote=True)}">
        <meta name="keywords" content="{html.escape(FC_KEYWORDS, quote=True)}">
        <link rel="shortcut icon" href="../../docs/favicon.ico" sizes="16x16 32x32 48x48 64x64" type="image/vnd.microsoft.icon">
        <meta name="author" content="{html.escape(FC_AUTHOR, quote=True)}">
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
            window.EJS_core = {core_json};
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
            <p>This entry is missing a supported ROM file or launcher assets.</p>
            <p>The folder needs repair before the game can be played.</p>
            <p><a href="/">Return to the home page</a></p>
        </div>
    </body>
</html>
"""


def build_arcade_klkd_page(display_name: str) -> str:
    title = html.escape(display_name, quote=True)
    return f"""<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>{title} - Play Online Arcade Game</title>
        <meta name="description" content="Play this preserved arcade package in the local retro library.">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            body {{
                margin: 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: radial-gradient(circle at top, #101827, #020617 70%);
                color: #f8fafc;
                font-family: Arial, sans-serif;
                padding: 24px;
            }}
            .shell {{
                max-width: 640px;
                text-align: center;
                background: rgba(15, 23, 42, 0.88);
                border: 1px solid rgba(148, 163, 184, 0.18);
                border-radius: 24px;
                padding: 36px;
                box-shadow: 0 24px 60px rgba(0, 0, 0, 0.35);
            }}
            h1 {{
                margin-top: 0;
                font-size: 2rem;
            }}
            p {{
                color: #cbd5e1;
                line-height: 1.6;
            }}
            .button {{
                display: inline-block;
                margin-top: 18px;
                padding: 14px 28px;
                border-radius: 999px;
                text-decoration: none;
                font-weight: bold;
                color: white;
                background: linear-gradient(135deg, #22c55e, #0ea5e9);
            }}
            .hint {{
                margin-top: 18px;
                font-size: 0.95rem;
                color: #94a3b8;
            }}
        </style>
    </head>
    <body>
        <div class="shell">
            <h1>{title}</h1>
            <p>This folder contains a preserved arcade package rather than a standard FC ROM. It can still be launched directly in the browser.</p>
            <a class="button" href="./恐龙快打.html">Launch Arcade Package</a>
            <p class="hint">If the game does not start, refresh once after the MAME assets finish caching.</p>
        </div>
    </body>
</html>
"""


def rewrite_fc_game_pages(
    games_root: Path,
    display_name_by_folder: dict[str, str],
    translator: TranslatorCache,
) -> tuple[int, int]:
    rewritten = 0
    placeholders = 0

    for folder in sorted(p for p in games_root.iterdir() if p.is_dir()):
        display_name = display_name_by_folder.get(folder.name)
        if not display_name:
            display_name = translate_title(folder.name, translator, folder)
        index_path = folder / "index.html"

        if (
            folder.name == "klkd"
            and (folder / "恐龙快打.html").exists()
            and (folder / "mame2003_libretro.js").exists()
            and (folder / "mame2003_libretro.wasm").exists()
            and (folder / "data" / "dino.zip").exists()
        ):
            index_path.write_text(build_arcade_klkd_page(display_name), encoding="utf-8")
            rewritten += 1
            continue

        rom_path, core = choose_rom_path(folder)

        if rom_path is None or core is None:
            index_path.write_text(build_missing_page(display_name), encoding="utf-8")
            placeholders += 1
            continue

        if rom_path.parent != folder:
            target = folder / rom_path.name
            if not target.exists():
                shutil.move(str(rom_path), str(target))
            rom_path = target

        index_path.write_text(
            build_game_page(display_name, rom_path.name, core),
            encoding="utf-8",
        )
        rewritten += 1

    return rewritten, placeholders


def summarize_fc_titles(active_conn: pymysql.Connection) -> tuple[int, int]:
    with active_conn.cursor() as cursor:
        cursor.execute("SELECT COUNT(*) AS c FROM games WHERE game_url LIKE '/fc/%'")
        total_fc = int(cursor.fetchone()["c"])
        cursor.execute("SELECT name FROM games WHERE game_url LIKE '/fc/%'")
        cjk_remaining = sum(1 for row in cursor.fetchall() if contains_cjk(row["name"]))
    return total_fc, cjk_remaining


def main() -> int:
    args = parse_args()
    site_root = Path(args.site_root)
    source_root = Path(args.source_root)
    source_sql = Path(args.source_sql)
    fc_root = site_root / "fc"
    fc_games_root = fc_root / "games"
    scripts_dir = site_root / "scripts"
    scripts_dir.mkdir(parents=True, exist_ok=True)
    translator = TranslatorCache(scripts_dir / "english_translation_cache.json")

    connection_params = {
        "host": args.db_host,
        "user": args.db_user,
        "password": args.db_password,
    }

    stage_db_name = stage_source_sql(source_sql, connection_params)

    active_conn = pymysql.connect(
        host=args.db_host,
        user=args.db_user,
        password=args.db_password,
        database=args.db_name,
        charset="utf8mb4",
        cursorclass=pymysql.cursors.DictCursor,
        autocommit=False,
    )
    stage_conn = pymysql.connect(
        host=args.db_host,
        user=args.db_user,
        password=args.db_password,
        database=stage_db_name,
        charset="utf8mb4",
        cursorclass=pymysql.cursors.DictCursor,
        autocommit=False,
    )

    try:
        backup_path = backup_current_state(site_root, active_conn)
        copy_fc_assets(source_root, site_root)
        downloaded_files = ensure_fc_cores(fc_root)

        current_categories = fetch_rows(
            active_conn,
            "SELECT id, category_name, sort_order FROM categories ORDER BY sort_order, id",
        )
        staged_categories = fetch_rows(
            stage_conn,
            "SELECT id, category_name, sort_order FROM categories ORDER BY sort_order, id",
        )
        staged_games = fetch_rows(
            stage_conn,
            "SELECT id, name, game_url, image_url, clicks, created_at, updated_at FROM games ORDER BY id",
        )
        staged_game_categories = fetch_rows(
            stage_conn,
            "SELECT game_id, category_id FROM game_category ORDER BY game_id, category_id",
        )

        category_id_map = build_category_id_map(current_categories, staged_categories)
        repaired_folders = repair_nested_rom_folders(fc_games_root)
        inserted, updated, category_links, display_name_by_folder = sync_fc_games(
            active_conn,
            staged_games,
            staged_game_categories,
            category_id_map,
            translator,
            fc_games_root,
        )
        rewritten_pages, placeholder_pages = rewrite_fc_game_pages(
            fc_games_root,
            display_name_by_folder,
            translator,
        )
        translator.save()
        total_fc, cjk_remaining = summarize_fc_titles(active_conn)
    finally:
        active_conn.close()
        stage_conn.close()

    print(f"Backup written to: {backup_path}")
    print(f"FC asset root synced to: {fc_root}")
    print(f"Temporary staging database: {stage_db_name}")
    print(f"FC cores downloaded: {len(downloaded_files)}")
    for item in downloaded_files:
        print(f"  - {console_safe(item)}")
    print(f"Nested FC folders repaired: {len(repaired_folders)}")
    for folder in repaired_folders:
        print(f"  - {console_safe(folder)}")
    print(f"FC games inserted: {inserted}")
    print(f"FC games updated: {updated}")
    print(f"FC category links written: {category_links}")
    print(f"FC game pages rewritten: {rewritten_pages}")
    print(f"Missing-file placeholders created: {placeholder_pages}")
    print(f"FC games now in active database: {total_fc}")
    print(f"FC titles still containing CJK: {cjk_remaining}")
    return 0


if __name__ == "__main__":
    sys.exit(main())
