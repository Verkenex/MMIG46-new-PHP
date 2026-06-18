<?php

declare(strict_types=1);

namespace MMIG46\Models;

use MMIG46\Core\Database as DB;

final class Search
{
    public static function query(string $term, string $lang = 'de', int $limit = 30): array
    {
        $term = trim($term);

        if (mb_strlen($term) < 2) {
            return [];
        }

        $like = '%' . self::escapeLike($term) . '%';

        $sql = "
            SELECT 'news' AS type,
                   title,
                   slug,
                   teaser AS excerpt,
                   published_at AS item_date,
                   CONCAT('/news/', slug) AS url
            FROM news_items
            WHERE is_published = 1
              AND lang = :lang_news
              AND (title LIKE :like_news ESCAPE '\\\\'
                   OR teaser LIKE :like_news ESCAPE '\\\\'
                   OR body LIKE :like_news ESCAPE '\\\\')

            UNION ALL

            SELECT 'travel' AS type,
                   title,
                   slug,
                   teaser AS excerpt,
                   starts_on AS item_date,
                   CONCAT('/reisen/', slug) AS url
            FROM travel_items
            WHERE is_published = 1
              AND lang = :lang_travel
              AND (title LIKE :like_travel ESCAPE '\\\\'
                   OR location LIKE :like_travel ESCAPE '\\\\'
                   OR teaser LIKE :like_travel ESCAPE '\\\\'
                   OR body LIKE :like_travel ESCAPE '\\\\')

            UNION ALL

            SELECT 'page' AS type,
                   title,
                   slug,
                   teaser AS excerpt,
                   updated_at AS item_date,
                   CONCAT('/', slug) AS url
            FROM content_pages
            WHERE is_published = 1
              AND lang = :lang_page
              AND (title LIKE :like_page ESCAPE '\\\\'
                   OR teaser LIKE :like_page ESCAPE '\\\\'
                   OR body LIKE :like_page ESCAPE '\\\\')

            UNION ALL

            SELECT 'forum' AS type,
                   title,
                   CAST(id AS CHAR) AS slug,
                   LEFT(body, 240) AS excerpt,
                   created_at AS item_date,
                   '/forum' AS url
            FROM forum_posts
            WHERE title LIKE :like_forum ESCAPE '\\\\'
               OR body LIKE :like_forum ESCAPE '\\\\'

            ORDER BY item_date DESC
            LIMIT :limit
        ";

        $stmt = DB::pdo()->prepare($sql);

        $stmt->bindValue(':lang_news', $lang);
        $stmt->bindValue(':lang_travel', $lang);
        $stmt->bindValue(':lang_page', $lang);

        $stmt->bindValue(':like_news', $like);
        $stmt->bindValue(':like_travel', $like);
        $stmt->bindValue(':like_page', $like);
        $stmt->bindValue(':like_forum', $like);

        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        $results = $stmt->fetchAll();

        $results = array_merge(
            $results,
            self::searchStaticPages($term, $lang)
        );

        return array_slice($results, 0, $limit);
    }

