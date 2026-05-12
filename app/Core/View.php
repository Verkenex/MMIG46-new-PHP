<?php
namespace MMIG46\Core;
final class View {
    public static function render(string $view, array $data=[]): string {
        extract($data, EXTR_SKIP);
        ob_start();
        require dirname(__DIR__) . '/Views/' . $view . '.php';
        $content = ob_get_clean();
        ob_start(); require dirname(__DIR__) . '/Views/layouts/main.php'; return ob_get_clean();
    }
    public static function partial(string $view, array $data=[]): string {
        extract($data, EXTR_SKIP); ob_start(); require dirname(__DIR__) . '/Views/' . $view . '.php'; return ob_get_clean();
    }
}
