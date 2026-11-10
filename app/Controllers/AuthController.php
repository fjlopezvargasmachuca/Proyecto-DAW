<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\Auth;
use App\Core\Database;
use App\Core\Validation;
use PDOException;
final class AuthController {
    public static function loginForm(): void {
        if (Auth::user()) { redirect(Auth::user()['role'] === 'staff' ? '/operarios' : '/pedidos'); }
        render('auth/login', ['title' => 'Acceder']);
    }
    public static function registerForm(): void {
        if (Auth::user()) { redirect('/'); }
        render('auth/register', ['title' => 'Crear cuenta']);
    }
    public static function register(): void {
        if (Auth::user()) { redirect('/'); }
        $name = Validation::field($_POST['name'] ?? null, 120);
        $email = Validation::email($_POST['email'] ?? null);
        $password = $_POST['password'] ?? null;
        $phone = Validation::field($_POST['phone'] ?? null, 25);
        $address = Validation::field($_POST['address'] ?? null, 255);
        if (strlen($name) < 3 || !$email || !is_string($password) || strlen($password) < 10 || strlen($password) > 72 ||
            ($phone !== '' && !preg_match('/^[+\d\s()-]{6,25}$/', $phone))) {
            flash('error', 'Revisa el nombre, correo, teléfono y contraseña (mínimo 10 caracteres).');
            redirect('/registro');
        }
        try {
            $db = Database::connection();
            $s = $db->prepare('INSERT INTO users (full_name,email,password_hash,phone,address,role) VALUES (?,?,?,?,?,"customer")');
            $s->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $phone ?: null, $address ?: null]);
            Auth::login(['id' => (int) $db->lastInsertId(), 'full_name' => $name, 'role' => 'customer']);
            flash('success', 'Tu cuenta se ha creado. Ya puedes configurar tu vehículo.');
            redirect('/configurador');
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                flash('error', 'Ya existe una cuenta con ese correo electrónico.');
                redirect('/registro');
            }
            throw $e;
        }
    }
    public static function login(): void {
        if (Auth::user()) { redirect('/'); }
        $now = time();
        $attempts = $_SESSION['login_attempts'] ?? ['count' => 0, 'until' => 0];
        if ((int) $attempts['until'] > $now) {
            flash('error', 'Demasiados intentos. Prueba de nuevo en unos minutos.');
            redirect('/acceder');
        }
        $email = Validation::email($_POST['email'] ?? null);
        $password = $_POST['password'] ?? null;
        $db = Database::connection();
        $s = $db->prepare('SELECT id, full_name, role, password_hash FROM users WHERE email = ?');
        $s->execute([$email]);
        $user = $s->fetch();
        if (!$user || !is_string($password) || !password_verify($password, $user['password_hash'])) {
            $count = (int) ($attempts['count'] ?? 0) + 1;
            $_SESSION['login_attempts'] = ['count' => $count >= 8 ? 0 : $count, 'until' => $count >= 8 ? $now + 600 : 0];
            flash('error', 'Credenciales incorrectas.');
            redirect('/acceder');
        }
        unset($_SESSION['login_attempts']);
        if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
            $s = $db->prepare('UPDATE users SET password_hash=? WHERE id=?');
            $s->execute([password_hash($password, PASSWORD_DEFAULT), $user['id']]);
        }
        Auth::login($user);
        flash('success', '¡Bienvenido de nuevo, ' . $user['full_name'] . '!');
        redirect($user['role'] === 'staff' ? '/operarios' : '/pedidos');
    }
    public static function logout(): void {
        Auth::logout(); flash('success', 'Sesión cerrada correctamente.'); redirect('/');
    }
}
