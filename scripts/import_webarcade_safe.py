from __future__ import annotations

import json
import re
import shutil
from datetime import datetime, timezone
from pathlib import Path


SOURCE_ROOT = Path(
    r"D:\BaiduNetdiskDownload\【整合包】27合一 带登录 解压D盘根目录\Fqserver\phpstudy_pro\WWW\web"
)
OUTPUT_ROOT = Path(r"C:\laragon\www\webarcade")
OUTPUT_PARENT = Path(r"C:\laragon\www")
POLICY_PATH = Path(r"C:\laragon\www\scripts\webarcade_publish_policy.json")
SHIM_SOURCE_PATH = Path(r"C:\laragon\www\scripts\webarcade_browser_safe_shim.js")
SAVE_BRIDGE_SOURCE_PATH = Path(r"C:\laragon\www\scripts\webarcade_user_save_bridge.js")
CSP_DIRECTIVE = (
    "default-src 'self' 'unsafe-inline' 'unsafe-eval' data: blob:; "
    "connect-src 'self'; "
    "img-src 'self' data: blob:; "
    "media-src 'self' data: blob:; "
    "font-src 'self' data:; "
    "script-src 'self' 'unsafe-inline' 'unsafe-eval' blob:; "
    "style-src 'self' 'unsafe-inline'; "
    "frame-src 'self'; "
    "worker-src 'self' blob:; "
    "object-src 'none'; "
    "base-uri 'self'; "
    "form-action 'self'"
)

TRANSLATIONS = {
    "01": {"name": "Doomsday Agents", "hint": "Apocalyptic survival / agent showdown", "category": "Action Shooter"},
    "02": {"name": "Breakout Assault", "hint": "All-out breakout / nonstop combat", "category": "Action Shooter"},
    "03": {"name": "Uncle Wang's Happy Life", "hint": "Country retirement / cozy slow living", "category": "Management Sim"},
    "04": {"name": "Earn That First Billion", "hint": "Business sim / billion-dollar empire builder", "category": "Strategy Battle"},
    "05": {"name": "Legend Quest", "hint": "Fantasy adventure / epic legend", "category": "Fantasy Adventure"},
    "06": {"name": "Carefree Immortal Quest", "hint": "Idle cultivation / heavenly trials", "category": "Fantasy Adventure"},
    "07": {"name": "Chubby Bird Fitness Club", "hint": "Cute bird raising / merge management", "category": "Management Sim"},
    "08": {"name": "Go, Capybara!", "hint": "Cute creature challenge / whimsical adventure", "category": "Fantasy Adventure"},
    "09": {"name": "Ghosts in Space", "hint": "Space suspense / ghost hunt", "category": "Action Shooter"},
    "10": {"name": "Pig Catcher", "hint": "Cute pig matching / playful stages", "category": "Casual Puzzle"},
    "11": {"name": "When Dreams Meet Fairy Tales", "hint": "Fairytale town / dream management", "category": "Management Sim"},
    "12": {"name": "Immortal Cultivation Simulator", "hint": "Idle cultivation / ascension trials", "category": "Fantasy Adventure"},
    "13": {"name": "Meow Tycoon Story", "hint": "Cat town / build the dream", "category": "Management Sim"},
    "15": {"name": "Beggar to Emperor", "hint": "Underdog rise / emperor builder", "category": "Strategy Battle"},
    "16": {"name": "Wukong's Immortal Path", "hint": "Idle cultivation / ascension trials", "category": "Fantasy Adventure"},
    "17": {"name": "Idle Big Boss", "hint": "Business sim / management dream", "category": "Management Sim"},
    "18": {"name": "Soul Battle Continent", "hint": "Soul training / casual survival", "category": "Casual Survival"},
    "19": {"name": "Blast the Ghosts", "hint": "Idle action / hero growth", "category": "Casual Survival"},
    "20": {"name": "Hero on Paper", "hint": "Idle training / hero growth", "category": "Casual Survival"},
    "21": {"name": "Claim the Castle", "hint": "Build the city / defend the fortress", "category": "Strategy Battle"},
    "22": {"name": "Slayed a Dragon", "hint": "Defeat the dragon / hero growth", "category": "Action Shooter"},
    "23": {"name": "Can't Cut Me Down", "hint": "Weapon merging / defeat the wave", "category": "Strategy Battle"},
    "24": {"name": "Warrior's Journey", "hint": "Dungeon crawler / sword heroine", "category": "Action Adventure"},
    "25": {"name": "Arad Warriors", "hint": "Dungeon crawler / sword warrior", "category": "Action Adventure"},
    "26": {"name": "Agents vs. Zombie Beasts", "hint": "Casual survival / hero growth", "category": "Casual Survival"},
    "27": {"name": "Hero Duel", "hint": "The duel begins / hero adventure", "category": "Strategy Battle"},
    "28": {"name": "Flying Blade Brawl", "hint": "The duel begins / hero adventure", "category": "Strategy Battle"},
}

