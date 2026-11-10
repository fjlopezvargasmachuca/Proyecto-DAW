<?php
declare(strict_types=1);
use App\Core\Auth;
use App\Core\Csrf;
function e(mixed $value): string { return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function money(int|float|string $value): string { return number_format((float) $value, 2, ',', '.') . ' €'; }
function redirect(string $path): never { header('Location: ' . $path, true, 303); exit; }
function flash(string $type, string $message): void { $_SESSION['flash'] = ['type' => $type, 'message' => $message]; }
function take_flash(): ?array { $flash = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); return $flash; }
function csrf_field(): string { return '<input type="hidden" name="_csrf" value="' . e(Csrf::token()) . '">'; }
function render(string $view, array $data = [], int $status = 200): void {
    http_response_code($status);
    $viewFile = dirname(__DIR__) . '/Views/' . $view . '.php';
    if (!is_file($viewFile)) { throw new RuntimeException('Vista no encontrada'); }
    extract($data, EXTR_SKIP);
    require dirname(__DIR__) . '/Views/layouts/header.php';
    require $viewFile;
    require dirname(__DIR__) . '/Views/layouts/footer.php';
}
function current_user(): ?array { return Auth::user(); }
function date_es(?string $date): string { return $date ? date('d/m/Y', strtotime($date)) : '—'; }
