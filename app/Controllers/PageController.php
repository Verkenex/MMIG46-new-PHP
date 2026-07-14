<?php

declare(strict_types=1);

namespace MMIG46\Controllers;

use MMIG46\Core\I18n;
use MMIG46\Core\Security;
use MMIG46\Core\Session;
use MMIG46\Core\View;
use MMIG46\Models\ContactRequest;
use MMIG46\Models\ContentPage;
use MMIG46\Models\MembershipApplication;
use MMIG46\Models\NewsItem;
use MMIG46\Models\Search;
use MMIG46\Models\SiteSetting;
use MMIG46\Models\TravelItem;
use MMIG46\Services\Mailer;
use MMIG46\Services\Markdown;

final class PageController
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
            $path = parse_url(
                $_SERVER['REQUEST_URI'] ?? '/',
                PHP_URL_PATH
            );

            $slug = basename((string) $path);
        }

        $slug = rawurldecode($slug);
        $lang = I18n::current();

        $item = NewsItem::findPublishedBySlug($slug, $lang);

        /*
         * Falls ein englischer Inhalt nicht vorhanden ist,
         * wird auf die deutsche Fassung zurückgegriffen.
         */
        if (!$item && $lang !== 'de') {
            $item = NewsItem::findPublishedBySlug($slug, 'de');
        }

        if (!$item) {
            http_response_code(404);

            return View::render('errors/404');
        }

        return View::render('pages/news-detail', [
            'item' => $item,
            'bodyHtml' => Markdown::toHtml(
                (string) ($item['body'] ?? '')
            ),
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

    public function travelDetail(string $slug = ''): string
    {
        if ($slug === '') {
            $path = parse_url(
                $_SERVER['REQUEST_URI'] ?? '/',
                PHP_URL_PATH
            );

            $slug = basename((string) $path);
        }

        $slug = rawurldecode($slug);
        $lang = I18n::current();

        /*
         * Einzelne Reiseberichte können weiterhin als statische
         * PHP-Views gepflegt werden.
         */
        $staticTravelViews = [
            'fly-in-woerthersee-2026' =>
                'reisen/fly-in-woerthersee-2026',
        ];

        if (isset($staticTravelViews[$slug])) {
            return $this->renderStaticLocalized(
                $staticTravelViews[$slug]
            );
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
            'bodyHtml' => Markdown::toHtml(
                (string) ($item['body'] ?? '')
            ),
            'lang' => $lang,
        ]);
    }

    public function travelWoerthersee2026(): string
    {
        return $this->renderStaticLocalized(
            'reisen/fly-in-woerthersee-2026'
        );
    }

    public function search(): string
    {
        $lang = I18n::current();
        $query = trim((string) ($_GET['q'] ?? ''));

        return View::render('pages/search', [
            'q' => $query,
            'results' => mb_strlen($query) >= 2
                ? Search::query($query, $lang, 40)
                : [],
            'lang' => $lang,
        ]);
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
            $path = parse_url(
                $_SERVER['REQUEST_URI'] ?? '/',
                PHP_URL_PATH
            );

            $slug = basename((string) $path);
        }

        $slug = rawurldecode($slug);

        $sourceLabel = I18n::current() === 'en'
            ? 'Archived article from the previous MMIG46 website'
            : 'Archivbeitrag der alten MMIG46-Website';

        $articles = [
            'ultimate-piston-single' => [
                'title' => 'The Ultimate Piston Single?',
                'subtitle' => 'By Jeff Schweitzer, Ph.D.',
                'source_label' => $sourceLabel,
                'file' => 'ultimate-piston-single.html',
            ],
            'pipers-perfection' => [
                'title' => 'Piper’s Perfection?',
                'subtitle' => 'By Dave Higdon',
                'source_label' => $sourceLabel,
                'file' => 'pipers-perfection.html',
            ],
            'optimum-flight-levels' => [
                'title' => 'Optimum Flight Levels',
                'subtitle' => 'By Marcus Bicknell',
                'source_label' => $sourceLabel,
                'file' => 'optimum-flight-levels.html',
            ],
            '100th-jetprop' => [
                'title' => 'I picked up the 100th JetPROP',
                'subtitle' => 'By Mac Lewis',
                'source_label' => $sourceLabel,
                'file' => '100th-jetprop.html',
            ],
        ];

        if (!isset($articles[$slug])) {
            http_response_code(404);

            return View::render('errors/404');
        }

        $article = $articles[$slug];

        $archivePath = dirname(__DIR__, 2)
            . '/storage/malibu-archive/'
            . $article['file'];

        if (!is_file($archivePath)) {
            http_response_code(404);

            return View::render('errors/404');
        }

        $bodyHtml = file_get_contents($archivePath);

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
        $path = parse_url(
            $_SERVER['REQUEST_URI'] ?? '/',
            PHP_URL_PATH
        );

        $slug = trim((string) $path, '/');

        /*
         * Diese Slugs dürfen nicht versehentlich über die dynamischen
         * Content-Seiten ausgeliefert werden.
         */
        $reservedStaticSlugs = [
            'verein',
            'malibu-mirage',
            'impressum',
            'datenschutz',
            'agb',
            'kontakt',
            'mitgliedsantrag',
            'trainingswochenende-2026',
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
            'bodyHtml' => Markdown::toHtml(
                (string) ($page['body'] ?? '')
            ),
            'lang' => I18n::current(),
        ]);
    }

    public function contact(): string
    {
        $captchaLeft = random_int(3, 9);
        $captchaRight = random_int(1, 6);

        $_SESSION['captcha_answer'] =
            $captchaLeft + $captchaRight;

        return $this->renderStaticLocalized('contact', [
            'captchaQuestion' =>
                $captchaLeft . ' + ' . $captchaRight,
        ]);
    }

    public function sendContact(): string
    {
        Security::verifyCsrf();

        $lang = I18n::current();

        $expected = (int) (
            $_SESSION['captcha_answer'] ?? 0
        );

        $given = (int) ($_POST['captcha'] ?? -1);

        if ($expected !== $given) {
            Session::flash(
                'error',
                $lang === 'en'
                    ? 'The security answer is incorrect.'
                    : 'Die Sicherheitsantwort ist nicht korrekt.'
            );

            header(
                'Location: ' . I18n::url('/kontakt', $lang)
            );

            exit;
        }

        unset($_SESSION['captcha_answer']);

        $name = trim((string) ($_POST['name'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $message = trim((string) ($_POST['message'] ?? ''));

        if (
            $name === ''
            || $email === ''
            || $message === ''
        ) {
            Session::flash(
                'error',
                $lang === 'en'
                    ? 'Please complete all required fields.'
                    : 'Bitte füllen Sie alle Pflichtfelder aus.'
            );

            header(
                'Location: ' . I18n::url('/kontakt', $lang)
            );

            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash(
                'error',
                $lang === 'en'
                    ? 'Please enter a valid email address.'
                    : 'Bitte geben Sie eine gültige E-Mail-Adresse ein.'
            );

            header(
                'Location: ' . I18n::url('/kontakt', $lang)
            );

            exit;
        }

        try {
            ContactRequest::create(
                $name,
                $email,
                $message
            );
        } catch (\Throwable $exception) {
            $this->logException(
                'Contact request database insert failed',
                $exception
            );

            Session::flash(
                'error',
                $lang === 'en'
                    ? 'Your request could not be saved. Please try again later.'
                    : 'Ihre Anfrage konnte nicht gespeichert werden. Bitte versuchen Sie es später erneut.'
            );

            header(
                'Location: ' . I18n::url('/kontakt', $lang)
            );

            exit;
        }

        $mailSent = $this->sendMailSafely(
            $name,
            $email,
            $message,
            'contact'
        );

        if ($mailSent) {
            Session::flash(
                'ok',
                $lang === 'en'
                    ? 'Thank you. Your request has been saved and submitted.'
                    : 'Vielen Dank. Ihre Anfrage wurde gespeichert und übermittelt.'
            );
        } else {
            Session::flash(
                'ok',
                $lang === 'en'
                    ? 'Thank you. Your request has been saved. Email notification is currently unavailable.'
                    : 'Vielen Dank. Ihre Anfrage wurde gespeichert. Die E-Mail-Benachrichtigung ist derzeit nicht verfügbar.'
            );
        }

        header(
            'Location: ' . I18n::url('/kontakt', $lang)
        );

        exit;
    }

    public function membershipApplication(): string
    {
        return $this->renderStaticLocalized(
            'mitgliedsantrag'
        );
    }

    public function sendMembershipApplication(): string
    {
        Security::verifyCsrf();

        $lang = I18n::current();

        $data = [
            'membership_type' => trim(
                (string) ($_POST['membership_type'] ?? '')
            ),

            'invoice_name' => trim(
                (string) ($_POST['invoice_name'] ?? '')
            ),
            'street' => trim(
                (string) ($_POST['street'] ?? '')
            ),
            'postal_city_country' => trim(
                (string) (
                    $_POST['postal_city_country'] ?? ''
                )
            ),

            'last_name' => trim(
                (string) ($_POST['last_name'] ?? '')
            ),
            'first_name' => trim(
                (string) ($_POST['first_name'] ?? '')
            ),
            'birthday' => trim(
                (string) ($_POST['birthday'] ?? '')
            ),
            'occupation' => trim(
                (string) ($_POST['occupation'] ?? '')
            ),
            'copilot_spouse' => trim(
                (string) ($_POST['copilot_spouse'] ?? '')
            ),

            'total_time' => trim(
                (string) ($_POST['total_time'] ?? '')
            ),
            'time_in_type' => trim(
                (string) ($_POST['time_in_type'] ?? '')
            ),
            'license_ratings' => trim(
                (string) ($_POST['license_ratings'] ?? '')
            ),
            'flying_since' => trim(
                (string) ($_POST['flying_since'] ?? '')
            ),
            'aviation_history' => trim(
                (string) ($_POST['aviation_history'] ?? '')
            ),

            'registered_owner' => trim(
                (string) ($_POST['registered_owner'] ?? '')
            ),
            'callsign' => strtoupper(
                trim((string) ($_POST['callsign'] ?? ''))
            ),
            'model' => trim(
                (string) ($_POST['model'] ?? '')
            ),
            'serial_number' => trim(
                (string) ($_POST['serial_number'] ?? '')
            ),
            'aircraft_year' => trim(
                (string) ($_POST['aircraft_year'] ?? '')
            ),
            'modifications' => trim(
                (string) ($_POST['modifications'] ?? '')
            ),
            'home_base' => trim(
                (string) ($_POST['home_base'] ?? '')
            ),

            'office_phone' => trim(
                (string) ($_POST['office_phone'] ?? '')
            ),
            'office_email' => trim(
                (string) ($_POST['office_email'] ?? '')
            ),
            'home_phone' => trim(
                (string) ($_POST['home_phone'] ?? '')
            ),
            'private_email' => trim(
                (string) ($_POST['private_email'] ?? '')
            ),
            'mobile' => trim(
                (string) ($_POST['mobile'] ?? '')
            ),

            'consent' => isset($_POST['consent'])
                ? 'yes'
                : 'no',
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
                    ? 'Please complete all required fields, including the billing address and mobile number, and confirm your consent.'
                    : 'Bitte füllen Sie alle Pflichtfelder einschließlich Rechnungsanschrift und Mobilnummer aus und bestätigen Sie die Einwilligung.'
            );

            header(
                'Location: '
                . I18n::url('/mitgliedsantrag', $lang)
            );

            exit;
        }

        if (
            !filter_var(
                $data['private_email'],
                FILTER_VALIDATE_EMAIL
            )
        ) {
            Session::flash(
                'error',
                $lang === 'en'
                    ? 'Please enter a valid private email address.'
                    : 'Bitte geben Sie eine gültige private E-Mail-Adresse ein.'
            );

            header(
                'Location: '
                . I18n::url('/mitgliedsantrag', $lang)
            );

            exit;
        }

        if (
            $data['office_email'] !== ''
            && !filter_var(
                $data['office_email'],
                FILTER_VALIDATE_EMAIL
            )
        ) {
            Session::flash(
                'error',
                $lang === 'en'
                    ? 'Please enter a valid office email address or leave the field empty.'
                    : 'Bitte geben Sie eine gültige Büro-E-Mail-Adresse ein oder lassen Sie das Feld leer.'
            );

            header(
                'Location: '
                . I18n::url('/mitgliedsantrag', $lang)
            );

            exit;
        }

        try {
            MembershipApplication::create($data);
        } catch (\Throwable $exception) {
            $this->logException(
                'Membership application database insert failed',
                $exception
            );

            Session::flash(
                'error',
                $lang === 'en'
                    ? 'The membership application could not be saved. Please try again later.'
                    : 'Der Mitgliedsantrag konnte nicht gespeichert werden. Bitte versuchen Sie es später erneut.'
            );

            header(
                'Location: '
                . I18n::url('/mitgliedsantrag', $lang)
            );

            exit;
        }

        try {
            $mailSent =
                Mailer::membershipApplication($data);
        } catch (\Throwable $exception) {
            $this->logException(
                'Membership application mail failed',
                $exception
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

            header(
                'Location: '
                . I18n::url('/mitgliedsantrag', $lang)
            );

            exit;
        }

        try {
            Mailer::membershipCopy($data);
        } catch (\Throwable $exception) {
            $this->logException(
                'Membership confirmation copy failed',
                $exception
            );

            Session::flash(
                'ok',
                $lang === 'en'
                    ? 'The membership application has been saved and submitted. However, the confirmation copy could not be sent.'
                    : 'Der Mitgliedsantrag wurde gespeichert und übermittelt. Die Bestätigungskopie konnte jedoch nicht versendet werden.'
            );

            header(
                'Location: '
                . I18n::url('/mitgliedsantrag', $lang)
            );

            exit;
        }

        Session::flash(
            'ok',
            $lang === 'en'
                ? 'The membership application has been saved and submitted. A copy has been sent to your private email address.'
                : 'Der Mitgliedsantrag wurde gespeichert und übermittelt. Eine Kopie wurde an Ihre private E-Mail-Adresse gesendet.'
        );

        header(
            'Location: '
            . I18n::url('/mitgliedsantrag', $lang)
        );

        exit;
    }

    public function trainingWeekend(): string
    {
        return $this->renderStaticLocalized(
            'training-weekend'
        );
    }

    public function sendTrainingWeekendRegistration(): string
    {
        Security::verifyCsrf();

        /*
         * Unsichtbares Honeypot-Feld gegen einfache Formular-Bots.
         */
        if (
            trim((string) ($_POST['website'] ?? '')) !== ''
        ) {
            http_response_code(400);

            return '';
        }

        /*
         * Die Sprache wird zusätzlich aus dem Formular übernommen.
         * Das ist wichtig, falls beim POST kein lang-Parameter in der
         * URL enthalten ist.
         */
        $postedLanguage = strtolower(
            trim((string) ($_POST['language'] ?? ''))
        );

        $lang = in_array(
            $postedLanguage,
            ['de', 'en'],
            true
        )
            ? $postedLanguage
            : I18n::current();

        $name = trim(
            (string) ($_POST['name'] ?? '')
        );

        $email = trim(
            (string) ($_POST['email'] ?? '')
        );

        $callsign = strtoupper(
            trim((string) ($_POST['callsign'] ?? ''))
        );

        $aircraftModel = trim(
            (string) ($_POST['aircraft_model'] ?? '')
        );

        $participants = max(
            1,
            min(
                4,
                (int) ($_POST['participants'] ?? 1)
            )
        );

        $notes = trim(
            (string) ($_POST['notes'] ?? '')
        );

        $privacyConsent =
            isset($_POST['privacy_consent']);

        $allowedElements = [
            'fire_training',
            'water_flying_lecture',
            'dinner',
            'ifr_refresher',
            'ifr_meteorology',
            'avionics_lecture',
            'hands_on_training',
            'simulator_training',
            'ifr_check_flight',
            'set_check_flight',
            'garmin_consultation',
            'ras_career_event',
        ];

        $submittedElements =
            $_POST['elements'] ?? [];

        if (!is_array($submittedElements)) {
            $submittedElements = [];
        }

        $submittedElements = array_map(
            static fn (mixed $element): string =>
                (string) $element,
            $submittedElements
        );

        $selectedElements = array_values(
            array_intersect(
                $allowedElements,
                $submittedElements
            )
        );

        if (
            $name === ''
            || $email === ''
            || !filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            )
            || $callsign === ''
            || $selectedElements === []
            || !$privacyConsent
        ) {
            Session::flash(
                'error',
                $lang === 'en'
                    ? 'Please complete all required fields, enter a valid email address and select at least one programme item.'
                    : 'Bitte füllen Sie alle Pflichtfelder aus, geben Sie eine gültige E-Mail-Adresse ein und wählen Sie mindestens einen Programmpunkt.'
            );

            $this->redirectToTrainingWeekend($lang);

            exit;
        }

        $registrationData = [
            'name' => $name,
            'email' => $email,
            'callsign' => $callsign,
            'aircraft_model' => $aircraftModel,
            'participants' => $participants,
            'elements' => $selectedElements,
            'notes' => $notes,
            'privacy_consent' => $privacyConsent,
            'language' => $lang,
        ];

        try {
            $mailSent =
                Mailer::trainingWeekendRegistration(
                    $registrationData
                );
        } catch (\Throwable $exception) {
            $this->logException(
                'Training weekend registration mail failed',
                $exception
            );

            $mailSent = false;
        }

        if (!$mailSent) {
            Session::flash(
                'error',
                $lang === 'en'
                    ? 'Your registration could not be submitted. Please try again later or contact the organiser directly.'
                    : 'Ihre Anmeldung konnte nicht übermittelt werden. Bitte versuchen Sie es später erneut oder kontaktieren Sie den Organisator direkt.'
            );

            $this->redirectToTrainingWeekend($lang);

            exit;
        }

        /*
         * Das Layout liest Erfolgsmeldungen unter dem Key "ok" aus.
         * "success" würde in der aktuellen main.php nicht angezeigt.
         */
        Session::flash(
            'ok',
            $lang === 'en'
                ? 'Thank you. Your registration request has been sent to the organiser. You will be contacted regarding availability.'
                : 'Vielen Dank. Ihre Anmeldeanfrage wurde an den Organisator übermittelt. Sie erhalten eine Rückmeldung zur Verfügbarkeit.'
        );

        $this->redirectToTrainingWeekend($lang);

        exit;
    }

    private function sendMailSafely(
        string $name,
        string $email,
        string $message,
        string $context
    ): bool {
        try {
            return Mailer::contact(
                $name,
                $email,
                $message
            );
        } catch (\Throwable $exception) {
            $this->logException(
                'Mailer failed in ' . $context,
                $exception
            );

            return false;
        }
    }

    private function renderStaticLocalized(
        string $view,
        array $data = []
    ): string {
        $lang = I18n::current();

        if ($lang === 'en') {
            $englishView = 'pages/en/' . $view;

            $englishPath = dirname(__DIR__)
                . '/Views/'
                . $englishView
                . '.php';

            if (is_file($englishPath)) {
                return View::render(
                    $englishView,
                    array_merge(
                        $data,
                        ['lang' => $lang]
                    )
                );
            }
        }

        return View::render(
            'pages/' . $view,
            array_merge(
                $data,
                ['lang' => $lang]
            )
        );
    }

    private function redirectToTrainingWeekend(
        string $lang
    ): never {
        $anchor = $lang === 'en'
            ? '#registration'
            : '#anmeldung';

        header(
            'Location: '
            . I18n::url(
                '/trainingswochenende-2026',
                $lang
            )
            . $anchor
        );

        exit;
    }

    private function logException(
        string $context,
        \Throwable $exception
    ): void {
        error_log(
            sprintf(
                '[MMIG46] %s: %s in %s:%d',
                $context,
                $exception->getMessage(),
                $exception->getFile(),
                $exception->getLine()
            )
        );
    }
}