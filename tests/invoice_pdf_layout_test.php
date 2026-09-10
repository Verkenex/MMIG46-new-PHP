<?php
declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use MMIG46\Services\InvoicePdf;

$items = [];
for ($position = 1; $position <= 75; $position++) {
    $items[] = [
        'position_no' => $position,
        'description' => 'Mehrseitige Testposition ' . $position,
        'quantity_millis' => 1000,
        'unit' => 'Stück',
        'unit_net_cents' => 1000,
        'tax_rate_basis_points' => 1900,
        'line_net_cents' => 1000,
        'line_tax_cents' => 190,
        'line_gross_cents' => 1190,
    ];
}

$invoice = [
    'language' => 'de',
    'status' => 'draft',
    'recipient_name' => 'Testempfänger',
    'recipient_street' => 'Testweg 1',
    'recipient_postal_code' => '12345',
    'recipient_city' => 'Testort',
    'recipient_country' => 'Deutschland',
    'invoice_date' => '2026-09-10',
    'service_start' => '2026-09-01',
    'service_end' => '2026-09-10',
    'due_date' => '2026-09-24',
    'occasion' => 'Layouttest',
    'net_cents' => 75000,
    'tax_cents' => 14250,
    'gross_cents' => 89250,
];

$issuer = [
    'invoice_issuer_name' => 'MMIG46 e.V.',
    'invoice_issuer_street' => 'Testweg 2',
    'invoice_issuer_postal_code' => '54321',
    'invoice_issuer_city' => 'Teststadt',
    'invoice_issuer_country' => 'Deutschland',
    'invoice_iban' => 'DE00000000000000000000',
    'invoice_bic' => 'TESTDE00',
    'invoice_tax_number_or_vat_id' => 'TEST',
    'invoice_footer_note_de' => 'Automatischer Layouttest',
];

$pdf = InvoicePdf::render($invoice, $items, $issuer, true);
if (!str_starts_with($pdf, '%PDF')) {
    throw new RuntimeException('PDF-Signatur fehlt.');
}

$target = sys_get_temp_dir() . '/mmig46-invoice-layout.pdf';
if (file_put_contents($target, $pdf) !== strlen($pdf)) {
    throw new RuntimeException('Test-PDF konnte nicht geschrieben werden.');
}

echo $target . PHP_EOL;
