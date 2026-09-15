<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$read = static function (string $path) use ($root): string {
    $value = file_get_contents($root . '/' . $path);
    if ($value === false) {
        throw new RuntimeException($path . ' konnte nicht gelesen werden.');
    }
    return $value;
};

$routes = $read('config/routes.php');
if (!str_contains($routes, "\$router->get('/{slug}', [PageController::class, 'contentPage'])")) {
    throw new RuntimeException('Fallback-Route für veröffentlichte Inhaltsseiten fehlt.');
}

$router = $read('app/Core/Router.php');
if (!str_contains($router, "strtoupper(\$method) === 'HEAD'") || !str_contains($router, "\$method = 'GET'")) {
    throw new RuntimeException('HEAD-Anfragen werden nicht über GET-Routen aufgelöst.');
}

$rootHtaccess = $read('.htaccess');
if (str_contains($rootHtaccess, 'RewriteCond %{HTTPS} !=on')) {
    throw new RuntimeException('Proxy-anfällige HTTPS-Weiterleitung ist in der Root-.htaccess aktiv.');
}

$publicHtaccess = $read('public/.htaccess');
foreach (['X-Content-Type-Options', 'Referrer-Policy', 'X-Frame-Options', 'Permissions-Policy'] as $header) {
    if (!str_contains($publicHtaccess, $header)) {
        throw new RuntimeException('Security-Header fehlt: ' . $header);
    }
}

$outbox = $read('app/Models/MailOutbox.php');
if (!str_contains($outbox, "DATE_ADD(NOW(), INTERVAL 10 MINUTE)") || !str_contains($outbox, "\$row['status'] === 'sending'")) {
    throw new RuntimeException('Outbox-Lease gegen parallelen Doppelversand fehlt.');
}

$migration = $read('database/patches/2026_audit_followup.sql');
foreach (['DROP INDEX uq_membership_applications_duplicate', 'CREATE TABLE IF NOT EXISTS training_registrations', 'uq_training_registration_idempotency'] as $fragment) {
    if (!str_contains($migration, $fragment)) {
        throw new RuntimeException('Folgemigration ist unvollständig: ' . $fragment);
    }
}

$pageController = $read('app/Controllers/PageController.php');
foreach (['membership_idempotency_tokens', 'training_idempotency_tokens', 'TrainingRegistration::create'] as $fragment) {
    if (!str_contains($pageController, $fragment)) {
        throw new RuntimeException('Mehrfachformular-/Event-Schutz fehlt: ' . $fragment);
    }
}

$news = $read('app/Models/NewsItem.php');
$travel = $read('app/Models/Travelitem.php');
if (str_contains(substr($news, (int) strpos($news, 'public static function all')), 'WHERE lang = ?')
    || !str_contains($travel, 'SELECT id, lang, title')) {
    throw new RuntimeException('Adminübersicht enthält nicht alle Sprach-/Veröffentlichungsstände.');
}

echo "Audit follow-up regression tests: OK\n";
