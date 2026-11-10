<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\Auth;
use App\Core\Database;
use App\Models\Order;
use App\Models\Repair;
use App\Services\CarConfigurator;
use InvalidArgumentException;
final class StaffController {
    public static function dashboard(): void {
        Auth::requireStaff();
        $messages = Database::connection()->query('SELECT id, name, email, message, created_at FROM contact_messages ORDER BY id DESC LIMIT 20')->fetchAll();
        render('staff/dashboard', [
            'title' => 'Panel de operarios', 'orders' => Order::forStaff(),
            'repairs' => Repair::forStaff(), 'messages' => $messages,
        ]);
    }
    public static function updateOrder(int $id): void {
        Auth::requireStaff();
        $done = $_POST['done'] ?? [];
        if (!is_array($done) || count($done) > 7 || !array_is_list($done)) {
            flash('error', 'Las etapas seleccionadas no son válidas.'); redirect('/pedidos/' . $id);
        }
        try {
            Order::updateSteps($id, $done);
            flash('success', 'Progreso de fabricación actualizado.');
        } catch (InvalidArgumentException $e) { flash('error', $e->getMessage()); }
        redirect('/pedidos/' . $id);
    }
    public static function nextRepair(int $id): void {
        Auth::requireStaff();
        try { Repair::next($id); flash('success', 'Etapa del taller actualizada.'); }
        catch (InvalidArgumentException $e) { flash('error', $e->getMessage()); }
        redirect('/operarios#taller');
    }
}
