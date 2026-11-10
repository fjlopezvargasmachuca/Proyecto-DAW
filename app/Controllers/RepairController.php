<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\Auth;
use App\Core\Validation;
use App\Models\Repair;
final class RepairController {
    public static function index(): void {
        $user = Auth::user();
        $repairs = $user && $user['role'] === 'customer' ? Repair::forUser((int) $user['id']) : [];
        render('repairs/index', ['title' => 'Mantenimiento y reparaciones', 'repairs' => $repairs]);
    }
    public static function store(): void {
        $user = Auth::requireCustomer();
        $values = [
            'make' => Validation::field($_POST['make'] ?? null, 80),
            'model' => Validation::field($_POST['model'] ?? null, 80),
            'license_plate' => strtoupper(Validation::field($_POST['plate'] ?? null, 20)),
            'pickup_address' => Validation::field($_POST['address'] ?? null, 255),
            'description' => Validation::field($_POST['description'] ?? null, 3000),
        ];
        if (strlen($values['make']) < 2 || strlen($values['model']) < 1 || strlen($values['license_plate']) < 4 ||
            strlen($values['pickup_address']) < 8 || strlen($values['description']) < 10) {
            flash('error', 'Completa todos los datos del vehículo y describe la incidencia.'); redirect('/taller');
        }
        Repair::create((int) $user['id'], $values);
        flash('success', 'Tu solicitud de taller se ha registrado.'); redirect('/taller');
    }
}