    private static function searchStaticPages(string $term, string $lang): array
    {
        $needle = mb_strtolower(trim($term));

        if ($needle === '') {
            return [];
        }

        $staticPages = [
            'de' => [
                [
                    'type' => 'page',
                    'title' => 'Verein',
                    'slug' => 'verein',
                    'excerpt' => 'Informationen über die MMIG46, Mitgliedschaft, Vereinsaktivitäten, Fly-Ins und die europäische PA-46-Community.',
                    'item_date' => null,
                    'url' => '/verein',
                ],
                [
                    'type' => 'page',
                    'title' => 'Malibu Mirage',
                    'slug' => 'malibu-mirage',
                    'excerpt' => 'Informationen zur Piper PA-46-Familie: Malibu, Mirage, Matrix, Meridian, M350, M500, M600 und JetPROP.',
                    'item_date' => null,
                    'url' => '/malibu-mirage',
                ],
                [
                    'type' => 'page',
                    'title' => 'Mitglieder',
                    'slug' => 'mitglieder',
                    'excerpt' => 'Mitgliederliste der MMIG46 mit Informationen zu Haltern, Piloten und Flugzeugen.',
                    'item_date' => null,
                    'url' => '/mitglieder',
                ],
                [
                    'type' => 'page',
                    'title' => 'Kontakt',
                    'slug' => 'kontakt',
                    'excerpt' => 'Kontaktformular für Fragen zur MMIG46, zur Mitgliedschaft und zu Veranstaltungen.',
                    'item_date' => null,
                    'url' => '/kontakt',
                ],
                [
                    'type' => 'page',
                    'title' => 'Mitgliedsantrag',
                    'slug' => 'mitgliedsantrag',
                    'excerpt' => 'Online-Antrag zur Mitgliedschaft in der MMIG46.',
                    'item_date' => null,
                    'url' => '/mitgliedsantrag',
                ],
                [
                    'type' => 'page',
                    'title' => 'Impressum',
                    'slug' => 'impressum',
                    'excerpt' => 'Rechtliche Angaben und Anbieterkennzeichnung der MMIG46.',
                    'item_date' => null,
                    'url' => '/impressum',
                ],
                [
                    'type' => 'page',
                    'title' => 'Datenschutz',
                    'slug' => 'datenschutz',
                    'excerpt' => 'Informationen zur Verarbeitung personenbezogener Daten, Session-Cookies, Kontaktformular und Mitgliedsantrag.',
                    'item_date' => null,
                    'url' => '/datenschutz',
                ],
                [
                    'type' => 'page',
                    'title' => 'AGB',
                    'slug' => 'agb',
                    'excerpt' => 'Nutzungsbedingungen für Website, Forum und Mitgliederbereiche der MMIG46.',
                    'item_date' => null,
                    'url' => '/agb',
                ],
                [
                    'type' => 'page',
                    'title' => 'Suche',
                    'slug' => 'suche',
                    'excerpt' => 'Suchfunktion für News, Reisen, Forum und statische Seiten der MMIG46-Website.',
                    'item_date' => null,
                    'url' => '/suche',
                ],
            ],

            'en' => [
                [
                    'type' => 'page',
                    'title' => 'The Club',
                    'slug' => 'verein',
                    'excerpt' => 'Information about MMIG46, membership, club activities, fly-ins and the European PA-46 community.',
                    'item_date' => null,
                    'url' => '/verein',
                ],
                [
                    'type' => 'page',
                    'title' => 'Malibu Mirage',
                    'slug' => 'malibu-mirage',
                    'excerpt' => 'Information about the Piper PA-46 family: Malibu, Mirage, Matrix, Meridian, M350, M500, M600 and JetPROP.',
                    'item_date' => null,
                    'url' => '/malibu-mirage',
                ],
                [
                    'type' => 'page',
                    'title' => 'Members',
                    'slug' => 'mitglieder',
                    'excerpt' => 'MMIG46 member list with information about owners, pilots and aircraft.',
                    'item_date' => null,
                    'url' => '/mitglieder',
                ],
                [
                    'type' => 'page',
                    'title' => 'Contact',
                    'slug' => 'kontakt',
                    'excerpt' => 'Contact form for questions about MMIG46, membership and events.',
                    'item_date' => null,
                    'url' => '/kontakt',
                ],
                [
                    'type' => 'page',
                    'title' => 'Membership Application',
                    'slug' => 'mitgliedsantrag',
                    'excerpt' => 'Online application for membership in MMIG46.',
                    'item_date' => null,
                    'url' => '/mitgliedsantrag',
                ],
                [
                    'type' => 'page',
                    'title' => 'Legal Notice',
                    'slug' => 'impressum',
                    'excerpt' => 'Legal information and provider identification for MMIG46.',
                    'item_date' => null,
                    'url' => '/impressum',
                ],
                [
                    'type' => 'page',
                    'title' => 'Privacy Policy',
                    'slug' => 'datenschutz',
                    'excerpt' => 'Information about personal data processing, session cookies, contact form and membership application.',
                    'item_date' => null,
                    'url' => '/datenschutz',
                ],
                [
                    'type' => 'page',
                    'title' => 'Terms',
                    'slug' => 'agb',
                    'excerpt' => 'Terms of use for the MMIG46 website, forum and member areas.',
                    'item_date' => null,
                    'url' => '/agb',
                ],
                [
                    'type' => 'page',
                    'title' => 'Search',
                    'slug' => 'suche',
                    'excerpt' => 'Search function for news, travels, forum and static pages of the MMIG46 website.',
                    'item_date' => null,
                    'url' => '/suche',
                ],
            ],
        ];

        $pages = $staticPages[$lang] ?? $staticPages['de'];
        $matches = [];

        foreach ($pages as $page) {
            $haystack = mb_strtolower(
                ($page['title'] ?? '') . ' ' .
                ($page['slug'] ?? '') . ' ' .
                ($page['excerpt'] ?? '')
            );

            if (str_contains($haystack, $needle)) {
                $matches[] = $page;
            }
        }

        return $matches;
    }

    private static function escapeLike(string $value): string
    {
        return str_replace(
            ['\\', '%', '_'],
            ['\\\\', '\\%', '\\_'],
            $value
        );
    }
}