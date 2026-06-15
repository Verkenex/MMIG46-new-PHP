<?php

use MMIG46\Controllers\AdminController;
use MMIG46\Controllers\AuthController;
use MMIG46\Controllers\ForumController;
use MMIG46\Controllers\MemberController;
use MMIG46\Controllers\PageController;

/** @var MMIG46\Core\Router $router */

$router->get('/', [PageController::class, 'home']);

$router->get('/news', [PageController::class, 'news']);
$router->get('/news/{slug}', [PageController::class, 'newsDetail']);
$router->get('/reisen', [PageController::class, 'travels']);

$router->get('/verein', [PageController::class, 'verein']);
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

$router->get('/memberlist', [MemberController::class, 'index']);

$router->get('/verwaltung', [AdminController::class, 'dashboard']);
$router->post('/verwaltung/users', [AdminController::class, 'storeUser']);
$router->post('/verwaltung/members', [AdminController::class, 'storeMember']);
$router->post('/verwaltung/pages', [AdminController::class, 'storePage']);

$router->post('/verwaltung/news', [AdminController::class, 'storeNews']);
$router->post('/verwaltung/travels', [AdminController::class, 'storeTravel']);

$router->get('/mitgliedsantrag', [PageController::class, 'membershipApplication']);
$router->post('/mitgliedsantrag', [PageController::class, 'sendMembershipApplication']);