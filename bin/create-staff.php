<?php
declare(strict_types=1);
/** Crea una cuenta de operario por CLI. Ejecutar después de inicializar la base de datos. */
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Solo disponible en la consola.');
}
require dirname(__DIR__) . '/config/bootstrap.php';
use App\Core\Database;
use App\Core\Validation;

function ask(string $prompt): string {
    fwrite(STDOUT, $prompt);
    return trim((string) fgets(STDIN));
}
$name = Validation::field(ask('Nombre del operario: '), 120);
$email = Validation::email(ask('Email: '));
if (function_exists('shell_exec') && DIRECTORY_SEPARATOR === '/' && is_string(shell_exec('command -v stty 2>/dev/null'))) {
    fwrite(STDOUT, 'Contraseña (mínimo 10 caracteres): ');
    system('stty -echo');
    try { $password = trim((string) fgets(STDIN)); }
    finally { system('stty echo'); fwrite(STDOUT, "\n"); }
} else {
    $password = ask('Contraseña (mínimo 10 caracteres, entrada visible): ');
}
if (strlen($name) < 3 || !$email || strlen($password) < 10 || strlen($password) > 72) {
    fwrite(STDERR, "Datos no válidos. Verifica nombre, email y contraseña.\n");
    exit(1);
}
try {
    $statement = Database::connection()->prepare('INSERT INTO users (full_name,email,password_hash,role) VALUES (?,?,?,?)');
    $statement->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), 'staff']);
    fwrite(STDOUT, "Cuenta de operario creada.\n");
} catch (PDOException $e) {
    if ($e->getCode() === '23000') {
        fwrite(STDERR, "Ya existe una cuenta con este email.\n");
    } else {
        fwrite(STDERR, "Error de conexión o base de datos.\n");
    }
    exit(1);
}
