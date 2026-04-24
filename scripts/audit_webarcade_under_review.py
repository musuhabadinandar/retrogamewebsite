from __future__ import annotations

import json
from collections import Counter
from datetime import datetime, timezone
from pathlib import Path


WEBARCADE_ROOT = Path(r"C:\laragon\www\webarcade")
AUDIT_REPORT_PATH = WEBARCADE_ROOT / "sdk_audit_report.json"
CATALOG_PATH = WEBARCADE_ROOT / "games.json"
OUTPUT_JSON = WEBARCADE_ROOT / "under_review_detailed_audit.json"
OUTPUT_MD = WEBARCADE_ROOT / "UNDER_REVIEW_DETAILED_AUDIT.md"

HIGH_SIGNALS = {"sfplay_tracking", "bytedance_request", "bytedance_login"}
MEDIUM_SIGNALS = {
    "miniapp_sdk",
    "wechat_login",
    "wechat_launch_options",
    "bytedance_launch_options",
}
LOW_SIGNALS = {"ad_units", "banner_or_video_ads", "wechat_share"}

MANUAL_REVIEW = {
    "01": {
        "riskTier": "high",
        "recommendation": "possible_after_targeted_patch",
        "reviewNotes": "WeChat login, request, analytics, and several ad surfaces are present in application code.",
    },
    "02": {
        "riskTier": "high",
        "recommendation": "keep_blocked",
        "reviewNotes": "A bundled mini-app SDK and analytics/openid handling are embedded in the title.",
    },
    "04": {
        "riskTier": "high",
        "recommendation": "possible_after_targeted_patch",
        "reviewNotes": "WeChat ad/share hooks and platform detection are present, but a hardcoded backend was not obvious in the first manual pass.",
    },
    "05": {
        "riskTier": "low",
        "recommendation": "likely_safe_after_ad_share_cleanup",
        "reviewNotes": "Only light ad residue surfaced after excluding engine/runtime noise.",
    },
    "06": {
        "riskTier": "high",
        "recommendation": "keep_blocked",
        "reviewNotes": "This build is hardwired to WeChat and ByteDance ad and scene APIs, including launch-option logic and mini-program jumps.",
    },
    "07": {
        "riskTier": "high",
        "recommendation": "possible_after_targeted_patch",
        "reviewNotes": "WeChat ad/share/jump paths and analytics are present, but the title may still be recoverable with a heavy browser patch.",
    },
    "08": {
        "riskTier": "high",
        "recommendation": "keep_blocked",
        "reviewNotes": "A dedicated `p8sdk-wechat` layer and ad-attribution fields make this too coupled to mini-app distribution.",
    },
    "09": {
        "riskTier": "high",
        "recommendation": "keep_blocked",
        "reviewNotes": "WeChat and ByteDance ad stacks are both embedded in the application bundle.",
    },
    "10": {
        "riskTier": "low",
        "recommendation": "likely_safe_after_ad_share_cleanup",
        "reviewNotes": "No strong application-level SDK dependency surfaced beyond light ad residue.",
    },
    "11": {
        "riskTier": "high",
        "recommendation": "keep_blocked",
        "reviewNotes": "This title is dense with ByteDance traffic, ad-attribution, and multi-platform mini-app hooks.",
    },
    "12": {
        "riskTier": "high",
        "recommendation": "keep_blocked",
        "reviewNotes": "Multi-platform ads, jumps, and telemetry domains are embedded directly in the game code.",
    },
    "13": {
        "riskTier": "high",
        "recommendation": "possible_after_targeted_patch",
        "reviewNotes": "WeChat share/jump/network paths and attribution fields are present, but a later salvage pass is still plausible.",
    },
    "15": {
        "riskTier": "high",
        "recommendation": "keep_blocked",
        "reviewNotes": "ByteDance requests, a mini-app SDK, payment/backend domains, and rewarded/interstitial ads are all present.",
    },
    "16": {
        "riskTier": "high",
        "recommendation": "keep_blocked",
        "reviewNotes": "WeChat ad/share hooks are mixed with hardcoded dev or internal endpoints and external service domains.",
    },
    "18": {
        "riskTier": "medium",
        "recommendation": "likely_safe_after_ad_share_cleanup",
        "reviewNotes": "The title carries WeChat share plus banner/interstitial/rewarded ad hooks, but no strong hardcoded backend was found in the manual pass.",
    },
    "19": {
        "riskTier": "high",
        "recommendation": "keep_blocked",
        "reviewNotes": "Dual login flows, analytics, and dev/cooperation endpoints are present in the application script.",
    },
    "20": {
        "riskTier": "high",
        "recommendation": "keep_blocked",
        "reviewNotes": "This is the riskiest title in the pack, with `sfplay` tracking, login/request hooks, and internal-style endpoints.",
    },
    "21": {
        "riskTier": "medium",
        "recommendation": "possible_after_targeted_patch",
        "reviewNotes": "Auth and network hooks exist, but the dependency surface is narrower than the hard-blocked titles.",
    },
    "22": {
        "riskTier": "high",
        "recommendation": "keep_blocked",
        "reviewNotes": "Mini-app SDK glue, telemetry domains, local/internal endpoints, and login/share hooks are mixed together.",
    },
    "23": {
        "riskTier": "medium",
        "recommendation": "possible_after_targeted_patch",
        "reviewNotes": "Launch/share plus ByteDance request paths and external profile or asset domains suggest a patchable but non-trivial cleanup.",
    },
    "24": {
        "riskTier": "low",
        "recommendation": "likely_safe_after_ad_share_cleanup",
        "reviewNotes": "The manual pass only found banner-ad style hooks and a light `openid` reference.",
    },
    "25": {
        "riskTier": "high",
        "recommendation": "keep_blocked",
        "reviewNotes": "WeChat login, ByteDance request/share, heavy ads, and several external service domains are bundled into the title.",
    },
    "26": {
        "riskTier": "medium",
        "recommendation": "likely_safe_after_ad_share_cleanup",
        "reviewNotes": "This looks mostly ad-driven, but a couple of external domains still keep it above a pure low-risk cleanup case.",
    },
    "27": {
        "riskTier": "medium",
        "recommendation": "likely_safe_after_ad_share_cleanup",
        "reviewNotes": "The game is ad-heavy and still carries a game-club style hook and an external domain.",
    },
    "28": {
        "riskTier": "high",
        "recommendation": "keep_blocked",
        "reviewNotes": "Mini-app SDK code, login/share hooks, and remote service domains are embedded in project code.",
    },
}


