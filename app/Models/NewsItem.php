<?php

declare(strict_types=1);

namespace MMIG46\Models;

use MMIG46\Core\Database as DB;

final class NewsItem
{
    public static function published(int $limit = 50, string $lang = 'de'): array
    {
        $stmt = DB::pdo()->prepare(
            'SELECT id, lang, title, slug, category, image_path, comment_count, teaser, body, published_at, is_published
             FROM news_items
             WHERE is_published = 1 AND lang = ?
             ORDER BY published_at DESC
             LIMIT ?'
        );
        $stmt->bindValue(1, $lang);
        $stmt->bindValue(2, $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function latest(int $limit = 3, string $lang = 'de'): array
    {
        return self::published($limit, $lang);
    }

    public static function findPublishedBySlug(string $slug, string $lang = 'de'): ?array
    {
        $stmt = DB::pdo()->prepare(
            'SELECT id, lang, title, slug, category, image_path, comment_count, teaser, body, published_at, is_published
             FROM news_items
             WHERE slug = ? AND lang = ? AND is_published = 1
             LIMIT 1'
        );
        $stmt->execute([$slug, $lang]);

        return $stmt->fetch() ?: null;
    }

    public static function all(int $limit = 200, string $lang = 'de'): array
    {
        $stmt = DB::pdo()->prepare(
            'SELECT id, lang, title, slug, category, image_path, comment_count, teaser, body, published_at, is_published
             FROM news_items
             WHERE lang = ?
             ORDER BY published_at DESC, id DESC
             LIMIT ?'
        );
        $stmt->bindValue(1, $lang);
        $stmt->bindValue(2, $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}