SDK_PATTERNS = {
    "wechat_login": re.compile(r"\bwx\.login\b", re.IGNORECASE),
    "wechat_launch_options": re.compile(r"\bwx\.getLaunchOptionsSync\b", re.IGNORECASE),
    "wechat_share": re.compile(r"\bwx\.shareAppMessage\b", re.IGNORECASE),
    "bytedance_login": re.compile(r"\btt\.login\b", re.IGNORECASE),
    "bytedance_request": re.compile(r"\btt\.request\b", re.IGNORECASE),
    "bytedance_launch_options": re.compile(r"\btt\.getLaunchOptionsSync\b", re.IGNORECASE),
    "miniapp_sdk": re.compile(r"\bWXSdk\b|\bMiniGame\b|\bttGame\b", re.IGNORECASE),
    "ad_units": re.compile(r"adunit-[A-Za-z0-9_-]+", re.IGNORECASE),
    "banner_or_video_ads": re.compile(r"\b(showBanner|showVideo|showReward|createBannerAd|createRewardedVideoAd)\b", re.IGNORECASE),
    "sfplay_tracking": re.compile(r"sfplay\.net|yuema\.sfplay\.net", re.IGNORECASE),
}

TEXT_SUFFIXES = {".js", ".html", ".json", ".txt", ".md"}
EXCLUDED_SOURCE_ITEMS = [
    "login.php",
    "games_api.php",
    "games-admin.html",
    "chat/",
    "database/",
    "logs/",
    "user_caches/",
    "cache/",
]


def ensure_clean_output() -> None:
    resolved_output = OUTPUT_ROOT.resolve()
    resolved_parent = OUTPUT_PARENT.resolve()
    if resolved_output.parent != resolved_parent or resolved_output.name.lower() != "webarcade":
        raise RuntimeError(f"Refusing to prepare unexpected path: {resolved_output}")

    OUTPUT_ROOT.mkdir(parents=True, exist_ok=True)
    (OUTPUT_ROOT / "assets").mkdir(exist_ok=True)

    for relative_name in ["game", "previews"]:
        target = OUTPUT_ROOT / relative_name
        if target.exists():
            shutil.rmtree(target)
        target.mkdir(exist_ok=True)

    for relative_name in [
        "games.json",
        "sdk_audit_report.json",
        "excluded_components.json",
        "PUBLISHING_AUDIT.md",
        "favicon.ico",
    ]:
        target = OUTPUT_ROOT / relative_name
        if target.exists():
            target.unlink()


def load_source_catalog() -> dict:
    with (SOURCE_ROOT / "games.json").open("r", encoding="utf-8") as handle:
        return json.load(handle)


def load_publish_policy() -> dict:
    if not POLICY_PATH.exists():
        return {"approved_after_browser_sanitization": []}

    with POLICY_PATH.open("r", encoding="utf-8") as handle:
        policy = json.load(handle)

    policy.setdefault("approved_after_browser_sanitization", [])
    return policy


def scan_game_directory(game_id: str) -> dict:
    game_root = SOURCE_ROOT / "game" / game_id
    findings = []
    if not game_root.exists():
        return {"status": "missing", "matches": findings}

    for path in sorted(game_root.rglob("*")):
        if not path.is_file() or path.suffix.lower() not in TEXT_SUFFIXES:
            continue

        try:
            text = path.read_text(encoding="utf-8", errors="ignore")
        except OSError:
            continue

        hit_names = [name for name, pattern in SDK_PATTERNS.items() if pattern.search(text)]
        if hit_names:
            findings.append(
                {
                    "file": str(path.relative_to(SOURCE_ROOT)).replace("\\", "/"),
                    "signals": hit_names,
                }
            )

    status = "safe_for_now" if not findings else "under_review"
    return {"status": status, "matches": findings[:12]}


