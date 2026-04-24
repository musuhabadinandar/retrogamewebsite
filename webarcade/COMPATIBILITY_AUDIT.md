# Webarcade Compatibility Audit

Updated: 2026-04-07

## Confirmed backend-dependent titles

- `01` Doomsday Agents
  - Hardcoded retired endpoints were found in [`game/01/assets/main/index.js`](./game/01/assets/main/index.js):
    - `https://api.play.qcymw.com:39001`
    - `wss://api.play.qcymw.com:39001/sh`
    - `https://api.play.qcymw.com:39002`
    - `wss://api.play.qcymw.com:39002/sh`
  - The boot path includes `/isAlive`, websocket connect, WeChat-style login, and `GetRegionData` flow.
  - Current result in local-only publish mode:
    - can stall at `0%` loading
    - not caused by Laragon itself
    - not caused by EmulatorJS
    - caused by legacy game code expecting a vendor backend that is no longer available

## Save behavior notes

- Some titles resume in the middle of a run because local/browser save data is restored automatically.
- Signed-in users restore save data from `webarcade_cloud_saves`.
- Guest users restore save data from browser storage only.
- Use the reset buttons on `play.html?id=XX` to verify whether a title is truly broken or simply resuming old progress.

## Publishing rule

- A title should not be advertised as fully compatible unless it can boot without retired vendor login, heartbeat, websocket, or region-data dependencies.
