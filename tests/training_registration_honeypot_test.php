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

    if (!str_contains($view, 'type="checkbox"')
        || !str_contains($view, 'name="registration_check"')) {
        throw new RuntimeException($viewPath . ' enthält nicht den erwarteten Honeypot.');
    }

    if (str_contains($view, 'name="website"')) {
        throw new RuntimeException($viewPath . ' enthält weiterhin den autofill-anfälligen Honeypot.');
    }

    if (preg_match('/name="callsign"\s+required/', $view) === 1) {
        throw new RuntimeException($viewPath . ' verlangt weiterhin für alle Teilnehmer ein Kennzeichen.');
    }

    foreach (['garmin_training_flight', 'grefrath_open_air_museum'] as $element) {
        if (!str_contains($view, 'value="' . $element . '"')) {
            throw new RuntimeException($viewPath . ' enthält die neue Programmauswahl nicht: ' . $element);
        }
    }
}

foreach (["['', '0', 'false', 'off', 'no']", '!$registrationCheckIsEmpty'] as $fragment) {
    if (!str_contains($controller, $fragment)) {
        throw new RuntimeException('Die tolerante Honeypot-Prüfung fehlt: ' . $fragment);
    }
}

if (str_contains($controller, "isset(\$_POST['registration_check'])")) {
    throw new RuntimeException('Die autofill-anfällige Anwesenheitsprüfung ist weiterhin vorhanden.');
}

if (str_contains($controller, "|| \$callsign === ''")) {
    throw new RuntimeException('Das Kennzeichen wird serverseitig weiterhin pauschal verlangt.');
}

foreach (['garmin_training_flight', 'grefrath_open_air_museum'] as $element) {
    if (!str_contains($controller, "'" . $element . "'")) {
        throw new RuntimeException('Der Controller akzeptiert die neue Programmauswahl nicht: ' . $element);
    }
}

echo "Training registration honeypot test: OK\n";
