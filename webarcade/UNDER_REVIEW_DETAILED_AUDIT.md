# Under-Review HTML5 Audit

Generated: 2026-04-07T11:57:32.408969+00:00

This report expands the first-pass SDK scan for the 25 HTML5 titles that are still blocked from the public `webarcade` module.

## Summary
- Under-review titles: `13`
- High risk: `13`
- Medium risk: `0`
- Low risk: `0`

## How to read this
- `high`: deep mini-app SDK, tracking, login, or remote-request behavior; keep blocked.
- `medium`: platform-dependent browser blockers are present; maybe salvageable with targeted patching.
- `low`: mostly ad/share wrappers; likely the best candidates for a cleanup pass later.

## Publish recommendations
- Likely safe after ad/share cleanup: `none`
- Possible after targeted patching: `none`
- Keep blocked: `02, 15, 16, 19, 20, 22, 25, 28, 06, 08, 09, 12, 11`

## Per-game detail

### 02 - Breakout Assault
- Category: `Action Shooter`
- Hint: All-out breakout / nonstop combat
- Risk tier: `high`
- Recommendation: `keep_blocked`
- Notes: A bundled mini-app SDK and analytics/openid handling are embedded in the title.
- Signals: `banner_or_video_ads, miniapp_sdk`
- Evidence files:
  - `game/02/assets/main/index.js` -> `miniapp_sdk, banner_or_video_ads`
  - `game/02/assets/UI/index.js` -> `banner_or_video_ads`
  - `game/02/src/assets/uniSdk/uniSdk.min.js` -> `miniapp_sdk, banner_or_video_ads`

### 15 - Beggar to Emperor
- Category: `Strategy Battle`
- Hint: Underdog rise / emperor builder
- Risk tier: `high`
- Recommendation: `keep_blocked`
- Notes: ByteDance requests, a mini-app SDK, payment/backend domains, and rewarded/interstitial ads are all present.
- Signals: `ad_units, banner_or_video_ads, bytedance_request, miniapp_sdk, wechat_launch_options, wechat_share`
- Evidence files:
  - `game/15/assets/main/index.f337f.js` -> `wechat_launch_options, wechat_share, bytedance_request, miniapp_sdk, ad_units, banner_or_video_ads`

### 16 - Wukong's Immortal Path
- Category: `Fantasy Adventure`
- Hint: Idle cultivation / ascension trials
- Risk tier: `high`
- Recommendation: `keep_blocked`
- Notes: WeChat ad/share hooks are mixed with hardcoded dev or internal endpoints and external service domains.
- Signals: `ad_units, banner_or_video_ads, wechat_launch_options, wechat_share`
- Evidence files:
  - `game/16/assets/main/index.51609.js` -> `wechat_launch_options, wechat_share, ad_units, banner_or_video_ads`

### 19 - Blast the Ghosts
- Category: `Casual Survival`
- Hint: Idle action / hero growth
- Risk tier: `high`
- Recommendation: `keep_blocked`
- Notes: Dual login flows, analytics, and dev/cooperation endpoints are present in the application script.
- Signals: `ad_units, banner_or_video_ads, bytedance_login, wechat_login`
- Evidence files:
  - `game/19/assets/game_script/index.a12d0.js` -> `wechat_login, bytedance_login, ad_units, banner_or_video_ads`

### 20 - Hero on Paper
- Category: `Casual Survival`
- Hint: Idle training / hero growth
- Risk tier: `high`
- Recommendation: `keep_blocked`
- Notes: This is the riskiest title in the pack, with `sfplay` tracking, login/request hooks, and internal-style endpoints.
- Signals: `ad_units, banner_or_video_ads, bytedance_launch_options, bytedance_login, bytedance_request, sfplay_tracking, wechat_launch_options, wechat_login, wechat_share`
- Evidence files:
  - `game/20/assets/main/index.070c8.js` -> `wechat_login, wechat_share, bytedance_login, bytedance_request, bytedance_launch_options, ad_units, banner_or_video_ads, sfplay_tracking`
  - `game/20/src/assets/scripts/plugins/sfdata.025e9.js` -> `wechat_login, wechat_launch_options, bytedance_login, bytedance_launch_options, sfplay_tracking`
  - `game/20/src/assets/scripts/plugins/sfzt.e6b28.js` -> `bytedance_login, bytedance_request, bytedance_launch_options, sfplay_tracking`

### 22 - Slayed a Dragon
- Category: `Action Shooter`
- Hint: Defeat the dragon / hero growth
- Risk tier: `high`
- Recommendation: `keep_blocked`
- Notes: Mini-app SDK glue, telemetry domains, local/internal endpoints, and login/share hooks are mixed together.
- Signals: `ad_units, banner_or_video_ads, miniapp_sdk, wechat_launch_options, wechat_login, wechat_share`
- Evidence files:
  - `game/22/assets/main/index.2e432.js` -> `wechat_login, wechat_launch_options, wechat_share, miniapp_sdk, ad_units, banner_or_video_ads`
  - `game/22/assets/resources/import/01/0129f0881.b524d.json` -> `banner_or_video_ads`

