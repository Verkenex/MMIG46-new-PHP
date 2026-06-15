<?php

namespace MMIG46\Models;

use MMIG46\Core\DB;

class ContentPage
{
    public static function findPublishedBySlug(string $slug): ?array
    {
        $stmt = DB::pdo()->prepare(
            'SELECT * FROM content_pages WHERE slug = ? AND is_published = 1 LIMIT 1'
        );
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }

    public static function all(): array
    {
        return DB::pdo()
            ->query('SELECT * FROM content_pages ORDER BY slug')
            ->fetchAll();
    }

    public static function upsert(array $data): void
    {
        $stmt = DB::pdo()->prepare(
            'INSERT INTO content_pages
             (slug, title, teaser, body, meta_title, meta_description, is_published)
             VALUES (?, ?, ?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
             title = VALUES(title),
             teaser = VALUES(teaser),
             body = VALUES(body),
             meta_title = VALUES(meta_title),
             meta_description = VALUES(meta_description),
             is_published = VALUES(is_published)'
        );

        $stmt->execute([
            $data['slug'],
            $data['title'],
            $data['teaser'] ?? null,
            $data['body'],
            $data['meta_title'] ?? null,
            $data['meta_description'] ?? null,
            !empty($data['is_published']) ? 1 : 0,
        ]);
    }
}