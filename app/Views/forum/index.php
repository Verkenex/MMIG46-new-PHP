<?php

use MMIG46\Core\I18n;

$topics = is_array($topics ?? null) ? $topics : [];
$canWrite = (bool) ($canWrite ?? false);

$lang = I18n::current();
$isEnglish = $lang === 'en';

$e = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

$formatDate = static function ($value) use ($lang): string {
    if (empty($value)) {
        return '-';
    }

    $timestamp = strtotime((string) $value);

    if ($timestamp === false) {
        return (string) $value;
    }

    return $lang === 'en'
        ? date('d M Y', $timestamp)
        : date('d.m.Y', $timestamp);
};

$text = $isEnglish
    ? [
        'eyebrow' => 'Forum',
        'title' => 'Exchange for members and PA46 enthusiasts.',
        'intro' => 'Questions, experience reports and information about travelling, operation, technology and club activities.',
        'current_topics' => 'Current topics',
        'overview_intro' => 'Discussions are ordered by the most recent post within each section.',
        'create_topic' => 'Create topic',
        'create_title' => 'Start a discussion',
        'create_text' => 'Share a question, experience or useful information with the community.',
        'login_to_write' => 'Log in to post',
        'login_title' => 'Join the discussion',
        'login_text' => 'Members can create topics and reply after signing in.',
        'empty' => 'There are currently no topics.',
        'topic' => 'Topic',
        'author' => 'Author',
        'replies' => 'Replies',
        'last_post' => 'Last post',
        'unknown' => 'Unknown',
        'current' => 'Current discussions',
    ]
    : [
        'eyebrow' => 'Forum',
        'title' => 'Austausch für Mitglieder und PA46-Interessierte.',
        'intro' => 'Fragen, Erfahrungsberichte und Hinweise rund um Reisen, Betrieb, Technik und Vereinsleben.',
        'current_topics' => 'Aktuelle Themen',
        'overview_intro' => 'Die Diskussionen sind innerhalb der Bereiche nach dem neuesten Beitrag sortiert.',
        'create_topic' => 'Beitrag erstellen',
        'create_title' => 'Neue Diskussion beginnen',
        'create_text' => 'Teilen Sie eine Frage, Erfahrung oder hilfreiche Information mit der Gemeinschaft.',
        'login_to_write' => 'Einloggen zum Schreiben',
        'login_title' => 'Mitdiskutieren',
        'login_text' => 'Mitglieder können nach der Anmeldung neue Themen erstellen und antworten.',
        'empty' => 'Es gibt aktuell noch keine Themen.',
        'topic' => 'Thema',
        'author' => 'Autor',
        'replies' => 'Antworten',
        'last_post' => 'Letzter Beitrag',
        'unknown' => 'Unbekannt',
        'current' => 'Aktuelle Diskussionen',
    ];

?>

<section class="hero hero-compact forum-hero">
    <div class="container">
        <p class="eyebrow">
            <?= $e($text['eyebrow']) ?>
        </p>

        <h1>
            <?= $e($text['title']) ?>
        </h1>

        <p>
            <?= $e($text['intro']) ?>
        </p>
    </div>
</section>

<section class="section forum-index-page">
    <div class="container">
        <div class="card forum-index-card">
            <header class="forum-index-head">
                <p class="eyebrow"><?= $e($text['eyebrow']) ?></p>
                <h2><?= $e($text['current_topics']) ?></h2>
                <p class="forum-index-intro"><?= $e($text['overview_intro']) ?></p>
            </header>

            <aside class="forum-action-panel" aria-label="<?= $e($canWrite ? $text['create_title'] : $text['login_title']) ?>">
                <div class="forum-action-copy">
                    <strong><?= $e($canWrite ? $text['create_title'] : $text['login_title']) ?></strong>
                    <p><?= $e($canWrite ? $text['create_text'] : $text['login_text']) ?></p>
                </div>
                <?php if ($canWrite): ?>
                    <a
                        class="button button-outline"
                        href="<?= $e(I18n::url('/forum/neu')) ?>"
                    >
                        <?= $e($text['create_topic']) ?>
                    </a>
                <?php else: ?>
                    <a
                        class="button button-outline"
                        href="<?= $e(I18n::url('/login')) ?>"
                    >
                        <?= $e($text['login_to_write']) ?>
                    </a>
                <?php endif; ?>
            </aside>

            <?php if ($topics === []): ?>
                <p class="forum-empty-state">
                    <?= $e($text['empty']) ?>
                </p>
            <?php else: ?>
                <div class="table-wrap forum-table-wrap">
                    <table class="forum-table">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <?= $e($text['topic']) ?>
                                </th>

                                <th scope="col">
                                    <?= $e($text['author']) ?>
                                </th>

                                <th scope="col">
                                    <?= $e($text['replies']) ?>
                                </th>

                                <th scope="col">
                                    <?= $e($text['last_post']) ?>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $lastSection = null; ?>
                            <?php foreach ($topics as $topic): ?>
                                <?php
                                $slug = (string) ($topic['slug'] ?? '');
                                $title = (string) ($topic['title'] ?? '');
                                $author = (string) ($topic['author'] ?? $text['unknown']);

                                $replyCount = max(
                                    0,
                                    (int) ($topic['reply_count'] ?? 1) - 1
                                );

                                $lastPostDate = $topic['last_post_at']
                                    ?? $topic['updated_at']
                                    ?? $topic['created_at']
                                    ?? null;
                                $sectionName = (string) ($topic['section_name'] ?? $text['current']);
                                ?>

                                <?php if ($sectionName !== $lastSection): ?>
                                    <tr class="forum-section-row">
                                        <th colspan="4" scope="rowgroup"><?= $e($sectionName) ?></th>
                                    </tr>
                                    <?php $lastSection = $sectionName; ?>
                                <?php endif; ?>

                                <tr>
                                    <td data-label="<?= $e($text['topic']) ?>">
                                        <?php if ($slug !== ''): ?>
                                            <a
                                                href="<?= $e(I18n::url('/forum/' . rawurlencode($slug))) ?>"
                                            >
                                                <?= $e($title) ?>
                                            </a>
                                        <?php else: ?>
                                            <?= $e($title) ?>
                                        <?php endif; ?>
                                    </td>

                                    <td data-label="<?= $e($text['author']) ?>">
                                        <?= $e($author) ?>
                                    </td>

                                    <td data-label="<?= $e($text['replies']) ?>">
                                        <?= $replyCount ?>
                                    </td>

                                    <td data-label="<?= $e($text['last_post']) ?>">
                                        <?= $e($formatDate($lastPostDate)) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
