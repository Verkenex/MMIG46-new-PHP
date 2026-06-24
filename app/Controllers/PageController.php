<?php

declare(strict_types=1);

namespace MMIG46\Controllers;

use MMIG46\Core\I18n;
use MMIG46\Core\Security;
use MMIG46\Core\Session;
use MMIG46\Core\View;
use MMIG46\Models\ContactRequest;
use MMIG46\Models\ContentPage;
use MMIG46\Models\NewsItem;
use MMIG46\Models\Search;
use MMIG46\Models\SiteSetting;
use MMIG46\Models\TravelItem;
use MMIG46\Services\Mailer;
use MMIG46\Services\Markdown;
use MMIG46\Models\MembershipApplication;

class PageController
{
    public function home(): string
    {
        $lang = I18n::current();

        return View::render('pages/home', [
            'settings' => SiteSetting::allKeyValue(),
            'latestNews' => NewsItem::latest(3, $lang),
            'latestTravels' => TravelItem::latest(3, $lang),
            'lang' => $lang,
        ]);
    }

    public function news(): string
    {
        $lang = I18n::current();

        return View::render('pages/news', [
            'items' => NewsItem::published(50, $lang),
            'lang' => $lang,
        ]);
    }

    public function newsDetail(string $slug = ''): string
    {
        if ($slug === '') {
            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $slug = basename((string) $path);
        }

        $slug = rawurldecode($slug);
        $lang = I18n::current();

        $item = NewsItem::findPublishedBySlug($slug, $lang);

        if (!$item && $lang !== 'de') {
            $item = NewsItem::findPublishedBySlug($slug, 'de');
        }

        if (!$item) {
            http_response_code(404);
            return View::render('errors/404');
        }

        return View::render('pages/news-detail', [
            'item' => $item,
            'bodyHtml' => Markdown::toHtml($item['body'] ?? ''),
            'lang' => $lang,
        ]);
    }

    public function travels(): string
    {
        $lang = I18n::current();

        return View::render('pages/reisen', [
            'items' => TravelItem::published($lang),
            'lang' => $lang,
        ]);
    }

    public function search(): string
    {
        $lang = I18n::current();
        $q = trim((string) ($_GET['q'] ?? ''));

        return View::render('pages/search', [
            'q' => $q,
            'results' => mb_strlen($q) >= 2 ? Search::query($q, $lang, 40) : [],
            'lang' => $lang,
        ]);
    }

    public function travelDetail(string $slug = ''): string
    {
        if ($slug === '') {
            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $slug = basename((string) $path);
        }

        $slug = rawurldecode($slug);
        $lang = I18n::current();

        $staticTravelViews = [
            'fly-in-woerthersee-2026' => 'reisen/fly-in-woerthersee-2026',
        ];

        if (isset($staticTravelViews[$slug])) {
            return $this->renderStaticLocalized($staticTravelViews[$slug]);
        }

        $item = TravelItem::findPublishedBySlug($slug, $lang);

        if (!$item && $lang !== 'de') {
            $item = TravelItem::findPublishedBySlug($slug, 'de');
        }

        if (!$item) {
            http_response_code(404);
            return View::render('errors/404');
        }

        return View::render('pages/travel-detail', [
            'item' => $item,
            'bodyHtml' => Markdown::toHtml($item['body'] ?? ''),
            'lang' => $lang,
        ]);
    }

    public function travelWoerthersee2026(): string
    {
        return $this->renderStaticLocalized('reisen/fly-in-woerthersee-2026');
    }

    public function verein(): string
    {
        return $this->renderStaticLocalized('verein');
    }

    public function malibuMirage(): string
    {
        return $this->renderStaticLocalized('malibu-mirage');
    }

