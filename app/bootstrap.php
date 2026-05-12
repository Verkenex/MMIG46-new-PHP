<?php
declare(strict_types=1);
$root = dirname(__DIR__);
if (file_exists($root . '/vendor/autoload.php')) { require $root . '/vendor/autoload.php'; }
spl_autoload_register(function ($class) use ($root) {
    $prefix = 'MMIG46\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) return;
    $relative = substr($class, strlen($prefix));
    $file = $root . '/app/' . str_replace('\\', '/', $relative) . '.php';
    if (file_exists($file)) require $file;
});
MMIG46\Core\Env::load($root . '/.env');
MMIG46\Core\Session::start();
set_exception_handler(function(Throwable $e) {
    error_log($e);
    http_response_code(500);
    $message = MMIG46\Core\Env::get('APP_ENV') === 'production' ? 'Interner Serverfehler.' : $e->getMessage();
    echo MMIG46\Core\View::render('errors/500', ['message' => $message]);
});
