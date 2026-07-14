<?php

use MMIG46\Core\I18n;

$topics = $topics ?? [];
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
        ? date('d M Y', $timestamp)
        : date('d.m.Y', $timestamp);
};

$text = $isEnglish
    ? [
        'eyebrow' => 'Forum',
        'title' => 'Exchange for members and PA46 enthusiasts.',
        'intro' => 'Questions, experience reports and information about travelling, operation, technology and club activities.',
        'current_topics' => 'Current topics',
        'create_topic' => 'Create topic',
        'login_to_write' => 'Log in to post',
        'empty' => 'There are currently no topics.',
        'topic' => 'Topic',
        'author' => 'Author',
        'replies' => 'Replies',
        'last_post' => 'Last post',
        'unknown' => 'Unknown',
    ]
    : [
        'eyebrow' => 'Forum',
        'title' => 'Austausch für Mitglieder und PA46-Interessierte.',
        'intro' => 'Fragen, Erfahrungsberichte und Hinweise rund um Reisen, Betrieb, Technik und Vereinsleben.',
        'current_topics' => 'Aktuelle Themen',
        'create_topic' => 'Beitrag erstellen',
        'login_to_write' => 'Einloggen zum Schreiben',
        'empty' => 'Es gibt aktuell noch keine Themen.',
        'topic' => 'Thema',
        'author' => 'Autor',
        'replies' => 'Antworten',
        'last_post' => 'Letzter Beitrag',
        'unknown' => 'Unbekannt',
    ];

?>

<section class="hero hero-compact">
    <div class="container">
        <p class="eyebrow"><?= $e($text['eyebrow']) ?></p>
        <h1><?= $e($text['title']) ?></h1>
        <p><?= $e($text['intro']) ?></p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="card">
            <div class="section-head">
                <h2><?= $e($text['current_topics']) ?></h2>

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
            </div>

            <?php if (empty($topics)): ?>
                <p><?= $e($text['empty']) ?></p>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="forum-table">
                        <thead>
                            <tr>
                                <th><?= $e($text['topic']) ?></th>
                                <th><?= $e($text['author']) ?></th>
                                <th><?= $e($text['replies']) ?></th>
                                <th><?= $e($text['last_post']) ?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($topics as $topic): ?>
                                <tr>
                                    <td>
                                        <a href="<?= $e(I18n::url('/forum/' . $topic['slug'])) ?>">
                                            <?= $e($topic['title']) ?>
                                        </a>
                                    </td>

                                    <td>
                                        <?= $e($topic['author'] ?? $text['unknown']) ?>
                                    </td>

                                    <td>
                                        <?= max(0, (int) ($topic['reply_count'] ?? 1) - 1) ?>
                                    </td>

                                    <td>
                                        <?= $e(
                                            $formatDate(
                                                $topic['updated_at']
                                                ?: $topic['created_at']
                                            )
                                        ) ?>
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