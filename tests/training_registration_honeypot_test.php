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
}

if (!str_contains($controller, "isset(\$_POST['registration_check'])")) {
    throw new RuntimeException('Der Controller prüft den neuen Honeypot nicht.');
}

echo "Training registration honeypot test: OK\n";
