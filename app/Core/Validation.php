<?php
declare(strict_types=1);
namespace App\Core;
final class Validation {
    public static function field(mixed $value, int $max = 200): string {
        if (!is_string($value)) { return ''; }
        $value = trim($value);
        return strlen($value) <= $max ? $value : '';
    }
    public static function email(mixed $value): string {
        $email = strtolower(self::field($value, 190));
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '';
    }
    public static function positiveInt(mixed $value): ?int {
        $number = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        return $number === false ? null : $number;
    }
    public static function price(mixed $value): ?string {
        if (!is_string($value) || !preg_match('/^(?:[1-9]\d{0,6})(?:\.\d{1,2})?$/', trim($value))) { return null; }
        return number_format((float) $value, 2, '.', '');
    }
}
