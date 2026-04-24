# Webarcade Publishing Audit

Generated: 2026-04-07T12:23:14.660975+00:00

This public module intentionally excludes risky backend or account components from the original HTML5 bundle.
Approved browser-sanitized titles are wrapped with a local shim that suppresses WeChat, ByteDance, ad, share, and external navigation behavior.

## Omitted from the public module
- `login.php`
- `games_api.php`
- `games-admin.html`
- `chat/`
- `database/`
- `logs/`
- `user_caches/`
- `cache/`

## Public now
- `01, 02, 03, 04, 05, 10, 13, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 06, 07, 08, 09, 12, 11`

These game folders are copied into the public Laragon site because they either passed the static SDK scan or were manually promoted after browser sanitization.

## Browser-sanitized titles
- `01, 02, 04, 05, 06, 07, 08, 09, 10, 11, 12, 13, 15, 16, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28`

## Held for review
- ``

These titles remain listed in the catalog, but they are not copied into the public module yet. The static scan found mini-app, ad, or tracking indicators that should be reviewed before publishing.

## Detail by game
### 01 - Doomsday Agents
- `game/01/assets/main/index.js`: wechat_login, wechat_share, banner_or_video_ads

### 02 - Breakout Assault
- `game/02/assets/main/index.js`: miniapp_sdk, banner_or_video_ads
- `game/02/assets/UI/index.js`: banner_or_video_ads
- `game/02/src/assets/uniSdk/uniSdk.min.js`: miniapp_sdk, banner_or_video_ads

### 03 - Uncle Wang's Happy Life
- No SDK or ad signatures were found in the scanned text assets.

### 04 - Earn That First Billion
- `game/04/assets/main/index.js`: wechat_share, ad_units, banner_or_video_ads

### 05 - Legend Quest
- `game/05/assets/main/index.4e81b.js`: banner_or_video_ads

### 06 - Carefree Immortal Quest
- `game/06/assets/main/index.js`: wechat_launch_options, wechat_share, bytedance_launch_options, ad_units, banner_or_video_ads

### 07 - Chubby Bird Fitness Club
- `game/07/assets/main/index.js`: wechat_login, wechat_share, banner_or_video_ads

### 08 - Go, Capybara!
- `game/08/assets/main/index.8fb46.js`: wechat_launch_options, wechat_share, bytedance_request, ad_units, banner_or_video_ads
- `game/08/src/assets/_plugs/loading/p8sdk-wechat-2.0.20.25a9b.js`: wechat_login, wechat_launch_options, wechat_share, banner_or_video_ads

### 09 - Ghosts in Space
- `game/09/assets/main/index.6c761.js`: wechat_share, ad_units, banner_or_video_ads

### 10 - Pig Catcher
- `game/10/assets/main/index.bd5b6.js`: banner_or_video_ads

### 11 - When Dreams Meet Fairy Tales
- `game/11/assets/main/index.e7338.js`: wechat_login, wechat_launch_options, wechat_share, bytedance_login, bytedance_request, bytedance_launch_options, miniapp_sdk, ad_units, banner_or_video_ads

### 12 - Immortal Cultivation Simulator
- `game/12/assets/main/index.c41fe.js`: wechat_login, wechat_launch_options, wechat_share, bytedance_launch_options, ad_units, banner_or_video_ads

### 13 - Meow Tycoon Story
- `game/13/assets/main/index.ced66.js`: wechat_login, wechat_launch_options, wechat_share, miniapp_sdk, ad_units, banner_or_video_ads

### 15 - Beggar to Emperor
- `game/15/assets/main/index.f337f.js`: wechat_launch_options, wechat_share, bytedance_request, miniapp_sdk, ad_units, banner_or_video_ads

### 16 - Wukong's Immortal Path
- `game/16/assets/main/index.51609.js`: wechat_launch_options, wechat_share, ad_units, banner_or_video_ads

### 17 - Idle Big Boss
- No SDK or ad signatures were found in the scanned text assets.

### 18 - Soul Battle Continent
- `game/18/assets/main/index.8bfe0.js`: wechat_share, banner_or_video_ads

### 19 - Blast the Ghosts
- `game/19/assets/game_script/index.a12d0.js`: wechat_login, bytedance_login, ad_units, banner_or_video_ads

### 20 - Hero on Paper
- `game/20/assets/main/index.070c8.js`: wechat_login, wechat_share, bytedance_login, bytedance_request, bytedance_launch_options, ad_units, banner_or_video_ads, sfplay_tracking
- `game/20/src/assets/scripts/plugins/sfdata.025e9.js`: wechat_login, wechat_launch_options, bytedance_login, bytedance_launch_options, sfplay_tracking
- `game/20/src/assets/scripts/plugins/sfzt.e6b28.js`: bytedance_login, bytedance_request, bytedance_launch_options, sfplay_tracking

### 21 - Claim the Castle
- `game/21/assets/main/index.b4ae0.js`: wechat_login, bytedance_login, bytedance_request, bytedance_launch_options, ad_units, banner_or_video_ads

### 22 - Slayed a Dragon
- `game/22/assets/main/index.2e432.js`: wechat_login, wechat_launch_options, wechat_share, miniapp_sdk, ad_units, banner_or_video_ads
- `game/22/assets/resources/import/01/0129f0881.b524d.json`: banner_or_video_ads

### 23 - Can't Cut Me Down
- `game/23/assets/main/index.44eb7.js`: wechat_launch_options, wechat_share, bytedance_request, ad_units, banner_or_video_ads

### 24 - Warrior's Journey
- `game/24/assets/main/index.ee45d.js`: banner_or_video_ads

### 25 - Arad Warriors
- `game/25/assets/main/index.17774.js`: wechat_login, bytedance_request, ad_units, banner_or_video_ads

### 26 - Agents vs. Zombie Beasts
- `game/26/assets/main/index.a9fb8.js`: ad_units, banner_or_video_ads

### 27 - Hero Duel
- `game/27/assets/main/index.67e2a.js`: ad_units, banner_or_video_ads

### 28 - Flying Blade Brawl
- `game/28/src/project.19ff7.js`: wechat_login, wechat_launch_options, wechat_share, miniapp_sdk, ad_units, banner_or_video_ads
