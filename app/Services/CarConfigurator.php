<?php
declare(strict_types=1);
namespace App\Services;
use InvalidArgumentException;
/** La cotización se calcula en el servidor, nunca con precios del formulario. */
final class CarConfigurator {
    public const REQUIRED = ['body', 'engine', 'paint', 'doors', 'wheels', 'drive'];
    public const LABELS = [
        'body' => 'Carrocería', 'engine' => 'Motor', 'paint' => 'Pintura',
        'doors' => 'Puertas', 'wheels' => 'Ruedas', 'drive' => 'Tracción', 'accessory' => 'Accesorios',
    ];
    /** @param array<string, list<array<string,mixed>>> $catalog */
    public static function quote(array $selection, array $catalog): array {
        $items = [];
        foreach (self::REQUIRED as $category) {
            $id = filter_var($selection[$category] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
            if ($id === false || $id === null) { throw new InvalidArgumentException('Selecciona una opción válida de ' . self::LABELS[$category] . '.'); }
            $items[] = self::findPart((int) $id, $category, $catalog);
        }
        $accessories = $selection['accessory'] ?? [];
        if (!is_array($accessories) || count($accessories) > 20) { throw new InvalidArgumentException('Selección de accesorios no válida.'); }
        $unique = [];
        foreach ($accessories as $id) {
            $number = filter_var($id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
            if ($number === false || $number === null || in_array((int) $number, $unique, true)) {
                throw new InvalidArgumentException('Los accesorios deben ser válidos y no estar duplicados.');
            }
            $unique[] = (int) $number;
            $items[] = self::findPart((int) $number, 'accessory', $catalog);
        }
        $totalCents = array_sum(array_map(static fn(array $item): int => self::toCents((string) $item['price']), $items));
        return ['items' => $items, 'total' => number_format($totalCents / 100, 2, '.', '')];
    }
    public static function toCents(string $price): int {
        if (!preg_match('/^\d{1,8}(?:\.\d{1,2})?$/', $price)) { throw new InvalidArgumentException('Precio de catálogo no válido.'); }
        [$units, $cents] = array_pad(explode('.', $price, 2), 2, '0');
        return (int) $units * 100 + (int) str_pad($cents, 2, '0');
    }
    private static function findPart(int $id, string $category, array $catalog): array {
        foreach ($catalog[$category] ?? [] as $part) { if ((int) $part['id'] === $id) { return $part; } }
        throw new InvalidArgumentException('Una pieza seleccionada ya no está disponible.');
    }
}
