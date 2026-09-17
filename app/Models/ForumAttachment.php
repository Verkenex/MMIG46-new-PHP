<?php

declare(strict_types=1);

namespace MMIG46\Models;

use MMIG46\Core\DB;

final class ForumAttachment
{
    public static function forTopic(int $topicId): array
    {
        $stmt = DB::pdo()->prepare(
            'SELECT a.*
             FROM forum_attachments a
             JOIN forum_posts p ON p.id = a.post_id
             WHERE p.topic_id = ? AND p.is_deleted = 0
             ORDER BY a.id ASC'
        );
        $stmt->execute([$topicId]);

        $grouped = [];
        foreach ($stmt->fetchAll() as $attachment) {
            $grouped[(int) $attachment['post_id']][] = $attachment;
        }

        return $grouped;
    }

    public static function findAccessible(int $id, ?string $role): ?array
    {
        $visibilities = ['public'];
        if ($role === 'member') {
            $visibilities[] = 'member';
        } elseif ($role === 'admin' || $role === 'moderator') {
            $visibilities = ['public', 'member', 'admin'];
        }

        $placeholders = implode(',', array_fill(0, count($visibilities), '?'));
        $stmt = DB::pdo()->prepare(
            'SELECT a.*
             FROM forum_attachments a
             JOIN forum_posts p ON p.id = a.post_id
             JOIN forum_topics t ON t.id = p.topic_id
             LEFT JOIN forum_sections s ON s.id = t.section_id
             WHERE a.id = ?
               AND p.is_deleted = 0
               AND (s.id IS NULL OR s.visibility IN (' . $placeholders . '))
             LIMIT 1'
        );
        $stmt->execute(array_merge([$id], $visibilities));

        return $stmt->fetch() ?: null;
    }
}
