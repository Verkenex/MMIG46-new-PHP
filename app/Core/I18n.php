<?php

declare(strict_types=1);

namespace MMIG46\Core;

final class I18n
{
    private const SUPPORTED = ['de', 'en'];
    private const DEFAULT_LANG = 'de';

    private static array $messages = [
        'de' => [
            'nav.news' => 'News',
            'nav.travels' => 'Reisen',
            'nav.malibu' => 'Malibu Mirage',
            'nav.club' => 'Verein',
            'nav.members' => 'Mitglieder',
            'nav.forum' => 'Forum',
            'nav.contact' => 'Kontakt',
            'nav.login' => 'Login',
            'nav.logout' => 'Logout',
            'nav.legal' => 'Impressum',
            'nav.privacy' => 'Datenschutz',
            'nav.terms' => 'AGB',

            'search.placeholder' => 'Website durchsuchen',
            'search.button' => 'Suchen',
            'search.title' => 'Suche',
            'search.results_for' => 'Suchergebnisse für',
            'search.no_results' => 'Keine Treffer gefunden.',
            'search.min_length' => 'Bitte geben Sie mindestens zwei Zeichen ein.',
            'search.type.news' => 'News',
            'search.type.travel' => 'Reise',
            'search.type.page' => 'Seite',
            'search.type.forum' => 'Forum',

            'language.label' => 'Sprache',
            'language.de' => 'Deutsch',
            'language.en' => 'English',

            'cookie.text' => 'Diese Website verwendet notwendige Session-Cookies. Mehr Informationen finden Sie in der Datenschutzerklärung.',
            'cookie.accept' => 'Verstanden',
        ],

        'en' => [
            'nav.news' => 'News',
            'nav.travels' => 'Travels',
            'nav.malibu' => 'Malibu Mirage',
            'nav.club' => 'Club',
            'nav.members' => 'Members',
            'nav.forum' => 'Forum',
            'nav.contact' => 'Contact',
            'nav.login' => 'Login',
            'nav.logout' => 'Logout',
            'nav.legal' => 'Legal Notice',
            'nav.privacy' => 'Privacy Policy',
            'nav.terms' => 'Terms',

            'search.placeholder' => 'Search website',
            'search.button' => 'Search',
            'search.title' => 'Search',
            'search.results_for' => 'Search results for',
            'search.no_results' => 'No results found.',
            'search.min_length' => 'Please enter at least two characters.',
            'search.type.news' => 'News',
            'search.type.travel' => 'Travel',
            'search.type.page' => 'Page',
            'search.type.forum' => 'Forum',

            'language.label' => 'Language',
            'language.de' => 'Deutsch',
            'language.en' => 'English',

            'cookie.text' => 'This website only uses necessary session cookies. More information is available in the privacy policy.',
            'cookie.accept' => 'Understood',
        ],
    ];

    public static function current(): string
    {
        $requested = $_GET['lang'] ?? null;

        if (is_string($requested) && in_array($requested, self::SUPPORTED, true)) {
            self::set($requested);
            return $requested;
        }

        $sessionLang = $_SESSION['lang'] ?? null;

        if (is_string($sessionLang) && in_array($sessionLang, self::SUPPORTED, true)) {
            return $sessionLang;
        }

        return self::DEFAULT_LANG;
    }

    public static function set(string $lang): void
    {
        if (!in_array($lang, self::SUPPORTED, true)) {
            return;
        }

        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION['lang'] = $lang;
        }
    }

    public static function supported(): array
    {
        return self::SUPPORTED;
    }

    public static function t(string $key): string
    {
        $lang = self::current();

        return self::$messages[$lang][$key]
            ?? self::$messages[self::DEFAULT_LANG][$key]
            ?? $key;
    }

    public static function url(string $path, ?string $lang = null, array $extraQuery = []): string
    {
        $lang = $lang ?: self::current();

        $parts = parse_url($path);
        $cleanPath = (string)($parts['path'] ?? '/');

        $query = [];
        if (!empty($parts['query'])) {
            parse_str($parts['query'], $query);
        }

        $query = array_merge($query, $extraQuery);
        $query['lang'] = $lang;

        return $cleanPath . '?' . http_build_query($query);
    }

    public static function languageUrl(string $targetLang): string
    {
        if (!in_array($targetLang, self::SUPPORTED, true)) {
            $targetLang = self::DEFAULT_LANG;
        }

        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

        $query = $_GET;
        unset($query['lang']);
        $query['lang'] = $targetLang;

        return $path . '?' . http_build_query($query);
    }
}