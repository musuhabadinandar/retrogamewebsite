<?php
declare(strict_types=1);

function game_site_root(): string
{
    static $siteRoot = null;

    if ($siteRoot === null) {
        $resolved = realpath(__DIR__ . '/../..');
        $siteRoot = $resolved !== false ? $resolved : dirname(__DIR__, 2);
    }

    return $siteRoot;
}

function asset_url_from_path(string $path): string
{
    $path = str_replace('\\', '/', $path);
    $parts = array_filter(explode('/', $path), static fn($part) => $part !== '');
    return implode('/', array_map('rawurlencode', $parts));
}

function local_path_from_url(string $url): string
{
    $path = parse_url($url, PHP_URL_PATH);
    if (!is_string($path) || $path === '') {
        $path = $url;
    }

    $path = rawurldecode($path);

    return game_site_root() . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, ltrim($path, '/\\'));
}

function decode_legacy_game_file(string $encoded): string
{
    $encoded = str_replace(' ', '+', $encoded);
    $encoded = strtr($encoded, '-_', '+/');
    $encoded .= str_repeat('=', (4 - strlen($encoded) % 4) % 4);

    $decoded = base64_decode($encoded, true);
    return is_string($decoded) ? $decoded : '';
}

function has_unsafe_game_file_path(string $file): bool
{
    $normalized = str_replace('\\', '/', $file);
    if ($normalized === '' || str_starts_with($normalized, '/') || preg_match('#^[A-Za-z]:/#', $normalized)) {
        return true;
    }

    foreach (explode('/', $normalized) as $part) {
        if ($part === '..') {
            return true;
        }
    }

    return false;
}

function detect_game_system_slug(array $game): string
{
    $gameUrl = isset($game['game_url']) ? (string) $game['game_url'] : '';
    $gamePath = parse_url($gameUrl, PHP_URL_PATH);

    if (!is_string($gamePath) || $gamePath === '') {
        return 'default';
    }

    $system = strtolower((string) strtok(trim($gamePath, '/'), '/'));

    return match ($system) {
        'fc', 'gba', 'gb', 'ps1', 'mame' => $system,
        default => 'default',
    };
}

function game_system_fallback_image_url(string $system): string
{
    $fallbacks = [
        'fc' => 'common-file/img/system-fallbacks/nes-fallback.svg',
        'gba' => 'common-file/img/system-fallbacks/gba-fallback.svg',
        'gb' => 'common-file/img/system-fallbacks/gb-fallback.svg',
        'ps1' => 'common-file/img/system-fallbacks/ps1-fallback.svg',
        'mame' => 'common-file/img/system-fallbacks/mame-fallback.svg',
        'default' => 'common-file/img/system-fallbacks/default-fallback.svg',
    ];

    return $fallbacks[$system] ?? $fallbacks['default'];
}

function resolve_game_fallback_image_url(array $game): string
{
    return game_system_fallback_image_url(detect_game_system_slug($game));
}

function resolve_game_image_url(array $game): string
{
    static $memo = [];
    $fallbackImage = resolve_game_fallback_image_url($game);

    $memoKey = (string) ($game['id'] ?? '') . '|' . (string) ($game['image_url'] ?? '') . '|' . (string) ($game['game_url'] ?? '');
    if (isset($memo[$memoKey])) {
        return $memo[$memoKey];
    }

    $storedImage = isset($game['image_url']) ? (string) $game['image_url'] : '';
    if ($storedImage !== '' && (preg_match('#^https?://#i', $storedImage) || str_starts_with($storedImage, '//'))) {
        return $memo[$memoKey] = $storedImage;
    }

    if ($storedImage !== '' && $storedImage !== '/common-file/img/default-game.jpg' && is_file(local_path_from_url($storedImage))) {
        return $memo[$memoKey] = $storedImage;
    }

    $gameUrl = isset($game['game_url']) ? (string) $game['game_url'] : '';
    $gamePath = parse_url($gameUrl, PHP_URL_PATH);
    $queryString = parse_url($gameUrl, PHP_URL_QUERY);
    if (!is_string($gamePath) || !is_string($queryString)) {
        return $memo[$memoKey] = $fallbackImage;
    }

    parse_str($queryString, $params);
    $file = isset($params['file']) && is_string($params['file']) ? $params['file'] : '';
    if ($file === '' && isset($params['f']) && is_string($params['f'])) {
        $file = decode_legacy_game_file($params['f']);
    }

    $system = strtok(trim($gamePath, '/'), '/');
    if (!in_array($system, ['fc', 'gba', 'gb', 'ps1', 'mame'], true) || has_unsafe_game_file_path($file)) {
        return $memo[$memoKey] = $fallbackImage;
    }

    $file = str_replace('\\', '/', $file);
    $fileBase = pathinfo($file, PATHINFO_FILENAME);
    $folderBase = basename(dirname($file));
    $names = array_values(array_unique(array_filter([$fileBase, $folderBase])));
    if ($system === 'ps1') {
        $folders = ['img_big', 'img'];
    } elseif ($system === 'gba') {
        $folders = ['img', 'img_big'];
    } else {
        $folders = ['img'];
    }
    $extensions = in_array($system, ['gba', 'ps1', 'mame'], true) ? ['jpg', 'png', 'jpeg', 'webp', 'svg'] : ['png', 'jpg', 'jpeg', 'svg'];

    foreach ($names as $name) {
        foreach ($folders as $folder) {
            foreach ($extensions as $extension) {
                $candidate = $system . '/' . $folder . '/' . $name . '.' . $extension;
                if (is_file(game_site_root() . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $candidate))) {
                    return $memo[$memoKey] = asset_url_from_path($candidate);
                }
            }
        }
    }

    if ($system === 'ps1' && is_file(game_site_root() . DIRECTORY_SEPARATOR . 'ps1' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'default-ps1.svg')) {
        return $memo[$memoKey] = 'ps1/img/default-ps1.svg';
    }

    return $memo[$memoKey] = $fallbackImage;
}
