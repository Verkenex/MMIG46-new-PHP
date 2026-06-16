<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/app/bootstrap.php';

use MMIG46\Core\Router;

$router = new Router();

require dirname(__DIR__) . '/config/routes.php';

$router->dispatch(
    $_SERVER['REQUEST_METHOD'] ?? 'GET',
    parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/'
);