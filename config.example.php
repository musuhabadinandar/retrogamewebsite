<?php
// Main database connection
$host = getenv('NANDAR_DB_HOST') ?: 'localhost';
$dbname = getenv('NANDAR_DB_NAME') ?: 'gba';
$username = getenv('NANDAR_DB_USER') ?: 'root';
$password = getenv('NANDAR_DB_PASS') ?: '';

// Admin login
$admin_user = getenv('NANDAR_ADMIN_USER') ?: 'admin';

// Default password hash is for the password: change-me-now
// Replace this with your own password hash in config.local.php or NANDAR_ADMIN_PASS_HASH.
$admin_pass = getenv('NANDAR_ADMIN_PASS_HASH') ?: '$2y$10$sQ9XeLg.7n1Iisa9A9cju.GR557g2PqdvrbgI1VUw/9vWX3EAd7hG';

$localConfig = __DIR__ . DIRECTORY_SEPARATOR . 'config.local.php';
if (is_file($localConfig)) {
    require $localConfig;
}
?>