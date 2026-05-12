<?php
namespace MMIG46\Core;
final class Env {
    public static function load(string $file): void {
        if (!is_file($file)) return;
        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
            [$key, $value] = explode('=', $line, 2);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            $_ENV[trim($key)] = $value;
            putenv(trim($key) . '=' . $value);
        }
    }
    public static function get(string $key, ?string $default=null): ?string { return $_ENV[$key] ?? getenv($key) ?: $default; }
}