    public function malibuArchiveDetail(string $slug = ''): string
    {
        if ($slug === '') {
            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $slug = basename((string) $path);
        }

        $slug = rawurldecode($slug);

        $articles = [
            'ultimate-piston-single' => [
                'title' => 'The Ultimate Piston Single?',
                'subtitle' => 'By Jeff Schweitzer, Ph.D.',
                'source_label' => 'Archivbeitrag der alten MMIG46-Website',
                'file' => 'ultimate-piston-single.html',
            ],
            'pipers-perfection' => [
                'title' => 'Piper’s Perfection?',
                'subtitle' => 'By Dave Higdon',
                'source_label' => 'Archivbeitrag der alten MMIG46-Website',
                'file' => 'pipers-perfection.html',
            ],
            'optimum-flight-levels' => [
                'title' => 'Optimum Flight Levels',
                'subtitle' => 'By Marcus Bicknell',
                'source_label' => 'Archivbeitrag der alten MMIG46-Website',
                'file' => 'optimum-flight-levels.html',
            ],
            '100th-jetprop' => [
                'title' => 'I picked up the 100th JetPROP',
                'subtitle' => 'By Mac Lewis',
                'source_label' => 'Archivbeitrag der alten MMIG46-Website',
                'file' => '100th-jetprop.html',
            ],
        ];

        if (!isset($articles[$slug])) {
            http_response_code(404);
            return View::render('errors/404');
        }

        $article = $articles[$slug];
        $path = dirname(__DIR__, 2) . '/storage/malibu-archive/' . $article['file'];

        if (!is_file($path)) {
            http_response_code(404);
            return View::render('errors/404');
        }

        $bodyHtml = file_get_contents($path);

        if ($bodyHtml === false) {
            http_response_code(404);
            return View::render('errors/404');
        }

        return View::render('pages/malibu-archive-detail', [
            'article' => $article,
            'bodyHtml' => $bodyHtml,
            'lang' => I18n::current(),
        ]);
    }

    public function impressum(): string
    {
        return $this->renderStaticLocalized('impressum');
    }

    public function datenschutz(): string
    {
        return $this->renderStaticLocalized('datenschutz');
    }

    public function agb(): string
    {
        return $this->renderStaticLocalized('agb');
    }

    public function contentPage(): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $slug = trim((string) $path, '/');

        $reservedStaticSlugs = [
            'verein',
            'malibu-mirage',
            'impressum',
            'datenschutz',
            'agb',
            'kontakt',
            'mitgliedsantrag',
            'reisen',
            'suche',
            'search',
            'news',
        ];

        if (in_array($slug, $reservedStaticSlugs, true)) {
            http_response_code(404);
            return View::render('errors/404');
        }

        $page = ContentPage::findPublishedBySlug($slug);

        if (!$page) {
            http_response_code(404);
            return View::render('errors/404');
        }

