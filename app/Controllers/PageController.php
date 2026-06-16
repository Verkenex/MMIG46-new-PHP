<?php

namespace MMIG46\Controllers;

use MMIG46\Core\Security;
use MMIG46\Core\Session;
use MMIG46\Core\View;
use MMIG46\Models\ContactRequest;
use MMIG46\Models\ContentPage;
use MMIG46\Models\NewsItem;
use MMIG46\Models\SiteSetting;
use MMIG46\Models\TravelItem;
use MMIG46\Services\Mailer;
use MMIG46\Services\Markdown;

class PageController
{
    public function home(): string
    {
        return View::render('pages/home', [
            'settings' => SiteSetting::allKeyValue(),
            'latestNews' => NewsItem::latest(3),
            'latestTravels' => TravelItem::latest(3),
        ]);
    }

    public function news(): string
    {
        return View::render('pages/news', [
            'items' => NewsItem::published(50),
        ]);
    }

    public function newsDetail(string $slug = ''): string
    {
        if ($slug === '') {
            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $slug = basename((string)$path);
        }

        $slug = rawurldecode($slug);

        $item = NewsItem::findPublishedBySlug($slug);

        if (!$item) {
            http_response_code(404);
            return View::render('errors/404');
        }

        return View::render('pages/news-detail', [
            'item' => $item,
            'bodyHtml' => Markdown::toHtml($item['body'] ?? ''),
        ]);
    }

    public function travels(): string
    {
        return View::render('pages/reisen', [
            'items' => TravelItem::published(),
        ]);
    }

    public function travelDetail(string $slug = ''): string
    {
        if ($slug === '') {
            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $slug = basename((string) $path);
        }

        $slug = rawurldecode($slug);

        $item = TravelItem::findPublishedBySlug($slug);

        if (!$item) {
            http_response_code(404);
            return View::render('errors/404');
        }

        return View::render('pages/reisen-detail', [
            'item' => $item,
            'bodyHtml' => Markdown::toHtml($item['body'] ?? ''),
        ]);
    }

    public function verein(): string
    {
        return View::render('pages/verein');
    }

    public function malibuMirage(): string
{
    return View::render('pages/malibu-mirage');
}

public function malibuArchiveDetail(string $slug = ''): string
{
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
    ]);
}


    public function impressum(): string
    {
        return View::render('pages/impressum');
    }

    public function datenschutz(): string
    {
        return View::render('pages/datenschutz');
    }

    public function agb(): string
    {
        return View::render('pages/agb');
    }

    public function contentPage(): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $slug = trim((string)$path, '/');
                if (in_array($slug, ['verein', 'impressum', 'datenschutz', 'agb'], true)) {
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
        ]);
    }

    public function contact(): string
    {
        $captchaLeft = random_int(3, 9);
        $captchaRight = random_int(1, 6);

        $_SESSION['captcha_answer'] = $captchaLeft + $captchaRight;

        return View::render('pages/contact', [
            'captchaQuestion' => $captchaLeft . ' + ' . $captchaRight,
        ]);
    }

    public function sendContact(): string
    {
        Security::verifyCsrf();

        $expected = (int)($_SESSION['captcha_answer'] ?? 0);
        $given = (int)($_POST['captcha'] ?? -1);

        if ($expected !== $given) {
            Session::flash('error', 'Captcha falsch.');
            header('Location:/kontakt');
            exit;
        }
        unset($_SESSION['captcha_answer']);

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');

        ContactRequest::create($name, $email, $message);
        Mailer::contact($name, $email, $message);

        Session::flash('success', 'Danke, Ihre Anfrage wurde gespeichert.');
        header('Location:/kontakt');
        exit;
    }

    public function membershipApplication(): string
    {
        return View::render('pages/mitgliedsantrag');
    }

    public function sendMembershipApplication(): string
    {
        Security::verifyCsrf();

        $data = [
            'membership_type' => trim($_POST['membership_type'] ?? ''),
            'invoice_name' => trim($_POST['invoice_name'] ?? ''),
            'street' => trim($_POST['street'] ?? ''),
            'postal_city_country' => trim($_POST['postal_city_country'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'first_name' => trim($_POST['first_name'] ?? ''),
            'birthday' => trim($_POST['birthday'] ?? ''),
            'occupation' => trim($_POST['occupation'] ?? ''),
            'copilot_spouse' => trim($_POST['copilot_spouse'] ?? ''),
            'total_time' => trim($_POST['total_time'] ?? ''),
            'time_in_type' => trim($_POST['time_in_type'] ?? ''),
            'license_ratings' => trim($_POST['license_ratings'] ?? ''),
            'flying_since' => trim($_POST['flying_since'] ?? ''),
            'aviation_history' => trim($_POST['aviation_history'] ?? ''),
            'registered_owner' => trim($_POST['registered_owner'] ?? ''),
            'callsign' => trim($_POST['callsign'] ?? ''),
            'model' => trim($_POST['model'] ?? ''),
            'serial_number' => trim($_POST['serial_number'] ?? ''),
            'aircraft_year' => trim($_POST['aircraft_year'] ?? ''),
            'modifications' => trim($_POST['modifications'] ?? ''),
            'home_base' => trim($_POST['home_base'] ?? ''),
            'office_phone' => trim($_POST['office_phone'] ?? ''),
            'office_email' => trim($_POST['office_email'] ?? ''),
            'home_phone' => trim($_POST['home_phone'] ?? ''),
            'private_email' => trim($_POST['private_email'] ?? ''),
            'mobile' => trim($_POST['mobile'] ?? ''),
            'consent' => isset($_POST['consent']) ? 'yes' : 'no',
        ];

        if (
            $data['first_name'] === ''
            || $data['last_name'] === ''
            || $data['private_email'] === ''
            || $data['consent'] !== 'yes'
        ) {
            Session::flash('error', 'Bitte Pflichtfelder ausfüllen und Einwilligung bestätigen.');
            header('Location:/mitgliedsantrag');
            exit;
        }

        $message = "Neuer Mitgliedsantrag:\n\n" . print_r($data, true);

        Mailer::contact(
            $data['first_name'] . ' ' . $data['last_name'],
            $data['private_email'],
            $message
        );

        Session::flash('success', 'Der Mitgliedsantrag wurde übermittelt. Sie können ihn zusätzlich ausdrucken.');
        header('Location:/mitgliedsantrag');
        exit;
    }
}