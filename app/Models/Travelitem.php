<?php

namespace MMIG46\Models;

use MMIG46\Core\DB;

class TravelItem
{
    public static function published(): array
    {
        $stmt = DB::pdo()->query(
            "SELECT
                id,
                title,
                slug,
                image_path,
                location,
                starts_on,
                ends_on,
                status,
                teaser,
                cta_label,
                body,
                is_published
            FROM travel_items
            WHERE is_published = 1
            ORDER BY
                COALESCE(starts_on, ends_on, '1900-01-01') DESC,
                title ASC"
        );

        return $stmt->fetchAll();
    }

    public static function latest(int $limit = 3): array
    {
        $stmt = DB::pdo()->prepare(
            "SELECT
                id,
                title,
                slug,
                image_path,
                location,
                starts_on,
                ends_on,
                status,
                teaser,
                cta_label,
                body,
                is_published
            FROM travel_items
            WHERE is_published = 1
            ORDER BY
                COALESCE(starts_on, ends_on, '1900-01-01') DESC,
                title ASC
            LIMIT ?"
        );

        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function findPublishedBySlug(string $slug): ?array
    {
        $stmt = DB::pdo()->prepare(
            "SELECT
                id,
                title,
                slug,
                image_path,
                location,
                starts_on,
                ends_on,
                status,
                teaser,
                cta_label,
                body,
                is_published
            FROM travel_items
            WHERE slug = ?
              AND is_published = 1
            LIMIT 1"
        );

        $stmt->execute([$slug]);

        return $stmt->fetch() ?: null;
    }
}