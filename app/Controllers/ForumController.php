<?php

namespace MMIG46\Controllers;

use MMIG46\Core\View;
use MMIG46\Models\ForumPost;
use MMIG46\Models\ForumTopic;

final class ForumController
{
    public function index(): string
    {
        return View::render('forum/index', [
            'topics' => ForumTopic::all(),
            'canWrite' => $this->canWrite(),
        ]);
    }

    public function show(string $slug = ''): string
    {
        $slug = $this->resolveSlug($slug);
        $topic = ForumTopic::findBySlug($slug);

        if (!$topic) {
            http_response_code(404);
            return View::render('errors/404');
        }

        return View::render('forum/show', [
            'topic' => $topic,
            'posts' => ForumPost::forTopic((int) $topic['id']),
            'canWrite' => $this->canWrite(),
        ]);
    }

    public function create(): string
    {
        if (!$this->canWrite()) {
            header('Location: /login');
            exit;
        }

        return View::render('forum/create');
    }

    public function store(): string
    {
        if (!$this->canWrite()) {
            header('Location: /login');
            exit;
        }

        $title = trim((string) ($_POST['title'] ?? ''));
        $body = trim((string) ($_POST['body'] ?? ''));

        if (mb_strlen($title) < 4 || mb_strlen($body) < 10) {
            header('Location: /forum/neu');
            exit;
        }

        $userId = $this->currentUserId();

        if ($userId <= 0) {
            header('Location: /login');
            exit;
        }

        $slug = ForumTopic::create($userId, $title, $body);

        header('Location: /forum/' . rawurlencode($slug));
        exit;
    }

    public function reply(string $slug = ''): string
    {
        if (!$this->canWrite()) {
            header('Location: /login');
            exit;
        }

        $slug = $this->resolveSlug($slug);
        $topic = ForumTopic::findBySlug($slug);

        if (!$topic) {
            http_response_code(404);
            return View::render('errors/404');
        }

        if ((int) ($topic['is_locked'] ?? 0) === 1) {
            header('Location: /forum/' . rawurlencode($slug));
            exit;
        }

        $body = trim((string) ($_POST['body'] ?? ''));

        if (mb_strlen($body) < 10) {
            header('Location: /forum/' . rawurlencode($slug));
            exit;
        }

        $userId = $this->currentUserId();

        if ($userId <= 0) {
            header('Location: /login');
            exit;
        }

        ForumPost::create((int) $topic['id'], $userId, $body);

        header('Location: /forum/' . rawurlencode($slug));
        exit;
    }

    private function canWrite(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $role = $_SESSION['user']['role'] ?? $_SESSION['role'] ?? null;
        $userId = $this->currentUserId();

        return $userId > 0 && in_array((string) $role, ['admin', 'moderator', 'member'], true);
    }

    private function currentUserId(): int
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return (int) (
            $_SESSION['user']['id']
            ?? $_SESSION['user_id']
            ?? 0
        );
    }

    private function resolveSlug(string $slug): string
    {
        if ($slug !== '') {
            return rawurldecode($slug);
        }

        $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
        $parts = explode('/', trim((string) $path, '/'));

        if (($parts[0] ?? '') === 'forum' && isset($parts[1])) {
            return rawurldecode($parts[1]);
        }

        return '';
    }
}