def load_json(path: Path) -> dict:
    return json.loads(path.read_text(encoding="utf-8"))


def classify(signals: set[str]) -> tuple[str, str, str]:
    if signals & HIGH_SIGNALS:
        return (
            "high",
            "keep_blocked",
            "Deep mini-app or tracking hooks are present. This title should stay blocked until it is reverse engineered and retested in a normal browser.",
        )

    if "miniapp_sdk" in signals and (
        "wechat_login" in signals
        or "wechat_launch_options" in signals
        or "bytedance_launch_options" in signals
    ):
        return (
            "high",
            "keep_blocked",
            "Mini-app SDK glue is mixed with platform login or scene APIs, so the browser build is likely to depend on code paths that do not exist on the public web.",
        )

    if len(signals) >= 6:
        return (
            "high",
            "keep_blocked",
            "This title carries several platform-specific hooks at once, which makes a safe browser release unlikely without invasive patching.",
        )

    if signals <= LOW_SIGNALS:
        return (
            "low",
            "likely_safe_after_ad_share_cleanup",
            "The static hits are limited to ad or share hooks. This title looks like a good candidate for a later patch pass that stubs those wrappers and re-tests gameplay.",
        )

    if signals & MEDIUM_SIGNALS:
        return (
            "medium",
            "possible_after_targeted_patch",
            "This title references mini-app login, launch-option, or SDK helpers. It may be salvageable, but it should not be published again without targeted browser fallbacks.",
        )

    return (
        "medium",
        "manual_review_needed",
        "The title has custom platform hooks that still need a manual browser-focused review before it can move out of quarantine.",
    )


