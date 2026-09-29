<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$controller = file_get_contents($root . '/app/Controllers/PageController.php');

if ($controller === false) {
    throw new RuntimeException('PageController konnte nicht gelesen werden.');
}

foreach ([
    '/app/Views/pages/training-weekend.php',
    '/app/Views/pages/en/training-weekend.php',
] as $viewPath) {
    $view = file_get_contents($root . $viewPath);
    if ($view === false) {
        throw new RuntimeException($viewPath . ' konnte nicht gelesen werden.');
    }

    if (str_contains($view, '<form') || !str_contains($view, 'ARCHIV')) {
        throw new RuntimeException($viewPath . ' muss das Programm archivieren und ohne Anmeldeformular anzeigen.');
    }
}

$registrationHandler = substr(
    $controller,
    strpos($controller, 'public function sendTrainingWeekendRegistration(): string'),
    strpos($controller, 'private function sendMailSafely(')
        - strpos($controller, 'public function sendTrainingWeekendRegistration(): string')
);

if (!str_contains($registrationHandler, 'http_response_code(410)')
    || str_contains($registrationHandler, 'TrainingRegistration::create')
    || str_contains($registrationHandler, 'Mailer::trainingWeekendRegistration')) {
    throw new RuntimeException('Der alte Anmelde-Endpunkt muss ohne Datenspeicherung und E-Mail antworten.');
}

echo "Training registration closed test: OK\n";
