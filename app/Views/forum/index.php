<?php

use MMIG46\Core\I18n;
use MMIG46\Core\Security;

$topics = $topics ?? [];
$canWrite = (bool) ($canWrite ?? false);

$formatDate = static function ($value): string {
    if (!$value) {
        return '—';
    }

    $timestamp = strtotime((string) $value);

    if (!$timestamp) {
        return (string) $value;
    }

    return I18n::current() === 'en'
        ? date('j M Y', $timestamp)
        : date('d.m.Y', $timestamp);
};
?>

<section class="hero hero-compact">
    <div class="container">
        <p class="eyebrow">
            <?= Security::e(I18n::t('forum.eyebrow')) ?>
        </p>

        <h1><?= Security::e(I18n::t('forum.title')) ?></h1>

        <p><?= Security::e(I18n::t('forum.intro')) ?></p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="card">
            <div class="section-head">
                <h2><?= Security::e(I18n::t('forum.current_topics')) ?></h2>

                <?php if ($canWrite): ?>
                    <a
                        class="button button-outline"
                        href="<?= Security::e(I18n::url('/forum/neu')) ?>"
                    >
                        <?= Security::e(I18n::t('forum.create_topic')) ?>
                    </a>
                <?php else: ?>
                    <a
                        class="button button-outline"
                        href="<?= Security::e(I18n::url('/login')) ?>"
                    >
                        <?= Security::e(I18n::t('forum.login_to_write')) ?>
                    </a>
                <?php endif; ?>
            </div>

            <?php if (empty($topics)): ?>
                <p><?= Security::e(I18n::t('forum.no_topics')) ?></p>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="forum-table">
                        <thead>
                            <tr>
                                <th><?= Security::e(I18n::t('forum.topic')) ?></th>
                                <th><?= Security::e(I18n::t('forum.author')) ?></th>
                                <th><?= Security::e(I18n::t('forum.replies')) ?></th>
                                <th><?= Security::e(I18n::t('forum.last_post')) ?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($topics as $topic): ?>
                                <tr>
                                    <td>
                                        <a
                                            href="<?= Security::e(
                                                I18n::url(
                                                    '/forum/' . rawurlencode((string) $topic['slug'])
                                                )
                                            ) ?>"
                                        >
                                            <?= Security::e($topic['title'] ?? '') ?>
                                        </a>
                                    </td>

                                    <td>
                                        <?= Security::e(
                                            $topic['author']
                                            ?? I18n::t('common.unknown')
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= max(
                                            0,
                                            (int) ($topic['reply_count'] ?? 1) - 1
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= Security::e(
                                            $formatDate(
                                                $topic['updated_at']
                                                ?? $topic['created_at']
                                                ?? null
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