### 25 - Arad Warriors
- Category: `Action Adventure`
- Hint: Dungeon crawler / sword warrior
- Risk tier: `high`
- Recommendation: `keep_blocked`
- Notes: WeChat login, ByteDance request/share, heavy ads, and several external service domains are bundled into the title.
- Signals: `ad_units, banner_or_video_ads, bytedance_request, wechat_login`
- Evidence files:
  - `game/25/assets/main/index.17774.js` -> `wechat_login, bytedance_request, ad_units, banner_or_video_ads`

### 28 - Flying Blade Brawl
- Category: `Strategy Battle`
- Hint: The duel begins / hero adventure
- Risk tier: `high`
- Recommendation: `keep_blocked`
- Notes: Mini-app SDK code, login/share hooks, and remote service domains are embedded in project code.
- Signals: `ad_units, banner_or_video_ads, miniapp_sdk, wechat_launch_options, wechat_login, wechat_share`
- Evidence files:
  - `game/28/src/project.19ff7.js` -> `wechat_login, wechat_launch_options, wechat_share, miniapp_sdk, ad_units, banner_or_video_ads`

### 06 - Carefree Immortal Quest
- Category: `Fantasy Adventure`
- Hint: Idle cultivation / heavenly trials
- Risk tier: `high`
- Recommendation: `keep_blocked`
- Notes: This build is hardwired to WeChat and ByteDance ad and scene APIs, including launch-option logic and mini-program jumps.
- Signals: `ad_units, banner_or_video_ads, bytedance_launch_options, wechat_launch_options, wechat_share`
- Evidence files:
  - `game/06/assets/main/index.js` -> `wechat_launch_options, wechat_share, bytedance_launch_options, ad_units, banner_or_video_ads`

### 08 - Go, Capybara!
- Category: `Fantasy Adventure`
- Hint: Cute creature challenge / whimsical adventure
- Risk tier: `high`
- Recommendation: `keep_blocked`
- Notes: A dedicated `p8sdk-wechat` layer and ad-attribution fields make this too coupled to mini-app distribution.
- Signals: `ad_units, banner_or_video_ads, bytedance_request, wechat_launch_options, wechat_login, wechat_share`
- Evidence files:
  - `game/08/assets/main/index.8fb46.js` -> `wechat_launch_options, wechat_share, bytedance_request, ad_units, banner_or_video_ads`
  - `game/08/src/assets/_plugs/loading/p8sdk-wechat-2.0.20.25a9b.js` -> `wechat_login, wechat_launch_options, wechat_share, banner_or_video_ads`

### 09 - Ghosts in Space
- Category: `Action Shooter`
- Hint: Space suspense / ghost hunt
- Risk tier: `high`
- Recommendation: `keep_blocked`
- Notes: WeChat and ByteDance ad stacks are both embedded in the application bundle.
- Signals: `ad_units, banner_or_video_ads, wechat_share`
- Evidence files:
  - `game/09/assets/main/index.6c761.js` -> `wechat_share, ad_units, banner_or_video_ads`

### 12 - Immortal Cultivation Simulator
- Category: `Fantasy Adventure`
- Hint: Idle cultivation / ascension trials
- Risk tier: `high`
- Recommendation: `keep_blocked`
- Notes: Multi-platform ads, jumps, and telemetry domains are embedded directly in the game code.
- Signals: `ad_units, banner_or_video_ads, bytedance_launch_options, wechat_launch_options, wechat_login, wechat_share`
- Evidence files:
  - `game/12/assets/main/index.c41fe.js` -> `wechat_login, wechat_launch_options, wechat_share, bytedance_launch_options, ad_units, banner_or_video_ads`

### 11 - When Dreams Meet Fairy Tales
- Category: `Management Sim`
- Hint: Fairytale town / dream management
- Risk tier: `high`
- Recommendation: `keep_blocked`
- Notes: This title is dense with ByteDance traffic, ad-attribution, and multi-platform mini-app hooks.
- Signals: `ad_units, banner_or_video_ads, bytedance_launch_options, bytedance_login, bytedance_request, miniapp_sdk, wechat_launch_options, wechat_login, wechat_share`
- Evidence files:
  - `game/11/assets/main/index.e7338.js` -> `wechat_login, wechat_launch_options, wechat_share, bytedance_login, bytedance_request, bytedance_launch_options, miniapp_sdk, ad_units, banner_or_video_ads`
