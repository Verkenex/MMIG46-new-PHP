<?php

namespace MMIG46\Models;

use MMIG46\Core\DB;

final class ForumPost
{
    public static function forTopic(int $topicId): array
    {
        $stmt = DB::pdo()->prepare(
            'SELECT p.*, u.name AS author
             FROM forum_posts p
             JOIN users u ON u.id = p.user_id
             WHERE p.topic_id = ? AND p.is_deleted = 0
             ORDER BY p.created_at ASC'
        );
        $stmt->execute([$topicId]);

        return $stmt->fetchAll();
    }

    public static function create(int $topicId, int $userId, string $body): void
    {
        $pdo = DB::pdo();

        $pdo->beginTransaction();

        $stmt = $pdo->prepare(
            'INSERT INTO forum_posts(topic_id, user_id, body)
             VALUES(?, ?, ?)'
        );
        $stmt->execute([$topicId, $userId, $body]);

        $stmt = $pdo->prepare(
            'UPDATE forum_topics SET updated_at = NOW() WHERE id = ?'
        );
        $stmt->execute([$topicId]);

        $pdo->commit();
    }
}