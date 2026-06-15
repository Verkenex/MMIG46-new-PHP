<?php

namespace MMIG46\Core;

final class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->map('GET', $path, $handler);
    }

    public function post(string $path, array $handler): void
    {
        $this->map('POST', $path, $handler);
    }

    private function map(string $method, string $path, array $handler): void
    {
        $normalizedPath = rtrim($path, '/') ?: '/';
        $this->routes[$method][$normalizedPath] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = rtrim(parse_url($uri, PHP_URL_PATH) ?: '/', '/') ?: '/';
        $routes = $this->routes[$method] ?? [];

        $handler = $routes[$path] ?? null;

        if ($handler !== null) {
            [$class, $action] = $handler;
            echo (new $class())->$action();
            return;
        }

        foreach ($routes as $route => $candidateHandler) {
            $params = $this->matchDynamicRoute($route, $path);

            if ($params === null) {
                continue;
            }

            [$class, $action] = $candidateHandler;
            echo (new $class())->$action(...$params);
            return;
        }

        http_response_code(404);
        echo View::render('errors/404');
    }

    private function matchDynamicRoute(string $route, string $path): ?array
    {
        if (!str_contains($route, '{')) {
            return null;
        }

        $routeParts = explode('/', trim($route, '/'));
        $pathParts = explode('/', trim($path, '/'));

        if (count($routeParts) !== count($pathParts)) {
            return null;
        }

        $params = [];

        foreach ($routeParts as $index => $routePart) {
            $pathPart = $pathParts[$index] ?? '';

            if (
                str_starts_with($routePart, '{')
                && str_ends_with($routePart, '}')
            ) {
                $params[] = rawurldecode($pathPart);
                continue;
            }

            if ($routePart !== $pathPart) {
                return null;
            }
        }

        return $params;
    }
}