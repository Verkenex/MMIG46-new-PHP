<?php

namespace MMIG46\Models;

use MMIG46\Core\DB;

class TravelItem
{
    public static function published(string $lang = 'de'): array
    {
        $stmt = DB::pdo()->prepare(
            'SELECT id, lang, title, slug, image_path, location, starts_on, ends_on, status,
                    teaser, cta_label, legacy_pdf_url, legacy_pdf_path, body, is_published
            FROM travel_items
            WHERE is_published = 1 AND lang = ?
            ORDER BY
                CASE status
                    WHEN "planned" THEN 1
                    WHEN "completed" THEN 2
                    ELSE 3
                END,
                starts_on DESC,
                id DESC'
        );
        $stmt->execute([$lang]);

        return $stmt->fetchAll();
    }

    public static function latest(int $limit = 3, string $lang = 'de'): array
    {
        $stmt = DB::pdo()->prepare(
            'SELECT id, lang, title, slug, image_path, location, starts_on, ends_on, status,
                    teaser, cta_label, legacy_pdf_url, legacy_pdf_path, body, is_published
            FROM travel_items
            WHERE is_published = 1 AND lang = ?
            ORDER BY starts_on DESC, id DESC
            LIMIT ?'
        );
        $stmt->bindValue(1, $lang);
        $stmt->bindValue(2, $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function findPublishedBySlug(string $slug, string $lang = 'de'): ?array
    {
        $stmt = DB::pdo()->prepare(
            'SELECT id, lang, title, slug, image_path, location, starts_on, ends_on, status,
                    teaser, cta_label, legacy_pdf_url, legacy_pdf_path, body, is_published
            FROM travel_items
            WHERE slug = ? AND lang = ? AND is_published = 1
            LIMIT 1'
        );
        $stmt->execute([$slug, $lang]);

        return $stmt->fetch() ?: null;
    }



    public static function all(int $limit = 200): array
    {
        $stmt = DB::pdo()->prepare(
            'SELECT id, title, slug, image_path, location, starts_on, ends_on, status, teaser, cta_label, body, is_published
            FROM travel_items
            ORDER BY starts_on DESC, id DESC
            LIMIT ?'
        );

        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}