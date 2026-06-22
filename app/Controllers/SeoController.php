<?php

declare(strict_types=1);

namespace MMIG46\Controllers;

use MMIG46\Core\DB;
use MMIG46\Core\Seo;
use MMIG46\Core\Env;

final class SeoController
{
    public function robots(): string
    {
        header('Content-Type: text/plain; charset=utf-8');

        $base = rtrim((string) Env::get('APP_URL', 'https://www.mmig46.de'), '/');

        return implode("\n", [
            'User-agent: *',
            'Allow: /',
            'Disallow: /verwaltung',
            'Disallow: /login',
            'Disallow: /logout',
            'Disallow: /suche',
            'Disallow: /search',
            'Disallow: /forum/neu',
            '',
            'Sitemap: ' . $base . '/sitemap.xml',
            '',
        ]);
    }

    public function sitemap(): string
    {
        header('Content-Type: application/xml; charset=utf-8');

        $urls = Seo::sitemapStaticUrls();

        foreach ($this->newsUrls() as $url) {
            $urls[] = $url;
        }

        foreach ($this->travelUrls() as $url) {
            $urls[] = $url;
        }

        $xml = [];
        $xml[] = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url) {
            $xml[] = '  <url>';
            $xml[] = '    <loc>' . $this->xml($url['loc']) . '</loc>';

            if (!empty($url['lastmod'])) {
                $xml[] = '    <lastmod>' . $this->xml($url['lastmod']) . '</lastmod>';
            }

            if (!empty($url['changefreq'])) {
                $xml[] = '    <changefreq>' . $this->xml($url['changefreq']) . '</changefreq>';
            }

            if (!empty($url['priority'])) {
                $xml[] = '    <priority>' . $this->xml($url['priority']) . '</priority>';
            }

            $xml[] = '  </url>';
        }

        $xml[] = '</urlset>';

        return implode("\n", $xml);
    }

    private function newsUrls(): array
    {
        try {
            $stmt = DB::pdo()->query("
                SELECT slug, COALESCE(updated_at, published_at, created_at) AS lastmod
                FROM news_items
                WHERE slug IS NOT NULL
                  AND slug <> ''
                ORDER BY COALESCE(updated_at, published_at, created_at) DESC
            ");

            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            return [];
        }

        $urls = [];

        foreach ($rows as $row) {
            $urls[] = [
                'loc' => Seo::canonicalUrl('/news/' . $row['slug']),
                'lastmod' => $this->dateOnly($row['lastmod'] ?? null),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        }

        return $urls;
    }

    private function travelUrls(): array
    {
        try {
            $stmt = DB::pdo()->query("
                SELECT slug, COALESCE(updated_at, starts_at, created_at) AS lastmod
                FROM travel_items
                WHERE slug IS NOT NULL
                  AND slug <> ''
                ORDER BY COALESCE(updated_at, starts_at, created_at) DESC
            ");

            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            return [];
        }

        $urls = [];

        foreach ($rows as $row) {
            $urls[] = [
                'loc' => Seo::canonicalUrl('/reisen/' . $row['slug']),
                'lastmod' => $this->dateOnly($row['lastmod'] ?? null),
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        }

        return $urls;
    }

    private function dateOnly(?string $value): string
    {
        if (!$value) {
            return date('Y-m-d');
        }

        $timestamp = strtotime($value);

        if ($timestamp === false) {
            return date('Y-m-d');
        }

        return date('Y-m-d', $timestamp);
    }

    private function xml(string $value): string
    {
        return htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
}