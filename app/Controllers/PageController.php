<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\Database;
use App\Core\Validation;
use App\Models\Catalog;
use App\Services\CarConfigurator;
final class PageController {
    public static function home(): void { render('pages/home', ['title' => 'Crea un coche a tu medida']); }
    public static function about(): void { render('pages/about', ['title' => 'El proyecto']); }
    public static function catalog(): void {
        render('pages/catalog', ['title' => 'Catálogo de piezas', 'groups' => Catalog::grouped(), 'labels' => CarConfigurator::LABELS]);
    }
    public static function ranking(): void { render('pages/ranking', ['title' => 'Piezas más elegidas', 'ranking' => Catalog::popular()]); }
    public static function contact(): void { render('pages/contact', ['title' => 'Contacto']); }
    public static function sendContact(): void {
        if (($_POST['website'] ?? '') !== '') { redirect('/contacto'); }
        $name = Validation::field($_POST['name'] ?? null, 120);
        $email = Validation::email($_POST['email'] ?? null);
        $message = Validation::field($_POST['message'] ?? null, 4000);
        if (strlen($name) < 2 || !$email || strlen($message) < 12) {
            flash('error', 'Completa los campos con un nombre, email y mensaje válidos.'); redirect('/contacto');
        }
        if (time() - (int) ($_SESSION['last_contact'] ?? 0) < 60) {
            flash('error', 'Espera un minuto antes de enviar otro mensaje.'); redirect('/contacto');
        }
        $s = Database::connection()->prepare('INSERT INTO contact_messages (name,email,message) VALUES (?,?,?)');
        $s->execute([$name, $email, $message]);
        $_SESSION['last_contact'] = time();
        flash('success', 'Mensaje registrado. Puedes consultarlo desde el panel de operarios de esta demo.');
        redirect('/contacto');
    }
}