        return View::render('pages/content', [
            'page' => $page,
            'bodyHtml' => Markdown::toHtml($page['body'] ?? ''),
            'lang' => I18n::current(),
        ]);
    }

    public function contact(): string
    {
        $captchaLeft = random_int(3, 9);
        $captchaRight = random_int(1, 6);

        $_SESSION['captcha_answer'] = $captchaLeft + $captchaRight;

        return $this->renderStaticLocalized('contact', [
            'captchaQuestion' => $captchaLeft . ' + ' . $captchaRight,
        ]);
    }

    public function sendContact(): string
    {
        Security::verifyCsrf();

        $lang = I18n::current();

        $expected = (int) ($_SESSION['captcha_answer'] ?? 0);
        $given = (int) ($_POST['captcha'] ?? -1);

        if ($expected !== $given) {
            Session::flash(
                'error',
                $lang === 'en'
                    ? 'The security answer is incorrect.'
                    : 'Captcha falsch.'
            );

            header('Location: ' . I18n::url('/kontakt', $lang));
            exit;
        }

        unset($_SESSION['captcha_answer']);

        $name = trim((string) ($_POST['name'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $message = trim((string) ($_POST['message'] ?? ''));

        if ($name === '' || $email === '' || $message === '') {
            Session::flash(
                'error',
                $lang === 'en'
                    ? 'Please complete all required fields.'
                    : 'Bitte alle Pflichtfelder ausfüllen.'
            );

            header('Location: ' . I18n::url('/kontakt', $lang));
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash(
                'error',
                $lang === 'en'
                    ? 'Please enter a valid email address.'
                    : 'Bitte eine gültige E-Mail-Adresse eingeben.'
            );

            header('Location: ' . I18n::url('/kontakt', $lang));
            exit;
        }

        ContactRequest::create($name, $email, $message);

        $mailSent = $this->sendMailSafely($name, $email, $message, 'contact');

        if (!$mailSent) {
            Session::flash(
                'ok',
                $lang === 'en'
                    ? 'Thank you. Your request has been saved. Email notification is currently unavailable.'
                    : 'Danke, Ihre Anfrage wurde gespeichert. Die E-Mail-Benachrichtigung ist derzeit nicht verfügbar.'
            );
        } else {
            Session::flash(
                'ok',
                $lang === 'en'
                    ? 'Thank you. Your request has been saved.'
                    : 'Danke, Ihre Anfrage wurde gespeichert.'
            );
        }

        header('Location: ' . I18n::url('/kontakt', $lang));
        exit;
    }

    public function membershipApplication(): string
    {
        return $this->renderStaticLocalized('mitgliedsantrag');
    }

    public function sendMembershipApplication(): string
    {
        Security::verifyCsrf();

        $lang = I18n::current();

        $data = [
            'membership_type' => trim((string) ($_POST['membership_type'] ?? '')),

            'invoice_name' => trim((string) ($_POST['invoice_name'] ?? '')),
            'street' => trim((string) ($_POST['street'] ?? '')),
            'postal_city_country' => trim((string) ($_POST['postal_city_country'] ?? '')),

            'last_name' => trim((string) ($_POST['last_name'] ?? '')),
            'first_name' => trim((string) ($_POST['first_name'] ?? '')),
            'birthday' => trim((string) ($_POST['birthday'] ?? '')),
            'occupation' => trim((string) ($_POST['occupation'] ?? '')),
            'copilot_spouse' => trim((string) ($_POST['copilot_spouse'] ?? '')),

            'total_time' => trim((string) ($_POST['total_time'] ?? '')),
            'time_in_type' => trim((string) ($_POST['time_in_type'] ?? '')),
            'license_ratings' => trim((string) ($_POST['license_ratings'] ?? '')),
            'flying_since' => trim((string) ($_POST['flying_since'] ?? '')),
            'aviation_history' => trim((string) ($_POST['aviation_history'] ?? '')),

            'registered_owner' => trim((string) ($_POST['registered_owner'] ?? '')),
            'callsign' => trim((string) ($_POST['callsign'] ?? '')),
            'model' => trim((string) ($_POST['model'] ?? '')),
            'serial_number' => trim((string) ($_POST['serial_number'] ?? '')),
            'aircraft_year' => trim((string) ($_POST['aircraft_year'] ?? '')),
            'modifications' => trim((string) ($_POST['modifications'] ?? '')),
            'home_base' => trim((string) ($_POST['home_base'] ?? '')),

            'office_phone' => trim((string) ($_POST['office_phone'] ?? '')),
            'office_email' => trim((string) ($_POST['office_email'] ?? '')),
            'home_phone' => trim((string) ($_POST['home_phone'] ?? '')),
            'private_email' => trim((string) ($_POST['private_email'] ?? '')),
            'mobile' => trim((string) ($_POST['mobile'] ?? '')),

            'consent' => isset($_POST['consent']) ? 'yes' : 'no',
        ];

        if (
            $data['first_name'] === ''
            || $data['last_name'] === ''
            || $data['private_email'] === ''
            || $data['invoice_name'] === ''
            || $data['street'] === ''
            || $data['postal_city_country'] === ''
            || $data['mobile'] === ''
            || $data['consent'] !== 'yes'
        ) {
            Session::flash(
                'error',
                $lang === 'en'
                    ? 'Please complete all required fields, including billing address and mobile number, and confirm your consent.'
                    : 'Bitte alle Pflichtfelder ausfüllen, einschließlich Rechnungsanschrift und Mobilnummer, und die Einwilligung bestätigen.'
            );

            header('Location: ' . I18n::url('/mitgliedsantrag', $lang));
            exit;
        }

        if (!filter_var($data['private_email'], FILTER_VALIDATE_EMAIL)) {
            Session::flash(
                'error',
                $lang === 'en'
                    ? 'Please enter a valid private email address.'
                    : 'Bitte eine gültige private E-Mail-Adresse eingeben.'
            );

            header('Location: ' . I18n::url('/mitgliedsantrag', $lang));
            exit;
        }

        if ($data['office_email'] !== '' && !filter_var($data['office_email'], FILTER_VALIDATE_EMAIL)) {
            Session::flash(
                'error',
                $lang === 'en'
                    ? 'Please enter a valid office email address or leave the field empty.'
                    : 'Bitte eine gültige Büro-E-Mail-Adresse eingeben oder das Feld leer lassen.'
            );

            header('Location: ' . I18n::url('/mitgliedsantrag', $lang));
            exit;
        }

        try {
            MembershipApplication::create($data);
        } catch (\Throwable $e) {
            error_log(
                sprintf(
                    '[MMIG46] Membership application database insert failed: %s in %s:%d',
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine()
                )
            );

            Session::flash(
                'error',
                $lang === 'en'
                    ? 'The membership application could not be saved. Please try again later.'
                    : 'Der Mitgliedsantrag konnte nicht gespeichert werden. Bitte später erneut versuchen.'
            );

            header('Location: ' . I18n::url('/mitgliedsantrag', $lang));
            exit;
        }

        try {
            $mailSent = \MMIG46\Services\Mailer::membershipApplication($data);
        } catch (\Throwable $e) {
            error_log(
                sprintf(
                    '[MMIG46] Membership application mail failed: %s in %s:%d',
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine()
                )
            );

            $mailSent = false;
        }

        if (!$mailSent) {
            Session::flash(
                'ok',
                $lang === 'en'
                    ? 'The membership application has been saved. Email notification is currently unavailable.'
                    : 'Der Mitgliedsantrag wurde gespeichert. Die E-Mail-Benachrichtigung ist derzeit nicht verfügbar.'
            );

            header('Location: ' . I18n::url('/mitgliedsantrag', $lang));
            exit;
        }

        try {
            \MMIG46\Services\Mailer::membershipCopy($data);
        } catch (\Throwable $e) {
            error_log(
                sprintf(
                    '[MMIG46] Membership copy mail failed: %s in %s:%d',
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine()
                )
            );

            Session::flash(
                'ok',
                $lang === 'en'
                    ? 'The membership application has been saved and submitted. However, the confirmation copy could not be sent.'
                    : 'Der Mitgliedsantrag wurde gespeichert und übermittelt. Die Kopie konnte jedoch nicht versendet werden.'
            );

            header('Location: ' . I18n::url('/mitgliedsantrag', $lang));
            exit;
        }

        Session::flash(
            'ok',
            $lang === 'en'
                ? 'The membership application has been saved and submitted. A copy has been sent to your private email address.'
                : 'Der Mitgliedsantrag wurde gespeichert und übermittelt. Eine Kopie wurde an Ihre private E-Mail-Adresse gesendet.'
        );

        header('Location: ' . I18n::url('/mitgliedsantrag', $lang));
        exit;
    }
    
    private function sendMailSafely(string $name, string $email, string $message, string $context): bool
    {
        try {
            Mailer::contact($name, $email, $message);
            return true;
        } catch (\Throwable $e) {
            error_log(
                sprintf(
                    '[MMIG46] Mailer failed in %s: %s in %s:%d',
                    $context,
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine()
                )
            );

            return false;
        }
    }


    private function renderStaticLocalized(string $view, array $data = []): string
    {
        $lang = I18n::current();

        if ($lang === 'en') {
            $englishView = 'pages/en/' . $view;
            $englishPath = dirname(__DIR__) . '/Views/' . $englishView . '.php';

            if (is_file($englishPath)) {
                return View::render($englishView, array_merge($data, [
                    'lang' => $lang,
                ]));
            }
        }

        return View::render('pages/' . $view, array_merge($data, [
            'lang' => $lang,
        ]));
    }
}