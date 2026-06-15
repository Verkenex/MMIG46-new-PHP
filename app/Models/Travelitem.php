<?php

namespace MMIG46\Models;

use MMIG46\Core\DB;

class TravelItem
{
    public static function published(): array
    {
        return DB::pdo()
            ->query(
                "SELECT * FROM travel_items
                 WHERE is_published = 1
                 ORDER BY
                   CASE status WHEN 'planned' THEN 0 WHEN 'completed' THEN 1 ELSE 2 END,
                   starts_on IS NULL,
                   starts_on DESC,
                   title"
            )
            ->fetchAll();
    }

    public static function latest(int $limit = 3): array
    {
        $stmt = DB::pdo()->prepare(
            "SELECT * FROM travel_items
             WHERE is_published = 1
             ORDER BY
               CASE status WHEN 'planned' THEN 0 WHEN 'completed' THEN 1 ELSE 2 END,
               starts_on IS NULL,
               starts_on DESC
             LIMIT ?"
        );
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function findPublishedBySlug(string $slug): ?array
    {
        $stmt = DB::pdo()->prepare(
            'SELECT * FROM travel_items WHERE slug = ? AND is_published = 1 LIMIT 1'
        );
        $stmt->execute([$slug]);
        return $stmt->fetch() ?: null;
    }
}