def build_catalog(source_catalog: dict, audit_report: dict, publish_policy: dict) -> list[dict]:
    translated_games = []
    generated_at = datetime.now(timezone.utc).isoformat()
    browser_sanitized_ids = set(publish_policy.get("approved_after_browser_sanitization", []))

    for entry in source_catalog["games"]:
        game_id = entry["id"]
        translation = TRANSLATIONS[game_id]
        audit = audit_report[game_id]
        browser_sanitized = game_id in browser_sanitized_ids
        is_live = audit["status"] == "safe_for_now" or browser_sanitized
        publication_mode = (
            "browser_sanitized"
            if browser_sanitized
            else ("static_scan_safe" if audit["status"] == "safe_for_now" else "held_for_review")
        )
        translated_games.append(
            {
                "id": game_id,
                "sort": entry.get("sort", 0),
                "name": translation["name"],
                "hint": translation["hint"],
                "category": translation["category"],
                "preview": entry["preview"],
                "path": entry["path"],
                "status": "live" if is_live else "under_review",
                "launchUrl": f"play.html?id={game_id}" if is_live else None,
                "publicationMode": publication_mode,
                "auditNote": (
                    "No WeChat, ByteDance, or ad SDK hits were found in the static scan."
                    if publication_mode == "static_scan_safe"
                    else (
                        "This title was promoted after browser sanitization. External links, platform login hooks, and mini-app ad/share APIs are suppressed in the public build."
                        if publication_mode == "browser_sanitized"
                        else "Static scan found mini-app or ad SDK traces. This title stays hidden until a deeper review is complete."
                    )
                ),
                "generatedAt": generated_at,
            }
        )

    translated_games.sort(key=lambda item: (item["sort"], item["id"]))
    return translated_games


def write_browser_safe_shim() -> None:
    if not SHIM_SOURCE_PATH.exists():
        raise FileNotFoundError(f"Browser-safe shim not found: {SHIM_SOURCE_PATH}")

    shutil.copy2(SHIM_SOURCE_PATH, OUTPUT_ROOT / "game" / "browser-safe-shim.js")


def write_user_save_bridge() -> None:
    if not SAVE_BRIDGE_SOURCE_PATH.exists():
        raise FileNotFoundError(f"User-save bridge not found: {SAVE_BRIDGE_SOURCE_PATH}")

    shutil.copy2(SAVE_BRIDGE_SOURCE_PATH, OUTPUT_ROOT / "game" / "user-save-bridge.js")


def patch_live_game_index(game: dict, target_game_dir: Path) -> None:
    index_path = target_game_dir / "index.html"
    if not index_path.exists():
        return

    text = index_path.read_text(encoding="utf-8", errors="ignore")
    shim_tag = '<script src="../browser-safe-shim.js"></script>'
    save_bridge_tag = '<script src="../user-save-bridge.js"></script>'
    csp_tag = f'<meta http-equiv="Content-Security-Policy" content="{CSP_DIRECTIVE}"/>'
    title_tag = f"<title>{game['name']} | Webarcade</title>"

    if "<title>" in text and "</title>" in text:
        start = text.index("<title>")
        end = text.index("</title>", start) + len("</title>")
        text = text[:start] + title_tag + text[end:]

    if csp_tag not in text and "</head>" in text:
        text = text.replace("</head>", f"  {csp_tag}\n</head>", 1)

    injection = shim_tag + "\n" + save_bridge_tag
    if shim_tag not in text and save_bridge_tag not in text:
        if "<script" in text:
            text = text.replace("<script", f"{injection}\n<script", 1)
        elif "</body>" in text:
            text = text.replace("</body>", f"{injection}\n</body>", 1)
    elif shim_tag in text and save_bridge_tag not in text:
        text = text.replace(shim_tag, f"{shim_tag}\n{save_bridge_tag}", 1)

    index_path.write_text(text, encoding="utf-8")


def prune_optional_game_files(target_game_dir: Path) -> None:
    error_dir = target_game_dir / "error"
    if error_dir.exists():
        shutil.rmtree(error_dir)


def copy_public_assets(games: list[dict]) -> None:
    shutil.copy2(SOURCE_ROOT / "favicon.ico", OUTPUT_ROOT / "favicon.ico")
    write_browser_safe_shim()
    write_user_save_bridge()

    for game in games:
        source_preview = SOURCE_ROOT / "game" / game["preview"]
        if not source_preview.exists():
            source_preview = SOURCE_ROOT / "game" / game["id"] / game["preview"]
        if source_preview.exists():
            shutil.copy2(source_preview, OUTPUT_ROOT / "previews" / game["preview"])

        if game["status"] != "live":
            continue

        target_game_dir = OUTPUT_ROOT / "game" / game["id"]
        shutil.copytree(SOURCE_ROOT / "game" / game["id"], target_game_dir, dirs_exist_ok=True)
        prune_optional_game_files(target_game_dir)
        patch_live_game_index(game, target_game_dir)


