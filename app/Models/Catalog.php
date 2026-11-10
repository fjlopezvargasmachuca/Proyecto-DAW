<?php
declare(strict_types=1);
namespace App\Models;
use App\Core\Database;
use App\Services\CarConfigurator;
final class Catalog {
    public static function grouped(): array {
        $rows = Database::connection()->query('SELECT id, category, name, description, price FROM parts WHERE active = 1 ORDER BY id')->fetchAll();
        $groups = array_fill_keys(array_keys(CarConfigurator::LABELS), []);
        foreach ($rows as $row) { $groups[$row['category']][] = $row; }
        return $groups;
    }
    public static function popular(): array {
        return Database::connection()->query('SELECT oi.part_name AS name, oi.category, COUNT(*) AS purchases
            FROM order_items oi JOIN orders o ON o.id = oi.order_id
            GROUP BY oi.part_name, oi.category ORDER BY purchases DESC, oi.part_name ASC LIMIT 12')->fetchAll();
    }
}
