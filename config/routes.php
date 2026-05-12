<?php
use MMIG46\Controllers\PageController; use MMIG46\Controllers\AuthController; use MMIG46\Controllers\ForumController; use MMIG46\Controllers\MemberController; use MMIG46\Controllers\AdminController;
$router->get('/', [PageController::class,'home']);
foreach(['/news','/reisen','/verein','/impressum','/datenschutz','/agb'] as $p) $router->get($p,[PageController::class,'staticPage']);
$router->get('/kontakt',[PageController::class,'contact']); $router->post('/kontakt',[PageController::class,'sendContact']);
$router->get('/login',[AuthController::class,'login']); $router->post('/login',[AuthController::class,'doLogin']); $router->post('/logout',[AuthController::class,'logout']);
$router->get('/forum',[ForumController::class,'index']); $router->get('/forum/neu',[ForumController::class,'create']); $router->post('/forum/neu',[ForumController::class,'store']);
$router->get('/memberlist',[MemberController::class,'index']);
$router->get('/verwaltung',[AdminController::class,'dashboard']); $router->post('/verwaltung/users',[AdminController::class,'storeUser']); $router->post('/verwaltung/members',[AdminController::class,'storeMember']);
