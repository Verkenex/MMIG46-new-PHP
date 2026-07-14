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

            'common.read_more' => 'Mehr erfahren',
            'common.back' => 'Zurück',
            'common.submit' => 'Absenden',
            'common.cancel' => 'Abbrechen',
            'common.required' => 'Pflichtfeld',
            'common.yes' => 'Ja',
            'common.no' => 'Nein',

            'auth.member_only' =>
                'Dieser Bereich ist ausschließlich für eingeloggte Mitglieder verfügbar.',

            'form.required_fields' =>
                'Bitte füllen Sie alle Pflichtfelder aus.',

            'form.invalid_email' =>
                'Bitte geben Sie eine gültige E-Mail-Adresse ein.',

            'form.invalid_csrf' =>
                'Die Sitzung ist abgelaufen. Bitte laden Sie die Seite neu und versuchen Sie es erneut.',

            'form.sent' =>
                'Ihre Nachricht wurde erfolgreich übermittelt.',

            'form.send_failed' =>
                'Die Nachricht konnte nicht versendet werden. Bitte versuchen Sie es später erneut.',

            'training.title' =>
                'MMIG46 Trainingswochenende',

            'training.registration_success' =>
                'Vielen Dank. Ihre Anmeldung wurde an den Organisator übermittelt.',

            'training.registration_error' =>
                'Die Anmeldung konnte nicht übermittelt werden. Bitte versuchen Sie es erneut.',

            'training.capacity_notice' =>
                'Die Kapazitäten sind begrenzt. Es gilt: First come, first served.',
        ],

        'en' => [
            'nav.news' => 'News',
            'nav.travels' => 'Fly-Ins & Trips',
            'nav.malibu' => 'Malibu Mirage',
            'nav.club' => 'About MMIG46',
            'nav.members' => 'Member Directory',
            'nav.forum' => 'Forum',
            'nav.contact' => 'Contact',
            'nav.login' => 'Login',
            'nav.logout' => 'Logout',
            'nav.legal' => 'Legal Notice',
            'nav.privacy' => 'Privacy Policy',
            'nav.terms' => 'Terms & Conditions',

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
            'cookie.accept' => 'Got it',

            'common.read_more' => 'Read more',
            'common.back' => 'Back',
            'common.submit' => 'Submit',
            'common.cancel' => 'Cancel',
            'common.required' => 'Required field',
            'common.yes' => 'Yes',
            'common.no' => 'No',

            'auth.member_only' =>
                'This area is only available to logged-in members.',

            'form.required_fields' =>
                'Please complete all required fields.',

            'form.invalid_email' =>
                'Please enter a valid email address.',

            'form.invalid_csrf' =>
                'Your session has expired. Please reload the page and try again.',

            'form.sent' =>
                'Your message has been submitted successfully.',

            'form.send_failed' =>
                'The message could not be sent. Please try again later.',

            'training.title' =>
                'MMIG46 Training Weekend',

            'training.registration_success' =>
                'Thank you. Your registration has been sent to the organiser.',

            'training.registration_error' =>
                'Your registration could not be submitted. Please try again.',

            'training.capacity_notice' =>
                'Capacity is limited. First come, first served.',
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