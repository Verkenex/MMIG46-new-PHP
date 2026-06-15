<?php

namespace MMIG46\Controllers;

use MMIG46\Core\Security;
use MMIG46\Core\Session;
use MMIG46\Core\View;
use MMIG46\Models\ContentPage;
use MMIG46\Models\NewsItem;
use MMIG46\Models\SiteSetting;
use MMIG46\Models\TravelItem;
use MMIG46\Services\Mailer;
use MMIG46\Services\Markdown;
use MMIG46\Models\ContactRequest;

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

    public function travels(): string
    {
        return View::render('pages/reisen', [
            'items' => TravelItem::published(),
        ]);
    }

    public function contentPage(): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $slug = trim($path, '/');

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
        $_SESSION['captcha'] = random_int(3, 9) + random_int(1, 6);

        return View::render('pages/contact', [
            'captcha' => $_SESSION['captcha'],
        ]);
    }

    public function sendContact(): string
    {
        Security::verifyCsrf();

        $expected = (int)($_SESSION['captcha'] ?? 0);
        $given = (int)($_POST['captcha'] ?? -1);

        if ($expected !== $given) {
            Session::flash('error', 'Captcha falsch.');
            header('Location:/kontakt');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');

        ContactRequest::create($name, $email, $message);
        Mailer::contact($name, $email, $message);

        Session::flash('success', 'Danke, Ihre Anfrage wurde gespeichert.');
        header('Location:/kontakt');
        exit;
    }
}