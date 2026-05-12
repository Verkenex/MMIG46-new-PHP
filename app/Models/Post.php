<?php
namespace MMIG46\Models;
use MMIG46\Core\DB;
final class Post {
    public static function all(): array { return DB::pdo()->query('SELECT p.*, u.name AS author FROM forum_posts p JOIN users u ON u.id=p.user_id ORDER BY p.pinned DESC, p.created_at DESC')->fetchAll(); }
    public static function create(int $uid,string $title,string $body): void { $s=DB::pdo()->prepare('INSERT INTO forum_posts(user_id,title,body) VALUES(?,?,?)'); $s->execute([$uid,$title,$body]); }
}
