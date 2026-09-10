<?php
declare(strict_types=1);
namespace MMIG46\Models;
use MMIG46\Core\DB;

final class ContentPage
{
    public static function findPublishedBySlug(string $slug, string $lang = 'de'): ?array
    {
        $stmt=DB::pdo()->prepare('SELECT * FROM content_pages WHERE slug=? AND lang=? AND is_published=1 LIMIT 1');
        $stmt->execute([$slug,$lang]); return $stmt->fetch() ?: null;
    }
}
