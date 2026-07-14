<?php

use MMIG46\Core\I18n;
use MMIG46\Core\Security;

$lang = I18n::current();
$isEnglish = $lang === 'en';

$e = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

$text = $isEnglish
    ? [
        'eyebrow' => 'Forum',
        'title' => 'Create a new topic',
        'intro' => 'Create a new forum topic. Markdown can be used for basic formatting.',
        'topic_title' => 'Title',
        'body' => 'Text / Markdown',
        'publish' => 'Publish topic',
        'cancel' => 'Cancel',
    ]
    : [
        'eyebrow' => 'Forum',
        'title' => 'Neuer Beitrag',
        'intro' => 'Erstellen Sie einen neuen Beitrag. Markdown kann für einfache Formatierungen verwendet werden.',
        'topic_title' => 'Titel',
        'body' => 'Text / Markdown',
        'publish' => 'Veröffentlichen',
        'cancel' => 'Abbrechen',
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
        <div class="card forum-form-card">
            <form
                method="post"
                action="<?= $e(I18n::url('/forum/neu')) ?>"
                class="form-stack"
            >
                <?= Security::csrfField() ?>

                <div class="form-field">
                    <label for="title">
                        <?= $e($text['topic_title']) ?>
                    </label>

                    <input
                        id="title"
                        name="title"
                        type="text"
                        maxlength="180"
                        required
                    >
                </div>

                <div class="form-field">
                    <label for="body">
                        <?= $e($text['body']) ?>
                    </label>

                    <textarea
                        id="body"
                        name="body"
                        rows="10"
                        required
                    ></textarea>
                </div>

                <div class="form-actions">
                    <button class="button" type="submit">
                        <?= $e($text['publish']) ?>
                    </button>

                    <a
                        class="button button-outline"
                        href="<?= $e(I18n::url('/forum')) ?>"
                    >
                        <?= $e($text['cancel']) ?>
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>