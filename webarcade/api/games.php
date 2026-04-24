<?php
declare(strict_types=1);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

$catalogPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'games.json';

if (!is_file($catalogPath)) {
    webarcade_json_response([
        'ok' => false,
        'error' => 'Games catalog not found.',
    ], 404);
}

$rawCatalog = file_get_contents($catalogPath);
if ($rawCatalog === false) {
    webarcade_json_response([
        'ok' => false,
        'error' => 'Unable to read games catalog.',
    ], 500);
}

$catalog = json_decode($rawCatalog, true);
if (!is_array($catalog) || !isset($catalog['games']) || !is_array($catalog['games'])) {
    webarcade_json_response([
        'ok' => false,
        'error' => 'Invalid games catalog format.',
    ], 500);
}

// Keep backward compatibility with the removed endpoint by returning the same
// JSON shape that the frontend expects from catalog.json.
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
echo $rawCatalog;
exit;
?>
