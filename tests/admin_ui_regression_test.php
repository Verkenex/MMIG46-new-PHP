<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$view = file_get_contents($root . '/app/Views/admin/dashboard.php');
$css = file_get_contents($root . '/public/assets/css/app.css');
$js = file_get_contents($root . '/public/assets/js/app.js');

if ($view === false || $css === false || $js === false) {
    throw new RuntimeException('UI-Dateien konnten nicht gelesen werden.');
}

foreach (['admin-edit-dialog', 'data-admin-dialog-open', 'data-admin-dialog-close', 'admin-button--danger', 'admin-decision-grid'] as $fragment) {
    if (!str_contains($view, $fragment)) {
        throw new RuntimeException('Admin-Markup fehlt: ' . $fragment);
    }
}

if (str_contains($view, '<td><details><summary>Bearbeiten</summary>')) {
    throw new RuntimeException('Bearbeitungsformulare öffnen weiterhin innerhalb der Tabellenzeile.');
}

foreach (['cursor: pointer', '.admin-edit-dialog::backdrop', '@media (max-width: 1720px)', '.admin-button--danger'] as $fragment) {
    if (!str_contains($css, $fragment)) {
        throw new RuntimeException('Admin-CSS fehlt: ' . $fragment);
    }
}

foreach (['showModal()', 'dialog.close()', 'getBoundingClientRect()'] as $fragment) {
    if (!str_contains($js, $fragment)) {
        throw new RuntimeException('Dialogsteuerung fehlt: ' . $fragment);
    }
}

echo "Admin UI regression tests: OK\n";
