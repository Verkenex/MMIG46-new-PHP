<?php

use MMIG46\Controllers\AdminController;
use MMIG46\Controllers\AuthController;
use MMIG46\Controllers\ForumController;
use MMIG46\Controllers\MemberController;
use MMIG46\Controllers\PageController;
use MMIG46\Controllers\PasswordController;
use MMIG46\Controllers\InvoiceController;

/** @var MMIG46\Core\Router $router */

$router->get('/', [PageController::class, 'home']);

$router->get('/news', [PageController::class, 'news']);
$router->get('/news/{slug}', [PageController::class, 'newsDetail']);
$router->get('/aktuelles', [PageController::class, 'redirectNewsAlias']);

$router->get('/suche', [PageController::class, 'search']);
$router->get('/search', [PageController::class, 'redirectSearchAlias']);


$router->get('/reisen', [PageController::class, 'travels']);
$router->get('/reisen/fly-in-woerthersee-2026', [PageController::class, 'travelWoerthersee2026']);
$router->get('/reisen/{slug}', [PageController::class, 'travelDetail']);


$router->get('/malibu-mirage', [PageController::class, 'malibuMirage']);
$router->get('/malibu-mirage/{slug}', [PageController::class, 'malibuArchiveDetail']);

$router->get('/verein', [PageController::class, 'verein']);
$router->get('/satzung', [PageController::class, 'satzung']);
$router->get('/impressum', [PageController::class, 'impressum']);
$router->get('/datenschutz', [PageController::class, 'datenschutz']);
$router->get('/agb', [PageController::class, 'agb']);

$router->get('/kontakt', [PageController::class, 'contact']);
$router->post('/kontakt', [PageController::class, 'sendContact']);

$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'doLogin']);
$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/forum', [ForumController::class, 'index']);
$router->get('/forum/neu', [ForumController::class, 'create']);
$router->post('/forum/neu', [ForumController::class, 'store']);
$router->get('/forum/{slug}', [ForumController::class, 'show']);
$router->post('/forum/{slug}/antwort', [ForumController::class, 'reply']);

$router->get('/mitglieder', [MemberController::class, 'index']);
$router->get('/memberlist', [MemberController::class, 'redirectAlias']);

$router->get('/verwaltung', [AdminController::class, 'dashboard']);
$router->post('/verwaltung/users', [AdminController::class, 'storeUser']);
$router->post('/verwaltung/members', [AdminController::class, 'storeMember']);
$router->post('/verwaltung/members/{id}', [AdminController::class, 'updateMember']);
$router->post('/verwaltung/members/{id}/delete', [AdminController::class, 'deleteMember']);
$router->post('/verwaltung/users/{id}', [AdminController::class, 'updateUser']);
$router->post('/verwaltung/users/{id}/reset', [AdminController::class, 'resetUserPassword']);
$router->post('/verwaltung/users/{id}/delete', [AdminController::class, 'deleteUser']);
$router->post('/verwaltung/applications/{id}/approve', [AdminController::class, 'approveApplication']);
$router->post('/verwaltung/applications/{id}/reject', [AdminController::class, 'rejectApplication']);
$router->post('/verwaltung/outbox/{id}/retry', [AdminController::class, 'retryOutbox']);
$router->post('/verwaltung/contact/{id}/handled', [AdminController::class, 'markContactHandled']);
$router->get('/verwaltung/rechnungen', [InvoiceController::class, 'index']);
$router->get('/verwaltung/rechnungen/{id}', [InvoiceController::class, 'edit']);
$router->get('/verwaltung/rechnungen/{id}/vorschau', [InvoiceController::class, 'preview']);
$router->get('/verwaltung/rechnungen/{id}/pdf', [InvoiceController::class, 'download']);
$router->get('/verwaltung/rechnungen/{id}/original-pdf', [InvoiceController::class, 'downloadOriginal']);
$router->post('/verwaltung/rechnungen/speichern', [InvoiceController::class, 'save']);
$router->post('/verwaltung/rechnungen/einstellungen', [InvoiceController::class, 'saveSettings']);
$router->post('/verwaltung/rechnungen/{id}/loeschen', [InvoiceController::class, 'delete']);
$router->post('/verwaltung/rechnungen/{id}/finalisieren', [InvoiceController::class, 'finalize']);
$router->post('/verwaltung/rechnungen/{id}/versenden', [InvoiceController::class, 'send']);
$router->post('/verwaltung/rechnungen/{id}/bezahlt', [InvoiceController::class, 'paid']);
$router->post('/verwaltung/rechnungen/{id}/stornieren', [InvoiceController::class, 'cancel']);
$router->post('/verwaltung/rechnungen/outbox/{id}/retry', [InvoiceController::class, 'retry']);


$router->post('/verwaltung/news', [AdminController::class, 'storeNews']);
$router->post('/verwaltung/travels', [AdminController::class, 'storeTravel']);

$router->get('/mitgliedsantrag', [PageController::class, 'membershipApplication']);
$router->post('/mitgliedsantrag', [PageController::class, 'sendMembershipApplication']);
$router->get('/passwort-setzen', [PasswordController::class, 'form']);
$router->post('/passwort-setzen', [PasswordController::class, 'save']);

$router->get('/robots.txt', [\MMIG46\Controllers\SeoController::class, 'robots']);
$router->get('/sitemap.xml', [\MMIG46\Controllers\SeoController::class, 'sitemap']);

$router->get(
    '/trainingswochenende-2026',
    [PageController::class, 'trainingWeekend']
);

$router->post(
    '/trainingswochenende-2026/anmeldung',
    [PageController::class, 'sendTrainingWeekendRegistration']
);

// Muss zuletzt stehen: einsegmentige, in der Datenbank gepflegte Inhaltsseiten.
$router->get('/{slug}', [PageController::class, 'contentPage']);
