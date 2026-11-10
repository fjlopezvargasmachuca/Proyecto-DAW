<?php
declare(strict_types=1);
namespace App\Models;
use App\Core\Database;
use InvalidArgumentException;
final class Repair {
    public const STATES = [
        'received' => 'Solicitud recibida', 'in_transit' => 'En traslado',
        'in_workshop' => 'En taller', 'ready' => 'Listo para entregar', 'delivered' => 'Entregado',
    ];
    public static function forUser(int $userId): array {
        $s = Database::connection()->prepare('SELECT * FROM repair_requests WHERE user_id=? ORDER BY created_at DESC, id DESC');
        $s->execute([$userId]); return $s->fetchAll();
    }
    public static function forStaff(): array {
        return Database::connection()->query('SELECT r.*, u.full_name AS customer_name FROM repair_requests r
            JOIN users u ON u.id = r.user_id ORDER BY (r.status="delivered"), r.created_at DESC LIMIT 100')->fetchAll();
    }
    public static function create(int $userId, array $values): void {
        $s = Database::connection()->prepare('INSERT INTO repair_requests
            (user_id,make,model,license_plate,pickup_address,description) VALUES (?,?,?,?,?,?)');
        $s->execute([$userId, $values['make'], $values['model'], $values['license_plate'], $values['pickup_address'], $values['description']]);
    }
    public static function next(int $id): void {
        $db = Database::connection();
        $db->beginTransaction();
        try {
            $s = $db->prepare('SELECT status FROM repair_requests WHERE id=? FOR UPDATE');
            $s->execute([$id]);
            $status = $s->fetchColumn();
            if ($status === false) { throw new InvalidArgumentException('Solicitud de taller no encontrada.'); }
            $keys = array_keys(self::STATES);
            $index = array_search($status, $keys, true);
            if ($index === false || $index === count($keys) - 1) {
                throw new InvalidArgumentException('No quedan etapas por avanzar.');
            }
            $s = $db->prepare('UPDATE repair_requests SET status=? WHERE id=?');
            $s->execute([$keys[$index + 1], $id]);
            $db->commit();
        } catch (\Throwable $e) {
            if ($db->inTransaction()) { $db->rollBack(); }
            throw $e;
        }
    }
}
