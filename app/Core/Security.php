<?php
namespace MMIG46\Core;
final class Security {
    public static function csrf(): string { if (empty($_SESSION['_csrf'])) $_SESSION['_csrf'] = bin2hex(random_bytes(32)); return $_SESSION['_csrf']; }
    public static function verifyCsrf(): void { if ($_SERVER['REQUEST_METHOD']==='POST' && !hash_equals($_SESSION['_csrf'] ?? '', $_POST['_csrf'] ?? '')) { http_response_code(419); exit('CSRF-Token ungueltig.'); } }
    public static function e(?string $v): string { return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
    public static function requireRole(array $roles): void { $role = $_SESSION['user']['role'] ?? 'guest'; if (!in_array($role,$roles,true)) { header('Location: /login'); exit; } }
    public static function passwordOk(string $p): bool { return strlen($p) >= 8; }
        public static function csrfField(): string
    {
        return '<input type="hidden" name="_csrf" value="' . self::e(self::csrf()) . '">';
    }
}
