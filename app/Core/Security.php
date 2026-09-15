<?php
namespace MMIG46\Core;
final class Security {
    public static function csrf(): string { if (empty($_SESSION['_csrf'])) $_SESSION['_csrf'] = bin2hex(random_bytes(32)); return $_SESSION['_csrf']; }
    public static function verifyCsrf(): void { if ($_SERVER['REQUEST_METHOD']==='POST' && !hash_equals($_SESSION['_csrf'] ?? '', $_POST['_csrf'] ?? '')) { http_response_code(419); exit('CSRF-Token ungueltig.'); } }
    public static function e(?string $v): string { return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
    public static function clientFingerprint(): string
    {
        $ip = (string) ($_SERVER['REMOTE_ADDR'] ?? 'unknown');
        $key = (string) Env::get('APP_KEY', '');
        return hash_hmac('sha256', $ip, $key !== '' ? $key : 'mmig46');
    }
    public static function currentUser(): ?array
    {
        $sessionUser = $_SESSION['user'] ?? null;
        $userId = is_array($sessionUser) ? (int)($sessionUser['id'] ?? 0) : 0;

        if ($userId <= 0) {
            return null;
        }

        $statement = DB::pdo()->prepare(
            'SELECT id, name, email, role, email_verified_at, created_at, updated_at FROM users WHERE id = ? LIMIT 1'
        );
        $statement->execute([$userId]);
        $user = $statement->fetch();

        if (!$user || empty($user['email_verified_at'])) {
            unset($_SESSION['user']);
            return null;
        }

        $authStamp = (string)($user['updated_at'] ?: $user['created_at']);
        $sessionStamp = (string)($sessionUser['auth_stamp'] ?? '');

        if ($sessionStamp !== '' && !hash_equals($sessionStamp, $authStamp)) {
            unset($_SESSION['user']);
            return null;
        }

        $_SESSION['user'] = [
            'id' => (int)$user['id'],
            'name' => (string)$user['name'],
            'email' => (string)$user['email'],
            'role' => (string)$user['role'],
            'auth_stamp' => $authStamp,
        ];

        return $_SESSION['user'];
    }
    public static function requireRole(array $roles): void { $user = self::currentUser(); $role = $user['role'] ?? 'guest'; if (!in_array($role,$roles,true)) { header('Location: /login'); exit; } }
    public static function passwordOk(string $p): bool { return strlen($p) >= 8; }
        public static function csrfField(): string
    {
        return '<input type="hidden" name="_csrf" value="' . self::e(self::csrf()) . '">';
    }
}
