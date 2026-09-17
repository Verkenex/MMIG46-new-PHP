<?php

namespace MMIG46\Models;

use MMIG46\Core\DB;

final class ForumTopic
{
    public static function all(?string $role = null): array
    {
        $visibilities = self::allowedVisibilities($role);
        $placeholders = implode(',', array_fill(0, count($visibilities), '?'));
        $stmt = DB::pdo()->prepare(
            'SELECT t.*, COALESCE(t.legacy_author_name, u.name) AS author,
                    s.name AS section_name, s.visibility AS section_visibility,
                    COALESCE(post_stats.reply_count, 0) AS reply_count,
                    COALESCE(post_stats.last_post_at, t.updated_at, t.created_at) AS last_post_at
             FROM forum_topics t
             LEFT JOIN users u ON u.id = t.user_id
             LEFT JOIN forum_sections s ON s.id = t.section_id
             LEFT JOIN (
                 SELECT topic_id, COUNT(*) AS reply_count, MAX(created_at) AS last_post_at
                 FROM forum_posts
                 WHERE is_deleted = 0
                 GROUP BY topic_id
             ) post_stats ON post_stats.topic_id = t.id
             WHERE s.id IS NULL OR s.visibility IN (' . $placeholders . ')
             ORDER BY COALESCE(s.sort_order, 0), s.name,
                      COALESCE(post_stats.last_post_at, t.updated_at, t.created_at) DESC,
                      t.id DESC'
        );
        $stmt->execute($visibilities);
        return $stmt->fetchAll();
    }

    public static function findBySlug(string $slug, ?string $role = null): ?array
    {
        $visibilities = self::allowedVisibilities($role);
        $placeholders = implode(',', array_fill(0, count($visibilities), '?'));
        $stmt = DB::pdo()->prepare(
            'SELECT t.*, COALESCE(t.legacy_author_name, u.name) AS author,
                    s.name AS section_name, s.visibility AS section_visibility
             FROM forum_topics t
             LEFT JOIN users u ON u.id = t.user_id
             LEFT JOIN forum_sections s ON s.id = t.section_id
             WHERE t.slug = ? AND (s.id IS NULL OR s.visibility IN (' . $placeholders . '))
             LIMIT 1'
        );
        $stmt->execute(array_merge([$slug], $visibilities));
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

    private static function allowedVisibilities(?string $role): array
    {
        if ($role === 'admin' || $role === 'moderator') {
            return ['public', 'member', 'admin'];
        }

        if ($role === 'member') {
            return ['public', 'member'];
        }

        return ['public'];
    }
}
