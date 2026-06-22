<?php

declare(strict_types=1);

namespace MMIG46\Core;

final class Seo
{
    private const SITE_NAME = 'MMIG46 e.V.';
    private const DEFAULT_DESCRIPTION = 'MMIG46 e.V. - Verein, News, Reisen, Forum und Informationen rund um die Malibu Mirage Interessengemeinschaft.';

    /**
     * Nur öffentliche, indexierbare statische Seiten.
     * Dynamische News/Reisen werden zusätzlich in sitemap.xml aus der DB ergänzt.
     */
    public static function staticPages(): array
    {
        return [
            '/' => [
                'title' => 'MMIG46 e.V.',
                'description' => self::DEFAULT_DESCRIPTION,
                'priority' => '1.0',
                'changefreq' => 'weekly',
            ],
            '/news' => [
                'title' => 'News - MMIG46 e.V.',
                'description' => 'Aktuelle Meldungen, Vereinsinformationen und Neuigkeiten der MMIG46.',
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ],
            '/reisen' => [
                'title' => 'Reisen - MMIG46 e.V.',
                'description' => 'Reisen, Fly-ins und Veranstaltungen der MMIG46.',
                'priority' => '0.8',
                'changefreq' => 'monthly',
            ],
            '/reisen/fly-in-woerthersee-2026' => [
                'title' => 'Fly-in Wörthersee 2026 - MMIG46 e.V.',
                'description' => 'Informationen zum Fly-in Wörthersee 2026 der MMIG46.',
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ],
            '/malibu-mirage' => [
                'title' => 'Malibu Mirage - MMIG46 e.V.',
                'description' => 'Informationen und Archivseiten rund um die Piper Malibu Mirage.',
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ],
            '/verein' => [
                'title' => 'Verein - MMIG46 e.V.',
                'description' => 'Informationen über den Verein MMIG46 e.V., Ziele, Mitglieder und Aktivitäten.',
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ],
            '/kontakt' => [
                'title' => 'Kontakt - MMIG46 e.V.',
                'description' => 'Kontakt zur MMIG46 aufnehmen.',
                'priority' => '0.6',
                'changefreq' => 'yearly',
            ],
            '/mitgliedsantrag' => [
                'title' => 'Mitgliedsantrag - MMIG46 e.V.',
                'description' => 'Mitgliedsantrag für die MMIG46.',
                'priority' => '0.5',
                'changefreq' => 'yearly',
            ],
            '/impressum' => [
                'title' => 'Impressum - MMIG46 e.V.',
                'description' => 'Impressum der Website der MMIG46.',
                'priority' => '0.3',
                'changefreq' => 'yearly',
            ],
            '/datenschutz' => [
                'title' => 'Datenschutz - MMIG46 e.V.',
                'description' => 'Datenschutzerklärung der Website der MMIG46.',
                'priority' => '0.3',
                'changefreq' => 'yearly',
            ],
            '/agb' => [
                'title' => 'AGB - MMIG46 e.V.',
                'description' => 'Allgemeine Geschäftsbedingungen der MMIG46.',
                'priority' => '0.3',
                'changefreq' => 'yearly',
            ],
        ];
    }

    public static function metaForCurrentRequest(array $overrides = []): array
    {
        $path = self::currentPath();

        $defaults = self::staticPages()[$path] ?? [
            'title' => self::titleFromPath($path),
            'description' => self::DEFAULT_DESCRIPTION,
        ];

        $meta = array_merge($defaults, $overrides);

        $title = trim((string)($meta['title'] ?? self::SITE_NAME));
        $description = trim((string)($meta['description'] ?? self::DEFAULT_DESCRIPTION));

        return [
            'title' => self::limit($title, 65),
            'description' => self::limit($description, 160),
            'canonical' => self::canonicalUrl($path),
            'robots' => self::robotsDirective($path),
            'og_type' => $path === '/' ? 'website' : 'article',
            'og_image' => self::absoluteUrl('/assets/img/og-default.jpg'),
        ];
    }

    public static function currentPath(): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        return $path === '' ? '/' : $path;
    }

    public static function canonicalUrl(?string $path = null): string
    {
        $path = $path ?? self::currentPath();

        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        return self::absoluteUrl($path);
    }

    public static function absoluteUrl(string $path): string
    {
        $base = rtrim((string) Env::get('APP_URL', 'https://www.mmig46.de'), '/');

        if ($path === '') {
            $path = '/';
        }

        if ($path[0] !== '/') {
            $path = '/' . $path;
        }

        return $base . $path;
    }

    public static function robotsDirective(string $path): string
    {
        $noindexPrefixes = [
            '/login',
            '/logout',
            '/verwaltung',
            '/suche',
            '/search',
            '/forum/neu',
        ];

        foreach ($noindexPrefixes as $prefix) {
            if ($path === $prefix || str_starts_with($path, $prefix . '/')) {
                return 'noindex, nofollow';
            }
        }

        return 'index, follow';
    }

    public static function sitemapStaticUrls(): array
    {
        $today = date('Y-m-d');

        $urls = [];

        foreach (self::staticPages() as $path => $meta) {
            $urls[] = [
                'loc' => self::canonicalUrl($path),
                'lastmod' => $today,
                'changefreq' => $meta['changefreq'] ?? 'monthly',
                'priority' => $meta['priority'] ?? '0.5',
            ];
        }

        return $urls;
    }

    private static function titleFromPath(string $path): string
    {
        $label = trim(str_replace(['-', '/'], [' ', ' '], $path));

        if ($label === '') {
            return self::SITE_NAME;
        }

        return mb_convert_case($label, MB_CASE_TITLE, 'UTF-8') . ' - ' . self::SITE_NAME;
    }

    private static function limit(string $value, int $max): string
    {
        $value = trim(preg_replace('/\s+/', ' ', $value) ?? $value);

        if (mb_strlen($value, 'UTF-8') <= $max) {
            return $value;
        }

        return rtrim(mb_substr($value, 0, $max - 1, 'UTF-8')) . '…';
    }
}