def write_json(path: Path, payload: dict | list) -> None:
    path.write_text(json.dumps(payload, ensure_ascii=False, indent=2) + "\n", encoding="utf-8")


def write_reports(games: list[dict], audit_report: dict, publish_policy: dict) -> None:
    live_ids = [game["id"] for game in games if game["status"] == "live"]
    held_ids = [game["id"] for game in games if game["status"] != "live"]
    browser_sanitized_ids = publish_policy.get("approved_after_browser_sanitization", [])

    write_json(
        OUTPUT_ROOT / "games.json",
        {
            "config": {"module": "webarcade", "previewPathPrefix": "previews/", "gamePathPrefix": "game/"},
            "summary": {"totalGames": len(games), "liveGames": len(live_ids), "underReviewGames": len(held_ids)},
            "games": games,
        },
    )
    write_json(
        OUTPUT_ROOT / "sdk_audit_report.json",
        {
            "generatedAt": datetime.now(timezone.utc).isoformat(),
            "sourceRoot": "local HTML5 source bundle",
            "excludedSourceItems": EXCLUDED_SOURCE_ITEMS,
            "browserSanitizedLiveGameIds": browser_sanitized_ids,
            "liveGameIds": live_ids,
            "underReviewGameIds": held_ids,
            "games": audit_report,
        },
    )
    write_json(
        OUTPUT_ROOT / "excluded_components.json",
        {"module": "webarcade", "omittedFromPublicImport": EXCLUDED_SOURCE_ITEMS},
    )

    report_lines = [
        "# Webarcade Publishing Audit",
        "",
        f"Generated: {datetime.now(timezone.utc).isoformat()}",
        "",
        "This public module intentionally excludes risky backend or account components from the original HTML5 bundle.",
        "Approved browser-sanitized titles are wrapped with a local shim that suppresses WeChat, ByteDance, ad, share, and external navigation behavior.",
        "",
        "## Omitted from the public module",
    ]
    report_lines.extend([f"- `{item}`" for item in EXCLUDED_SOURCE_ITEMS])
    report_lines.extend(
        [
            "",
            "## Public now",
            f"- `{', '.join(live_ids)}`",
            "",
            "These game folders are copied into the public Laragon site because they either passed the static SDK scan or were manually promoted after browser sanitization.",
            "",
            "## Browser-sanitized titles",
            f"- `{', '.join(browser_sanitized_ids) if browser_sanitized_ids else 'none'}`",
            "",
            "## Held for review",
            f"- `{', '.join(held_ids)}`",
            "",
            "These titles remain listed in the catalog, but they are not copied into the public module yet. The static scan found mini-app, ad, or tracking indicators that should be reviewed before publishing.",
            "",
            "## Detail by game",
        ]
    )

    for game_id in sorted(audit_report):
        findings = audit_report[game_id]["matches"]
        report_lines.append(f"### {game_id} - {TRANSLATIONS[game_id]['name']}")
        if not findings:
            report_lines.append("- No SDK or ad signatures were found in the scanned text assets.")
        else:
            for finding in findings:
                report_lines.append(f"- `{finding['file']}`: {', '.join(finding['signals'])}")
        report_lines.append("")

    (OUTPUT_ROOT / "PUBLISHING_AUDIT.md").write_text("\n".join(report_lines).strip() + "\n", encoding="utf-8")


def main() -> None:
    if not SOURCE_ROOT.exists():
        raise FileNotFoundError(f"Source bundle not found: {SOURCE_ROOT}")

    ensure_clean_output()
    source_catalog = load_source_catalog()
    publish_policy = load_publish_policy()
    audit_report = {entry["id"]: scan_game_directory(entry["id"]) for entry in source_catalog["games"]}
    games = build_catalog(source_catalog, audit_report, publish_policy)
    copy_public_assets(games)
    write_reports(games, audit_report, publish_policy)

    live_ids = [game["id"] for game in games if game["status"] == "live"]
    held_ids = [game["id"] for game in games if game["status"] != "live"]
    print(f"Imported {len(games)} HTML5 games into {OUTPUT_ROOT}")
    print(f"Live now: {', '.join(live_ids)}")
    print(f"Under review: {', '.join(held_ids)}")


if __name__ == "__main__":
    main()
