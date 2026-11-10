<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\Auth;
use App\Core\Validation;
use App\Models\Catalog;
use App\Models\Order;
use App\Services\CarConfigurator;
use InvalidArgumentException;
final class CarController {
    public static function configure(): void {
        $user = Auth::user();
        if ($user && $user['role'] === 'staff') { Auth::requireCustomer(); }
        render('cars/configurator', ['title' => 'Configura tu coche', 'groups' => Catalog::grouped(), 'labels' => CarConfigurator::LABELS]);
    }
    public static function store(): void {
        $user = Auth::requireCustomer();
        $selection = [];
        foreach (CarConfigurator::REQUIRED as $category) { $selection[$category] = $_POST[$category] ?? null; }
        $selection['accessory'] = $_POST['accessory'] ?? [];
        try {
            $quote = CarConfigurator::quote($selection, Catalog::grouped());
            $orderId = Order::create((int) $user['id'], $quote);
            flash('success', '¡Tu configuración se ha guardado como pedido de demostración!');
            redirect('/pedidos/' . $orderId);
        } catch (InvalidArgumentException $e) {
            flash('error', $e->getMessage()); redirect('/configurador');
        }
    }
    public static function index(): void {
        $user = Auth::requireCustomer();
        render('cars/orders', ['title' => 'Mis pedidos', 'orders' => Order::forUser((int) $user['id'])]);
    }
    public static function show(int $id): void {
        $user = Auth::requireLogin();
        $order = Order::detail($id, $user);
        if (!$order) { render('pages/error', ['title' => 'Pedido no encontrado', 'message' => 'No existe este pedido o no tienes acceso a él.'], 404); return; }
        render('cars/order-detail', ['title' => 'Pedido #' . $id, 'order' => $order]);
    }
}
