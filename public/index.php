<?php
declare(strict_types=1);
require dirname(__DIR__) . '/config/bootstrap.php';
use App\Core\Csrf;
use App\Controllers\AuthController;
use App\Controllers\PageController;
use App\Controllers\CarController;
use App\Controllers\RepairController;
use App\Controllers\SaleController;
use App\Controllers\StaffController;

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: strict-origin-when-cross-origin');
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
$path = rtrim($path, '/') ?: '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($method === 'POST' && !Csrf::verify(is_string($_POST['_csrf'] ?? null) ? $_POST['_csrf'] : '')) {
    render('pages/error', ['title' => 'Solicitud no válida', 'message' => 'El formulario ha caducado. Recarga la página e inténtalo de nuevo.'], 419);
    exit;
}
try {
    $routes = [
        'GET' => [
            '/' => [PageController::class, 'home'],
            '/proyecto' => [PageController::class, 'about'],
            '/catalogo' => [PageController::class, 'catalog'],
            '/ranking' => [PageController::class, 'ranking'],
            '/contacto' => [PageController::class, 'contact'],
            '/acceder' => [AuthController::class, 'loginForm'],
            '/registro' => [AuthController::class, 'registerForm'],
            '/configurador' => [CarController::class, 'configure'],
            '/pedidos' => [CarController::class, 'index'],
            '/taller' => [RepairController::class, 'index'],
            '/mercado' => [SaleController::class, 'index'],
            '/operarios' => [StaffController::class, 'dashboard'],
        ],
        'POST' => [
            '/acceder' => [AuthController::class, 'login'],
            '/registro' => [AuthController::class, 'register'],
            '/salir' => [AuthController::class, 'logout'],
            '/configurador' => [CarController::class, 'store'],
            '/taller' => [RepairController::class, 'store'],
            '/mercado' => [SaleController::class, 'store'],
            '/contacto' => [PageController::class, 'sendContact'],
        ],
    ];
    if (isset($routes[$method][$path])) {
        call_user_func($routes[$method][$path]);
    } elseif ($method === 'GET' && preg_match('~^/pedidos/([1-9]\d*)$~', $path, $match)) {
        CarController::show((int) $match[1]);
    } elseif ($method === 'POST' && preg_match('~^/operarios/pedidos/([1-9]\d*)$~', $path, $match)) {
        StaffController::updateOrder((int) $match[1]);
    } elseif ($method === 'POST' && preg_match('~^/operarios/taller/([1-9]\d*)$~', $path, $match)) {
        StaffController::nextRepair((int) $match[1]);
    } elseif ($method === 'POST' && preg_match('~^/mercado/([1-9]\d*)/retirar$~', $path, $match)) {
        SaleController::deactivate((int) $match[1]);
    } else {
        render('pages/error', ['title' => 'Página no encontrada', 'message' => 'La dirección que buscas no existe.'], 404);
    }
} catch (\Throwable $error) {
    error_log((string) $error);
    $debug = (getenv('APP_DEBUG') ?: '') === '1';
    render('pages/error', [
        'title' => 'No se pudo completar la solicitud',
        'message' => $debug ? 'Error local: ' . $error->getMessage() : 'Ha ocurrido un error. Comprueba la configuración del servidor o inténtalo más tarde.',
    ], 500);
}
