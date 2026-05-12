<?php
namespace MMIG46\Core;
final class Router {
    private array $routes = [];
    public function get(string $path, array $handler): void { $this->map('GET',$path,$handler); }
    public function post(string $path, array $handler): void { $this->map('POST',$path,$handler); }
    private function map(string $method,string $path,array $handler): void { $this->routes[$method][$path] = $handler; }
    public function dispatch(string $method, string $uri): void {
        $path = rtrim($uri, '/') ?: '/';
        $handler = $this->routes[$method][$path] ?? null;
        if (!$handler) { http_response_code(404); echo View::render('errors/404'); return; }
        [$class,$action] = $handler; echo (new $class())->$action();
    }
}
