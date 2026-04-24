# GitHub-Only Backup Notes

## Current reality

The public GitHub repository is now a strong source snapshot and rebuild checkpoint, but it is not a full binary mirror of the local machine.

Why:

- the local media library is about `105 GB`
- regular GitHub repositories block files above `100 MiB`
- GitHub recommends repositories stay small, ideally under `1 GB` and strongly under `5 GB`

That means the full local ROM and CHD library should not be pushed into the normal Git history.

## What the GitHub repo already gives you

- source code
- setup docs
- database schema bootstrap
- cover pipeline scripts
- stable restore tags/releases
- generated local covers that were practical to commit

## What is still outside GitHub

- `fc/games`
- `gba/games`
- `gb/games`
- `ps1/games`
- `mame/games`
- local-only secret overrides

## If you want a more GitHub-centered strategy later

The only realistic GitHub-centered options are:

1. keep source in the normal repo and store selected media in GitHub Releases
2. use Git LFS for a very small curated subset, not the whole 105 GB library
3. keep the repo as the rebuild source of truth, and keep full media in private storage

## Recommended interpretation

Treat the repo as:

- `source backup`
- `restore guide`
- `rebuild control center`

not as:

- a literal full binary clone of the current Laragon disk
