<?php
declare(strict_types=1);
use MMIG46\Core\Env;
use MMIG46\Core\View;
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
set_exception_handler(function (Throwable $e): void {
    http_response_code(500);

    error_log(sprintf(
        "[%s] %s in %s:%d\n%s",
        get_class($e),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine(),
        $e->getTraceAsString()
    ));

    $message = Env::get('APP_ENV') === 'production'
        ? 'Ein interner Fehler ist aufgetreten.'
        : $e->getMessage();

    echo View::render('errors/500', [
        'message' => $message,
    ]);
});
