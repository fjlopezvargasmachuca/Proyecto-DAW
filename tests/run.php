<?php
declare(strict_types=1);
require dirname(__DIR__) . '/config/bootstrap.php';
use App\Core\Validation;
use App\Services\CarConfigurator;

$passed = 0;
function expect(bool $condition, string $label): void {
    global $passed;
    if (!$condition) { fwrite(STDERR, "FALLO: {$label}\n"); exit(1); }
    $passed++;
    echo "OK: {$label}\n";
}
function throws(callable $run): bool {
    try { $run(); return false; } catch (InvalidArgumentException $e) { return true; }
}
$catalog = [];
$selection = [];
$id = 10;
foreach (CarConfigurator::LABELS as $category => $label) {
    $catalog[$category] = [
        ['id' => $id, 'category' => $category, 'name' => $label . ' estándar', 'price' => '100.25'],
        ['id' => $id+1, 'category' => $category, 'name' => $label . ' premium', 'price' => '201.10'],
    ];
    if ($category !== 'accessory') { $selection[$category] = (string) $id; }
    $id += 2;
}
$selection['accessory'] = ['22'];
$quote = CarConfigurator::quote($selection, $catalog);
expect(count($quote['items']) === 7, 'Guarda las seis piezas obligatorias y un extra');
expect($quote['total'] === '701.75', 'Calcula los importes en céntimos sin errores de flotantes');
expect(throws(fn() => CarConfigurator::quote(array_diff_key($selection, ['engine' => 1]), $catalog)), 'Rechaza configuraciones incompletas');
expect(throws(fn() => CarConfigurator::quote(array_replace($selection, ['engine' => '10']), $catalog)), 'Impide elegir una pieza de la categoría incorrecta');
expect(throws(fn() => CarConfigurator::quote(array_replace($selection, ['accessory' => ['22', '22']]), $catalog)), 'Rechaza accesorios repetidos');
expect(throws(fn() => CarConfigurator::quote(array_replace($selection, ['accessory' => ['999']]), $catalog)), 'Rechaza componentes inexistentes');
expect(throws(fn() => CarConfigurator::toCents('7.999')), 'Rechaza precios con más de dos decimales');
expect(CarConfigurator::toCents('1200.50') === 120050, 'Conversión exacta a céntimos');
expect(Validation::email('Persona@Ejemplo.es') === 'persona@ejemplo.es', 'Normaliza emails');
expect(Validation::email('invalido') === '', 'Rechaza emails incorrectos');
expect(Validation::price('25000.99') === '25000.99', 'Valida importes');
expect(Validation::price('-5') === null, 'Rechaza importes negativos');
expect(Validation::positiveInt('11') === 11, 'Valida enteros positivos');
expect(Validation::positiveInt('0') === null, 'Rechaza enteros no positivos');
expect(e('<script>') === '&lt;script&gt;', 'Escapa HTML al renderizar');
echo "\n{$passed} pruebas superadas.\n";
