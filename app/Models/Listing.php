<?php
declare(strict_types=1);
namespace App\Models;
use App\Core\Database;
final class Listing {
    public static function active(): array {
        return Database::connection()->query('SELECT id, make, model, mileage, price, description, created_at FROM listings
            WHERE is_active=1 ORDER BY created_at DESC, id DESC LIMIT 60')->fetchAll();
    }
    public static function forUser(int $id): array {
        $s = Database::connection()->prepare('SELECT * FROM listings WHERE user_id=? ORDER BY id DESC');
        $s->execute([$id]); return $s->fetchAll();
    }
    public static function create(int $userId, array $values): void {
        $s = Database::connection()->prepare('INSERT INTO listings (user_id,make,model,mileage,price,description) VALUES (?,?,?,?,?,?)');
        $s->execute([$userId, $values['make'], $values['model'], $values['mileage'], $values['price'], $values['description']]);
    }
    public static function deactivate(int $id, int $ownerId): bool {
        $s = Database::connection()->prepare('UPDATE listings SET is_active=0 WHERE id=? AND user_id=? AND is_active=1');
        $s->execute([$id, $ownerId]); return $s->rowCount() > 0;
    }
}
