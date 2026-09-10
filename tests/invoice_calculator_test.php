<?php
declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use MMIG46\Services\InvoiceCalculator;

function assertSameValue(mixed $expected, mixed $actual, string $message): void
{
    if ($expected !== $actual) {
        throw new RuntimeException($message . ': expected ' . var_export($expected, true) . ', got ' . var_export($actual, true));
    }
}

$result = InvoiceCalculator::calculate([
    ['description' => 'Leistung A', 'quantity' => '1,500', 'unit' => 'Stück', 'unit_price' => '10,01', 'tax_rate' => '19,00'],
    ['description' => 'Leistung B', 'quantity' => '2', 'unit' => 'Stück', 'unit_price' => '5.00', 'tax_rate' => '7'],
    ['description' => 'Steuerfrei', 'quantity' => '1', 'unit' => 'Pauschale', 'unit_price' => '2,99', 'tax_rate' => '0'],
]);

assertSameValue(2801, $result['net_cents'], 'Nettosumme');
assertSameValue(355, $result['tax_cents'], 'Steuersumme');
assertSameValue(3156, $result['gross_cents'], 'Bruttosumme');
assertSameValue(1502, $result['items'][0]['line_net_cents'], 'Kaufmännische Rundung der ersten Position');

foreach ([
    [['description' => 'X', 'quantity' => '0', 'unit' => 'Stück', 'unit_price' => '1', 'tax_rate' => '19']],
    [['description' => 'X', 'quantity' => '1', 'unit' => 'Stück', 'unit_price' => '-1', 'tax_rate' => '19']],
    [['description' => 'X', 'quantity' => '1', 'unit' => 'Stück', 'unit_price' => '1', 'tax_rate' => '100,01']],
] as $invalid) {
    try {
        InvoiceCalculator::calculate($invalid);
        throw new RuntimeException('Ungültige Eingabe wurde akzeptiert.');
    } catch (InvalidArgumentException) {
    }
}

echo "Invoice calculator tests: OK\n";
