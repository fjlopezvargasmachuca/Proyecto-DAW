<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\Auth;
use App\Core\Validation;
use App\Models\Listing;
final class SaleController {
    public static function index(): void {
        $user = Auth::user();
        $mine = $user && $user['role'] === 'customer' ? Listing::forUser((int) $user['id']) : [];
        render('sales/index', ['title' => 'Mercado de ocasión', 'listings' => Listing::active(), 'mine' => $mine]);
    }
    public static function store(): void {
        $user = Auth::requireCustomer();
        $values = [
            'make' => Validation::field($_POST['make'] ?? null, 80),
            'model' => Validation::field($_POST['model'] ?? null, 80),
            'mileage' => Validation::positiveInt($_POST['mileage'] ?? null),
            'price' => Validation::price($_POST['price'] ?? null),
            'description' => Validation::field($_POST['description'] ?? null, 3000),
        ];
        if (strlen($values['make']) < 2 || strlen($values['model']) < 1 || $values['mileage'] === null ||
            $values['mileage'] > 2000000 || $values['price'] === null || strlen($values['description']) < 10) {
            flash('error', 'Revisa marca, modelo, kilómetros, precio y descripción.'); redirect('/mercado');
        }
        Listing::create((int) $user['id'], $values);
        flash('success', 'Anuncio publicado en el mercado de demostración.'); redirect('/mercado');
    }
    public static function deactivate(int $id): void {
        $user = Auth::requireCustomer();
        $done = Listing::deactivate($id, (int) $user['id']);
        flash($done ? 'success' : 'error', $done ? 'Anuncio retirado.' : 'No puedes retirar este anuncio.');
        redirect('/mercado');
    }
}
