<?php

namespace MMIG46\Controllers;

use MMIG46\Core\Security;
use MMIG46\Core\Session;
use MMIG46\Core\View;
use MMIG46\Models\ForumPost;
use MMIG46\Models\ForumTopic;

final class ForumController
{
    public function index(): string
    {
        return View::render('forum/index', [
            'topics' => ForumTopic::all(),
        ]);
    }

    public function show(string $slug = ''): string
    {
        if ($slug === '') {
            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $slug = basename((string) $path);
        }

        $topic = ForumTopic::findBySlug(rawurldecode($slug));

        if (!$topic) {
            http_response_code(404);
            return View::render('errors/404');
        }

        return View::render('forum/show', [
            'topic' => $topic,
            'posts' => ForumPost::forTopic((int) $topic['id']),
        ]);
    }

    public function create(): string
    {
        Security::requireRole(['admin', 'moderator', 'member']);
        return View::render('forum/create');
    }

    public function store(): string
    {
        Security::requireRole(['admin', 'moderator', 'member']);
        Security::verifyCsrf();

        $title = trim((string) ($_POST['title'] ?? ''));
        $body = trim((string) ($_POST['body'] ?? ''));

        if (mb_strlen($title) < 4 || mb_strlen($body) < 10) {
            Session::flash('error', 'Titel oder Beitrag ist zu kurz.');
            header('Location:/forum/neu');
            exit;
        }

        $slug = ForumTopic::create((int) $_SESSION['user']['id'], $title, $body);

        header('Location:/forum/' . rawurlencode($slug));
        exit;
    }

    public function reply(string $slug = ''): string
    {
        Security::requireRole(['admin', 'moderator', 'member']);
        Security::verifyCsrf();

        if ($slug === '') {
            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $parts = explode('/', trim((string) $path, '/'));
            $slug = $parts[1] ?? '';
        }

        $topic = ForumTopic::findBySlug(rawurldecode($slug));

        if (!$topic) {
            http_response_code(404);
            return View::render('errors/404');
        }

        if ((int) ($topic['is_locked'] ?? 0) === 1) {
            Session::flash('error', 'Dieses Thema ist geschlossen.');
            header('Location:/forum/' . rawurlencode($slug));
            exit;
        }

        $body = trim((string) ($_POST['body'] ?? ''));

        if (mb_strlen($body) < 10) {
            Session::flash('error', 'Antwort ist zu kurz.');
            header('Location:/forum/' . rawurlencode($slug));
            exit;
        }

        ForumPost::create((int) $topic['id'], (int) $_SESSION['user']['id'], $body);

        header('Location:/forum/' . rawurlencode($slug));
        exit;
    }
}