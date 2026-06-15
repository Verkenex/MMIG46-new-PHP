<?php

namespace MMIG46\Models;

use MMIG46\Core\DB;

class NewsItem
{
    public static function published(int $limit = 20): array
    {
        $stmt = DB::pdo()->prepare(
            'SELECT * FROM news_items
             WHERE is_published = 1
             ORDER BY published_at DESC
             LIMIT ?'
        );
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function latest(int $limit = 3): array
    {
        return self::published($limit);
    }

    public static function findPublishedBySlug(string $slug): ?array
    {
        $stmt = DB::pdo()->prepare(
            'SELECT * FROM news_items WHERE slug = ? AND is_published = 1 LIMIT 1'
        );
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }
}