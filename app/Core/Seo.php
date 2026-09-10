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
    public static function staticPages(?string $lang = null): array
    {
        $lang = $lang ?? I18n::current();
        $en = $lang === 'en';
        return [
            '/' => [
                'title' => $en ? 'MMIG46 – Piper PA-46 owners and pilots' : 'MMIG46 – Malibu Mirage Interessengemeinschaft',
                'description' => $en ? 'MMIG46 connects owners and pilots of Piper PA-46 Malibu, Mirage, Meridian and JetPROP aircraft.' : 'MMIG46 e.V. verbindet Halter und Piloten der Piper PA-46 Malibu, Mirage, Meridian und JetPROP.',
                'priority' => '1.0',
                'changefreq' => 'weekly',
            ],
            '/news' => [
                'title' => $en ? 'News – MMIG46' : 'Aktuelles – MMIG46',
                'description' => $en ? 'News from MMIG46 and the Piper PA-46 community.' : 'Aktuelle Meldungen der MMIG46 und aus der Piper-PA-46-Gemeinschaft.',
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ],
            '/reisen' => [
                'title' => $en ? 'Fly-ins and trips – MMIG46' : 'Reisen und Fly-ins – MMIG46',
                'description' => $en ? 'MMIG46 fly-ins, trips and events for the PA-46 community.' : 'Reisen, Fly-ins und Veranstaltungen der MMIG46 für die PA-46-Gemeinschaft.',
                'priority' => '0.8',
                'changefreq' => 'monthly',
            ],
            '/reisen/fly-in-woerthersee-2026' => [
                'title' => 'Fly-in Wörthersee 2026 - MMIG46 e.V.',
                'description' => $en ? 'Review and information about the MMIG46 Wörthersee fly-in 2026.' : 'Rückblick und Informationen zum Fly-in Wörthersee 2026 der MMIG46.',
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ],
            '/malibu-mirage' => [
                'title' => 'Piper PA-46 Malibu Mirage & JetPROP – MMIG46',
                'description' => $en ? 'Technical information and archive articles about Piper PA-46 Malibu, Mirage and JetPROP aircraft.' : 'Fachinformationen und Archivbeiträge zu Piper PA-46 Malibu, Mirage und JetPROP.',
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ],
            '/verein' => [
                'title' => $en ? 'About MMIG46' : 'Verein – MMIG46',
                'description' => $en ? 'About MMIG46, its objectives and activities for Piper PA-46 owners and pilots.' : 'Informationen über MMIG46 e.V., seine Ziele und Aktivitäten für PA-46-Halter und -Piloten.',
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ],
            '/kontakt' => [
                'title' => $en ? 'Contact MMIG46' : 'Kontakt – MMIG46',
                'description' => $en ? 'Contact MMIG46 about the club, PA-46 topics, trips or membership.' : 'Kontakt zur MMIG46 zu Verein, PA-46-Themen, Reisen oder Mitgliedschaft.',
                'priority' => '0.6',
                'changefreq' => 'yearly',
            ],
            '/mitgliedsantrag' => [
                'title' => $en ? 'Membership application – MMIG46' : 'Mitgliedsantrag – MMIG46',
                'description' => $en ? 'Apply for MMIG46 membership. Admission is subject to board approval and payment.' : 'Mitgliedschaft bei MMIG46 beantragen. Aufnahme nach Vorstandsbeschluss und Zahlung.',
                'priority' => '0.5',
                'changefreq' => 'yearly',
            ],
            '/impressum' => [
                'title' => $en ? 'Legal notice – MMIG46' : 'Impressum – MMIG46',
                'description' => $en ? 'Legal notice for the MMIG46 website.' : 'Impressum der Website der MMIG46.',
                'priority' => '0.3',
                'changefreq' => 'yearly',
            ],
            '/datenschutz' => [
                'title' => $en ? 'Privacy policy – MMIG46' : 'Datenschutz – MMIG46',
                'description' => $en ? 'Privacy policy for the MMIG46 website.' : 'Datenschutzerklärung der Website der MMIG46.',
                'priority' => '0.3',
                'changefreq' => 'yearly',
            ],
            '/agb' => [
                'title' => $en ? 'Terms and conditions – MMIG46' : 'AGB – MMIG46',
                'description' => $en ? 'Terms and conditions for use of the MMIG46 website.' : 'Allgemeine Nutzungsbedingungen der MMIG46-Website.',
                'priority' => '0.3',
                'changefreq' => 'yearly',
            ],
        ];
    }

    public static function metaForCurrentRequest(array $overrides = []): array
    {
        $path = self::currentPath();

        $lang = I18n::current();
        $defaults = self::staticPages($lang)[$path] ?? [
            'title' => self::titleFromPath($path),
            'description' => self::DEFAULT_DESCRIPTION,
        ];

        $meta = array_merge($defaults, $overrides);

        $title = trim((string)($meta['title'] ?? self::SITE_NAME));
        $description = trim((string)($meta['description'] ?? self::DEFAULT_DESCRIPTION));

        return [
            'title' => self::limit($title, 65),
            'description' => self::limit($description, 160),
            'canonical' => self::canonicalUrl($path, $lang),
            'alternates' => $meta['alternates'] ?? [
                'de' => self::canonicalUrl($path, 'de'),
                'en' => self::canonicalUrl($path, 'en'),
                'x-default' => self::canonicalUrl($path, 'de'),
            ],
            'robots' => self::robotsDirective($path),
            'og_type' => $path === '/' ? 'website' : 'article',
            'og_image' => self::absoluteUrl('/assets/img/og-default.jpg'),
            'structured_data' => $meta['structured_data'] ?? null,
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

    public static function canonicalUrl(?string $path = null, ?string $lang = null): string
    {
        $path = $path ?? self::currentPath();

        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        $lang = $lang ?? I18n::current();
        return self::absoluteUrl($path) . '?lang=' . rawurlencode($lang);
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
            '/forum',
            '/mitglieder',
            '/memberlist',
            '/passwort-setzen',
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

        foreach (['de','en'] as $lang) foreach (self::staticPages($lang) as $path => $meta) {
            $urls[] = [
                'loc' => self::canonicalUrl($path, $lang),
                'alternates' => ['de'=>self::canonicalUrl($path,'de'),'en'=>self::canonicalUrl($path,'en'),'x-default'=>self::canonicalUrl($path,'de')],
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
