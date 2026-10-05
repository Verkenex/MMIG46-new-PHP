<?php

declare(strict_types=1);

require dirname(__DIR__) . '/app/bootstrap.php';

$lang = ($argv[1] ?? 'de') === 'en' ? 'en' : 'de';
$_GET['lang'] = $lang;
$_SERVER['REQUEST_URI'] = '/trainingswochenende-2026/anmeldung?lang=' . $lang;
$_SERVER['REQUEST_METHOD'] = 'POST';
// A stale or direct submission must be closed before CSRF, database or mail processing.
$_POST = ['name' => 'Old registration', 'email' => 'test@example.invalid'];

$html = (new \MMIG46\Controllers\PageController())->sendTrainingWeekendRegistration();
if (http_response_code() !== 410) {
    throw new RuntimeException('The closed registration endpoint must return HTTP 410.');
}
if (!str_contains($html, 'Klaus Gerecht') || !str_contains($html, 'class="recap-photo"')) {
    throw new RuntimeException('The closed endpoint must display the final report.');
}
if (str_contains($html, 'action="/trainingswochenende-2026/anmeldung"')
    || isset($_SESSION['training_idempotency_tokens'])) {
    throw new RuntimeException('The final report must not offer or initialise registration.');
}
echo "Training registration closed ($lang): OK\n";
