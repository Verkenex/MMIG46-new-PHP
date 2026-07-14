<?php

use MMIG46\Core\I18n;
use MMIG46\Core\Security;

$topic = $topic ?? null;
$posts = $posts ?? [];
$canWrite = (bool) ($canWrite ?? false);

$lang = I18n::current();
$isEnglish = $lang === 'en';

$e = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

$formatDate = static function ($value) use ($lang): string {
    if (!$value) {
        return '-';
    }

    $timestamp = strtotime((string) $value);

    if (!$timestamp) {
        return (string) $value;
    }

    return $lang === 'en'
        ? date('d M Y, H:i', $timestamp)
        : date('d.m.Y H:i', $timestamp);
};

$renderForumText = static function ($value) use ($e): string {
    $text = (string) $value;
    $html = $e($text);

    $html = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $html);
    $html = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $html);
    $html = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $html);

    $blocks = preg_split("/\n{2,}/", trim((string) $html));
    $output = [];

    foreach ($blocks as $block) {
        $block = trim((string) $block);

        if ($block === '') {
            continue;
        }

        if (
            str_starts_with($block, '<h2>')
            || str_starts_with($block, '<h3>')
        ) {
            $output[] = $block;
            continue;
        }

        if (preg_match('/^- /m', $block)) {
            $items = preg_split('/\n/', $block);
            $listItems = [];

            foreach ($items as $item) {
                $item = trim((string) $item);

                if (str_starts_with($item, '- ')) {
                    $listItems[] = '<li>' . substr($item, 2) . '</li>';
                }
            }

            if ($listItems !== []) {
                $output[] = '<ul>' . implode('', $listItems) . '</ul>';
            }

            continue;
        }

        $output[] = '<p>' . nl2br($block) . '</p>';
    }

    return implode("\n", $output);
};

$text = $isEnglish
    ? [
        'eyebrow' => 'Forum',
        'not_found_title' => 'Topic not found',
        'not_found_text' => 'The requested forum topic does not exist or has been removed.',
        'by' => 'By',
        'unknown' => 'Unknown',
        'back' => 'Back to forum overview',
        'locked_title' => 'Topic closed',
        'locked_text' => 'No further replies can be posted to this topic.',
        'reply_title' => 'Post a reply',
        'reply_label' => 'Reply',
        'reply_button' => 'Publish reply',
        'login_title' => 'Would you like to reply?',
        'login_text' => 'Please log in with a member account to post a reply.',
        'login_button' => 'Log in',
    ]
    : [
        'eyebrow' => 'Forum',
        'not_found_title' => 'Thema nicht gefunden',
        'not_found_text' => 'Das angeforderte Forumsthema existiert nicht oder wurde entfernt.',
        'by' => 'Von',
        'unknown' => 'Unbekannt',
        'back' => 'Zurück zur Übersicht',
        'locked_title' => 'Thema geschlossen',
        'locked_text' => 'Zu diesem Thema können keine weiteren Antworten geschrieben werden.',
        'reply_title' => 'Antwort schreiben',
        'reply_label' => 'Antwort',
        'reply_button' => 'Antwort veröffentlichen',
        'login_title' => 'Sie möchten antworten?',
        'login_text' => 'Bitte melden Sie sich mit einem Mitgliederkonto an, um eine Antwort zu schreiben.',
        'login_button' => 'Einloggen',
    ];

?>

<section class="hero hero-compact">
    <div class="container forum-page-narrow">
        <p class="eyebrow"><?= $e($text['eyebrow']) ?></p>

        <?php if (!$topic): ?>
            <h1><?= $e($text['not_found_title']) ?></h1>
            <p><?= $e($text['not_found_text']) ?></p>
        <?php else: ?>
            <h1><?= $e($topic['title']) ?></h1>

            <p>
                <?= $e($text['by']) ?>
                <?= $e($topic['author'] ?? $text['unknown']) ?>
                ·
                <?= $e($formatDate($topic['created_at'] ?? null)) ?>
            </p>
        <?php endif; ?>
    </div>
</section>

<section class="section">
    <div class="container forum-page-narrow">
        <p class="back-link">
            <a href="<?= $e(I18n::url('/forum')) ?>">
                ← <?= $e($text['back']) ?>
            </a>
        </p>

        <?php if ($topic): ?>
            <div class="forum-thread">
                <?php foreach ($posts as $post): ?>
                    <article class="card forum-card forum-post">
                        <div class="forum-post-meta">
                            <strong>
                                <?= $e($post['author'] ?? $text['unknown']) ?>
                            </strong>

                            <span>
                                · <?= $e($formatDate($post['created_at'] ?? null)) ?>
                            </span>
                        </div>

                        <div class="forum-post-body">
                            <?= $renderForumText($post['body'] ?? '') ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php if ((int) ($topic['is_locked'] ?? 0) === 1): ?>
                <div class="card forum-card">
                    <h2><?= $e($text['locked_title']) ?></h2>
                    <p><?= $e($text['locked_text']) ?></p>
                </div>

            <?php elseif ($canWrite): ?>
                <div class="card forum-card forum-form-card">
                    <h2><?= $e($text['reply_title']) ?></h2>

                    <form
                        method="post"
                        action="<?= $e(
                            I18n::url(
                                '/forum/' . $topic['slug'] . '/antwort'
                            )
                        ) ?>"
                        class="form-stack"
                    >
                        <?= Security::csrfField() ?>

                        <div class="form-field">
                            <label for="body">
                                <?= $e($text['reply_label']) ?>
                            </label>

                            <textarea
                                id="body"
                                name="body"
                                rows="8"
                                required
                            ></textarea>
                        </div>

                        <div class="form-actions">
                            <button class="button" type="submit">
                                <?= $e($text['reply_button']) ?>
                            </button>
                        </div>
                    </form>
                </div>

            <?php else: ?>
                <div class="card forum-card">
                    <h2><?= $e($text['login_title']) ?></h2>
                    <p><?= $e($text['login_text']) ?></p>

                    <a
                        class="button button-outline"
                        href="<?= $e(I18n::url('/login')) ?>"
                    >
                        <?= $e($text['login_button']) ?>
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>