def main() -> None:
    audit_report = load_json(AUDIT_REPORT_PATH)
    catalog = load_json(CATALOG_PATH)
    names = {entry["id"]: entry["name"] for entry in catalog["games"]}
    hints = {entry["id"]: entry["hint"] for entry in catalog["games"]}
    categories = {entry["id"]: entry["category"] for entry in catalog["games"]}

    detailed = []
    risk_counter: Counter[str] = Counter()
    recommendation_counter: Counter[str] = Counter()

    for game_id in audit_report["underReviewGameIds"]:
        matches = audit_report["games"][game_id]["matches"]
        signals = sorted({signal for match in matches for signal in match["signals"]})
        override = MANUAL_REVIEW.get(game_id)
        if override:
            risk_tier = override["riskTier"]
            recommendation_key = override["recommendation"]
            recommendation_text = override["reviewNotes"]
        else:
            risk_tier, recommendation_key, recommendation_text = classify(set(signals))
        risk_counter[risk_tier] += 1
        recommendation_counter[recommendation_key] += 1
        detailed.append(
            {
                "id": game_id,
                "name": names[game_id],
                "hint": hints[game_id],
                "category": categories[game_id],
                "riskTier": risk_tier,
                "recommendation": recommendation_key,
                "recommendationText": recommendation_text,
                "signals": signals,
                "evidence": matches,
            }
        )

    payload = {
        "generatedAt": datetime.now(timezone.utc).isoformat(),
        "scope": "Detailed static audit of the 25 HTML5 titles that remain under review in the public Webarcade module.",
        "summary": {
            "totalUnderReview": len(detailed),
            "riskTiers": dict(risk_counter),
            "recommendations": dict(recommendation_counter),
        },
        "games": detailed,
    }
    OUTPUT_JSON.write_text(json.dumps(payload, ensure_ascii=False, indent=2) + "\n", encoding="utf-8")

    lines = [
        "# Under-Review HTML5 Audit",
        "",
        f"Generated: {payload['generatedAt']}",
        "",
        "This report expands the first-pass SDK scan for the 25 HTML5 titles that are still blocked from the public `webarcade` module.",
        "",
        "## Summary",
        f"- Under-review titles: `{payload['summary']['totalUnderReview']}`",
        f"- High risk: `{risk_counter.get('high', 0)}`",
        f"- Medium risk: `{risk_counter.get('medium', 0)}`",
        f"- Low risk: `{risk_counter.get('low', 0)}`",
        "",
        "## How to read this",
        "- `high`: deep mini-app SDK, tracking, login, or remote-request behavior; keep blocked.",
        "- `medium`: platform-dependent browser blockers are present; maybe salvageable with targeted patching.",
        "- `low`: mostly ad/share wrappers; likely the best candidates for a cleanup pass later.",
        "",
        "## Publish recommendations",
    ]

    safe_ids = [entry["id"] for entry in detailed if entry["recommendation"] == "likely_safe_after_ad_share_cleanup"]
    patch_ids = [entry["id"] for entry in detailed if entry["recommendation"] == "possible_after_targeted_patch"]
    blocked_ids = [entry["id"] for entry in detailed if entry["recommendation"] == "keep_blocked"]
    lines.append(f"- Likely safe after ad/share cleanup: `{', '.join(safe_ids) if safe_ids else 'none'}`")
    lines.append(f"- Possible after targeted patching: `{', '.join(patch_ids) if patch_ids else 'none'}`")
    lines.append(f"- Keep blocked: `{', '.join(blocked_ids) if blocked_ids else 'none'}`")
    lines.append("")
    lines.append("## Per-game detail")
    lines.append("")

    for entry in detailed:
        lines.append(f"### {entry['id']} - {entry['name']}")
        lines.append(f"- Category: `{entry['category']}`")
        lines.append(f"- Hint: {entry['hint']}")
        lines.append(f"- Risk tier: `{entry['riskTier']}`")
        lines.append(f"- Recommendation: `{entry['recommendation']}`")
        lines.append(f"- Notes: {entry['recommendationText']}")
        lines.append(f"- Signals: `{', '.join(entry['signals'])}`")
        if entry["evidence"]:
            lines.append("- Evidence files:")
            for match in entry["evidence"]:
                lines.append(
                    f"  - `{match['file']}` -> `{', '.join(match['signals'])}`"
                )
        lines.append("")

    OUTPUT_MD.write_text("\n".join(lines).strip() + "\n", encoding="utf-8")
    print(f"Wrote {OUTPUT_JSON}")
    print(f"Wrote {OUTPUT_MD}")


if __name__ == "__main__":
    main()
