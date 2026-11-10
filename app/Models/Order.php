<?php
declare(strict_types=1);
namespace App\Models;
use App\Core\Database;
use App\Services\CarConfigurator;
use PDO;
use InvalidArgumentException;
final class Order {
    public const STATUS = ['pending' => 'Pendiente', 'in_progress' => 'En fabricación', 'completed' => 'Finalizado'];
    public static function create(int $userId, array $quote): int {
        $db = Database::connection();
        $db->beginTransaction();
        try {
            $staffId = $db->query("SELECT u.id FROM users u LEFT JOIN orders o
                ON o.assigned_staff_id = u.id AND o.status <> 'completed'
                WHERE u.role = 'staff' GROUP BY u.id ORDER BY COUNT(o.id), u.id LIMIT 1")->fetchColumn();
            $statement = $db->prepare('INSERT INTO orders (user_id, assigned_staff_id, total) VALUES (?, ?, ?)');
            $statement->execute([$userId, $staffId === false ? null : $staffId, $quote['total']]);
            $orderId = (int) $db->lastInsertId();
            $itemInsert = $db->prepare('INSERT INTO order_items (order_id, part_id, category, part_name, unit_price) VALUES (?, ?, ?, ?, ?)');
            foreach ($quote['items'] as $part) {
                $itemInsert->execute([$orderId, $part['id'], $part['category'], $part['name'], $part['price']]);
            }
            $stepInsert = $db->prepare('INSERT INTO order_steps (order_id,category) VALUES (?,?)');
            foreach (array_keys(CarConfigurator::LABELS) as $category) {
                $stepInsert->execute([$orderId, $category]);
            }
            $db->commit();
            return $orderId;
        } catch (\Throwable $error) {
            if ($db->inTransaction()) { $db->rollBack(); }
            throw $error;
        }
    }
    public static function forUser(int $userId): array {
        $s = Database::connection()->prepare('SELECT o.*, (SELECT COUNT(*) FROM order_steps s WHERE s.order_id=o.id AND s.completed_at IS NOT NULL) AS done_steps
            FROM orders o WHERE o.user_id=? ORDER BY o.created_at DESC, o.id DESC');
        $s->execute([$userId]);
        return $s->fetchAll();
    }
    public static function forStaff(): array {
        return Database::connection()->query('SELECT o.*, u.full_name AS customer_name, staff.full_name AS staff_name,
            (SELECT COUNT(*) FROM order_steps s WHERE s.order_id=o.id AND s.completed_at IS NOT NULL) AS done_steps
            FROM orders o JOIN users u ON o.user_id=u.id LEFT JOIN users staff ON o.assigned_staff_id=staff.id
            ORDER BY (o.status="completed"), o.created_at DESC LIMIT 100')->fetchAll();
    }
    public static function detail(int $id, array $viewer): ?array {
        $db = Database::connection();
        $s = $db->prepare('SELECT o.*, u.full_name AS customer_name FROM orders o JOIN users u ON u.id=o.user_id WHERE o.id = ?');
        $s->execute([$id]);
        $order = $s->fetch();
        if (!$order || ($viewer['role'] !== 'staff' && (int) $order['user_id'] !== (int) $viewer['id'])) {
            return null;
        }
        $s = $db->prepare('SELECT category, part_name, unit_price FROM order_items WHERE order_id = ? ORDER BY id');
        $s->execute([$id]);
        $order['items'] = $s->fetchAll();
        $s = $db->prepare('SELECT category, completed_at FROM order_steps WHERE order_id = ?');
        $s->execute([$id]);
        $order['steps'] = array_column($s->fetchAll(), 'completed_at', 'category');
        return $order;
    }
    public static function updateSteps(int $id, array $done): void {
        $allowed = array_keys(CarConfigurator::LABELS);
        if (array_diff($done, $allowed) || count($done) !== count(array_unique($done))) {
            throw new InvalidArgumentException('Etapas de fabricación no válidas.');
        }
        $db = Database::connection();
        $db->beginTransaction();
        try {
            $stmt = $db->prepare('SELECT id FROM orders WHERE id = ? FOR UPDATE');
            $stmt->execute([$id]);
            if (!$stmt->fetch()) { throw new InvalidArgumentException('El encargo no existe.'); }
            $update = $db->prepare('UPDATE order_steps SET completed_at=IF(?, COALESCE(completed_at, CURRENT_TIMESTAMP), NULL) WHERE order_id=? AND category=?');
            foreach ($allowed as $category) {
                $update->execute([in_array($category, $done, true) ? 1 : 0, $id, $category]);
            }
            $status = count($done) === count($allowed) ? 'completed' : (count($done) > 0 ? 'in_progress' : 'pending');
            $updateOrder = $db->prepare('UPDATE orders SET status=?, completed_at=IF(?="completed",COALESCE(completed_at,CURRENT_TIMESTAMP),NULL) WHERE id=?');
            $updateOrder->execute([$status, $status, $id]);
            $db->commit();
        } catch (\Throwable $error) {
            if ($db->inTransaction()) { $db->rollBack(); }
            throw $error;
        }
    }
}
