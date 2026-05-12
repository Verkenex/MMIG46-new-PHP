<?php
namespace MMIG46\Models;
use MMIG46\Core\DB;
final class User {
    public static function findByEmail(string $email): ?array { $s=DB::pdo()->prepare('SELECT * FROM users WHERE email=? LIMIT 1'); $s->execute([$email]); return $s->fetch() ?: null; }
    public static function find(int $id): ?array { $s=DB::pdo()->prepare('SELECT * FROM users WHERE id=?'); $s->execute([$id]); return $s->fetch() ?: null; }
    public static function all(): array { return DB::pdo()->query('SELECT id,name,email,role,email_verified_at,created_at FROM users ORDER BY name')->fetchAll(); }
}
