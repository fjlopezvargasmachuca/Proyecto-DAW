<?php
declare(strict_types=1);
spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) { return; }
    $file = dirname(__DIR__) . '/app/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($file)) { require $file; }
});
$envFile = dirname(__DIR__) . '/.env';
if (is_file($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) { continue; }
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        if (getenv($key) === false) { putenv($key . '=' . trim(trim($value), "\"'")); }
    }
}
require dirname(__DIR__) . '/app/Core/helpers.php';
if (PHP_SAPI !== 'cli' && session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', '1');
    session_name('eligecoche_session');
    session_set_cookie_params([
        'httponly' => true,
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'samesite' => 'Lax',
        'path' => '/',
    ]);
    session_start();
}
