<?php

declare(strict_types=1);

namespace MMIG46\Controllers;

use MMIG46\Core\I18n;
use MMIG46\Core\Security;
use MMIG46\Core\Session;
use MMIG46\Core\View;
use MMIG46\Models\ForumPost;
use MMIG46\Models\ForumTopic;
use MMIG46\Models\ForumAttachment;

final class ForumController
{
    public function index(): string
    {
        return View::render('forum/index', [
            'topics' => ForumTopic::all($this->currentRole()),
            'canWrite' => $this->canWrite(),
            'lang' => I18n::current(),
        ]);
    }

    public function show(string $slug = ''): string
    {
        $slug = $this->resolveSlug($slug);
        $topic = ForumTopic::findBySlug($slug, $this->currentRole());

        if (!$topic) {
            http_response_code(404);
            return View::render('errors/404', [
                'lang' => I18n::current(),
            ]);
        }

        return View::render('forum/show', [
            'topic' => $topic,
            'posts' => ForumPost::forTopic((int) $topic['id']),
            'attachments' => ForumAttachment::forTopic((int) $topic['id']),
            'canWrite' => $this->canWrite(),
            'lang' => I18n::current(),
        ]);
    }

    public function create(): string
    {
        Security::requireRole(['admin', 'moderator', 'member']);

        return View::render('forum/create', [
            'lang' => I18n::current(),
        ]);
    }

    public function store(): string
    {
        Security::requireRole(['admin', 'moderator', 'member']);
        Security::verifyCsrf();

        $lang = I18n::current();
        $title = trim((string) ($_POST['title'] ?? ''));
        $body = trim((string) ($_POST['body'] ?? ''));

        if (mb_strlen($title) < 4 || mb_strlen($body) < 10) {
            Session::flash('error', I18n::t('forum.too_short'));
            header('Location: ' . I18n::url('/forum/neu', $lang));
            exit;
        }

        $userId = $this->currentUserId();

        if ($userId <= 0) {
            header('Location: ' . I18n::url('/login', $lang));
            exit;
        }

        $slug = ForumTopic::create($userId, $title, $body);

        header(
            'Location: '
            . I18n::url('/forum/' . rawurlencode($slug), $lang)
        );
        exit;
    }

    public function reply(string $slug = ''): string
    {
        Security::requireRole(['admin', 'moderator', 'member']);
        Security::verifyCsrf();

        $lang = I18n::current();
        $slug = $this->resolveSlug($slug);
        $topic = ForumTopic::findBySlug($slug, $this->currentRole());

        if (!$topic) {
            http_response_code(404);
            return View::render('errors/404', [
                'lang' => $lang,
            ]);
        }

        if ((int) ($topic['is_locked'] ?? 0) === 1) {
            header(
                'Location: '
                . I18n::url('/forum/' . rawurlencode($slug), $lang)
            );
            exit;
        }

        $body = trim((string) ($_POST['body'] ?? ''));

        if (mb_strlen($body) < 10) {
            Session::flash('error', I18n::t('forum.reply_too_short'));

            header(
                'Location: '
                . I18n::url('/forum/' . rawurlencode($slug), $lang)
                . '#reply'
            );
            exit;
        }

        $userId = $this->currentUserId();

        if ($userId <= 0) {
            header('Location: ' . I18n::url('/login', $lang));
            exit;
        }

        ForumPost::create((int) $topic['id'], $userId, $body);

        header(
            'Location: '
            . I18n::url('/forum/' . rawurlencode($slug), $lang)
            . '#posts'
        );
        exit;
    }

    private function canWrite(): bool
    {
        $role = $_SESSION['user']['role'] ?? null;

        return $this->currentUserId() > 0
            && in_array(
                (string) $role,
                ['admin', 'moderator', 'member'],
                true
            );
    }

    private function currentUserId(): int
    {
        return (int) ($_SESSION['user']['id'] ?? 0);
    }

    public function attachment(string $id = ''): string
    {
        $attachment = ForumAttachment::findAccessible((int) $id, $this->currentRole());
        if (!$attachment) {
            http_response_code(404);
            return View::render('errors/404', ['lang' => I18n::current()]);
        }

        $storedName = (string) ($attachment['stored_name'] ?? '');
        if (!preg_match('/\A[a-f0-9]{64}\z/', $storedName)) {
            http_response_code(404);
            return View::render('errors/404', ['lang' => I18n::current()]);
        }

        $path = dirname(__DIR__, 2) . '/storage/forum-attachments/' . $storedName;
        if (!is_file($path)) {
            http_response_code(404);
            return View::render('errors/404', ['lang' => I18n::current()]);
        }

        $filename = str_replace(["\r", "\n", '"'], '', (string) $attachment['original_name']);
        $mimeType = strtolower((string) ($attachment['mime_type'] ?? ''));
        if (!preg_match('/\A[a-z0-9.+-]+\/[a-z0-9.+-]+\z/', $mimeType)) {
            $mimeType = 'application/octet-stream';
        }

        $inlineMimeTypes = [
            'application/pdf',
            'image/gif',
            'image/jpeg',
            'image/png',
            'image/webp',
        ];
        $disposition = in_array($mimeType, $inlineMimeTypes, true)
            ? 'inline'
            : 'attachment';

        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . (string) filesize($path));
        header(
            "Content-Disposition: {$disposition}; filename*=UTF-8''"
            . rawurlencode($filename)
        );
        header('X-Content-Type-Options: nosniff');
        readfile($path);
        return '';
    }

    private function currentRole(): ?string
    {
        $role = $_SESSION['user']['role'] ?? null;
        return is_string($role) ? $role : null;
    }

    private function resolveSlug(string $slug): string
    {
        if ($slug !== '') {
            return rawurldecode($slug);
        }

        $path = parse_url(
            $_SERVER['REQUEST_URI'] ?? '',
            PHP_URL_PATH
        );

        $parts = explode('/', trim((string) $path, '/'));

        if (($parts[0] ?? '') === 'forum' && isset($parts[1])) {
            return rawurldecode($parts[1]);
        }

        return '';
    }
}
