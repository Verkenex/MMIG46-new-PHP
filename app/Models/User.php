<?php
namespace MMIG46\Models;
use MMIG46\Core\DB;
final class User {
    public static function findByEmail(string $email): ?array { $s=DB::pdo()->prepare('SELECT * FROM users WHERE email=? LIMIT 1'); $s->execute([$email]); return $s->fetch() ?: null; }
    public static function find(int $id): ?array { $s=DB::pdo()->prepare('SELECT * FROM users WHERE id=?'); $s->execute([$id]); return $s->fetch() ?: null; }
    public static function all(): array { return DB::pdo()->query('SELECT u.id,u.name,u.email,u.role,u.email_verified_at,u.created_at,(SELECT COUNT(*) FROM forum_topics t WHERE t.user_id=u.id) AS topic_count,(SELECT COUNT(*) FROM forum_posts p WHERE p.user_id=u.id) AS post_count,(SELECT COUNT(*) FROM members m WHERE m.user_id=u.id) AS member_count FROM users u ORDER BY u.name')->fetchAll(); }
}
