<?php

declare(strict_types=1);

$root = dirname(__DIR__);

$read = static function (string $relativePath) use ($root): string {
    $contents = file_get_contents($root . '/' . ltrim($relativePath, '/'));
    if ($contents === false) {
        throw new RuntimeException($relativePath . ' konnte nicht gelesen werden.');
    }
    return $contents;
};

$rootHtaccess = $read('.htaccess');
foreach (['app|config|database|docs|storage|tests|tools|vendor', 'composer\\.(?:json|lock)', 'write_repo\\.py'] as $pattern) {
    if (!str_contains($rootHtaccess, $pattern)) {
        throw new RuntimeException('Root-Webschutz fehlt für Muster: ' . $pattern);
    }
}
if (str_contains($rootHtaccess, 'RedirectMatch 301 ^/forum/?$ /forum')) {
    throw new RuntimeException('Die selbstreferenzielle Forum-Weiterleitung ist noch vorhanden.');
}

$pageController = $read('app/Controllers/PageController.php');
if (!str_contains($pageController, "array_key_exists('captcha_answer', \$_SESSION)")) {
    throw new RuntimeException('Kontakt-Captcha akzeptiert weiterhin eine fehlende Session-Antwort.');
}
$captchaRead = strpos($pageController, '$expected = (int) $_SESSION[\'captcha_answer\'];');
$captchaUnset = strpos($pageController, "unset(\$_SESSION['captcha_answer']);");
if ($captchaRead === false || $captchaUnset === false || $captchaUnset < $captchaRead) {
    throw new RuntimeException('Kontakt-Captcha wird nicht nach dem Auslesen einmalig verbraucht.');
}

require_once $root . '/app/Services/Mailer.php';
$safeHtml = new ReflectionMethod(MMIG46\Services\Mailer::class, 'safeHtmlValue');
$rendered = $safeHtml->invoke(null, "Name<br><img src=x onerror=alert(1)>\nZeile 2");
if (str_contains($rendered, '<img') || !str_contains($rendered, '&lt;img')) {
    throw new RuntimeException('Formularwerte können weiterhin HTML in E-Mails einschleusen.');
}
if (!str_contains($rendered, '<br')) {
    throw new RuntimeException('Sichere Zeilenumbrüche in E-Mail-Werten fehlen.');
}
$htmlMail = new ReflectionMethod(MMIG46\Services\Mailer::class, 'htmlMail');
$mailBody = $htmlMail->invoke(null, 'Test', 'Test', [
    'Abschnitt' => [
        'Formularwert' => '<br><img src=x onerror=alert(1)>',
        'Interne Liste' => ['trusted_html' => '<ul><li>Sicher erzeugt</li></ul>'],
    ],
]);
if (str_contains($mailBody, '<img src=x')
    || !str_contains($mailBody, '&lt;img src=x')
    || !str_contains($mailBody, '<ul><li>Sicher erzeugt</li></ul>')) {
    throw new RuntimeException('Die Trennung von Formularwerten und internem Mail-HTML ist fehlerhaft.');
}

$security = $read('app/Core/Security.php');
foreach (['SELECT id, name, email, role, email_verified_at', "unset(\$_SESSION['user'])", "'auth_stamp' => \$authStamp"] as $fragment) {
    if (!str_contains($security, $fragment)) {
        throw new RuntimeException('Datenbankgestützte Sessionprüfung ist unvollständig: ' . $fragment);
    }
}

$adminController = $read('app/Controllers/AdminController.php');
$invoiceController = $read('app/Controllers/InvoiceController.php');
if (!str_contains($adminController, "Security::requireRole(['admin'])")
    || !str_contains($invoiceController, "Security::requireRole(['admin'])")) {
    throw new RuntimeException('Ein Admin-Guard vertraut weiterhin ausschließlich der Sessionrolle.');
}
if (!str_contains($adminController, 'SELECT COUNT(*) FROM invoices WHERE created_by=? OR updated_by=?')
    || !str_contains($adminController, 'Benutzer ist mit mindestens einer Rechnung verknüpft')) {
    throw new RuntimeException('Rechnungsverknüpfungen werden beim Löschen eines Benutzers nicht geprüft.');
}

$installation = $read('docs/INSTALLATION_ALL_INKL_KAS.md');
$schemaPosition = strpos($installation, 'database/schema.sql');
$membershipPosition = strpos($installation, 'database/patches/2026_membership_workflow_admin.sql');
$invoicePosition = strpos($installation, 'database/patches/2026_invoice_management.sql');
$followupPosition = strpos($installation, 'database/patches/2026_audit_followup.sql');
$seedPosition = strpos($installation, 'database/seed_live.sql');
if ($schemaPosition === false || $membershipPosition === false || $invoicePosition === false || $followupPosition === false || $seedPosition === false
    || !($schemaPosition < $membershipPosition && $membershipPosition < $invoicePosition && $invoicePosition < $followupPosition && $followupPosition < $seedPosition)) {
    throw new RuntimeException('Die dokumentierte Neuinstallationsreihenfolge ist unvollständig oder falsch.');
}

echo "Security audit regression tests: OK\n";
