<?php
declare(strict_types=1);
namespace App\Core;
final class Auth {
    public static function user(): ?array { return $_SESSION['user'] ?? null; }
    public static function login(array $user): void {
        session_regenerate_id(true);
        $_SESSION['user'] = ['id' => (int) $user['id'], 'name' => (string) $user['full_name'], 'role' => (string) $user['role']];
    }
    public static function logout(): void {
        unset($_SESSION['user']);
        session_regenerate_id(true);
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    public static function requireLogin(): array {
        if (!self::user()) { flash('error', 'Inicia sesión para continuar.'); redirect('/acceder'); }
        return self::user();
    }
    public static function requireStaff(): array {
        $user = self::requireLogin();
        if ($user['role'] !== 'staff') {
            render('pages/error', ['title' => 'Acceso restringido', 'message' => 'Solo el personal puede acceder a esta página.'], 403);
            exit;
        }
        return $user;
    }
    public static function requireCustomer(): array {
        $user = self::requireLogin();
        if ($user['role'] !== 'customer') {
            render('pages/error', ['title' => 'Cuenta de cliente necesaria', 'message' => 'Accede con una cuenta de cliente para realizar esta operación.'], 403);
            exit;
        }
        return $user;
    }
}
