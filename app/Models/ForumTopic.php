<?php

namespace MMIG46\Models;

use MMIG46\Core\DB;

final class ForumTopic
{
    public static function all(): array
    {
        return DB::pdo()->query(
            'SELECT t.*, u.name AS author,
                    (
                        SELECT COUNT(*)
                        FROM forum_posts p
                        WHERE p.topic_id = t.id AND p.is_deleted = 0
                    ) AS reply_count
             FROM forum_topics t
             JOIN users u ON u.id = t.user_id
             ORDER BY t.is_pinned DESC, t.updated_at DESC, t.created_at DESC'
        )->fetchAll();
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = DB::pdo()->prepare(
            'SELECT t.*, u.name AS author
             FROM forum_topics t
             JOIN users u ON u.id = t.user_id
             WHERE t.slug = ?
             LIMIT 1'
        );
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }

    public static function create(int $userId, string $title, string $body): string
    {
        $pdo = DB::pdo();
        $slug = self::slugify($title) . '-' . substr(bin2hex(random_bytes(4)), 0, 8);

        $pdo->beginTransaction();

        $stmt = $pdo->prepare(
            'INSERT INTO forum_topics(user_id, title, slug, updated_at)
             VALUES(?, ?, ?, NOW())'
        );
        $stmt->execute([$userId, $title, $slug]);

        $topicId = (int) $pdo->lastInsertId();

        $stmt = $pdo->prepare(
            'INSERT INTO forum_posts(topic_id, user_id, body)
             VALUES(?, ?, ?)'
        );
        $stmt->execute([$topicId, $userId, $body]);

        $pdo->commit();

        return $slug;
    }

    private static function slugify(string $value): string
    {
        $value = mb_strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9äöüß]+/iu', '-', $value);
        $value = trim((string) $value, '-');

        return $value !== '' ? $value : 'thema';
    }
}