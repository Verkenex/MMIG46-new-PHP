<?php

use MMIG46\Core\I18n;
use MMIG46\Core\Security;
?>

<section class="hero hero-compact">
    <div class="container">
        <p class="eyebrow">
            <?= Security::e(I18n::t('forum.eyebrow')) ?>
        </p>

        <h1><?= Security::e(I18n::t('forum.new_topic')) ?></h1>

        <p><?= Security::e(I18n::t('forum.new_topic_intro')) ?></p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="card forum-form-card">
            <form
                method="post"
                action="<?= Security::e(I18n::url('/forum/neu')) ?>"
                class="form-stack"
            >
                <input
                    type="hidden"
                    name="_csrf"
                    value="<?= Security::e(Security::csrf()) ?>"
                >

                <div class="form-field">
                    <label for="title">
                        <?= Security::e(I18n::t('forum.title_label')) ?>
                    </label>

                    <input
                        id="title"
                        name="title"
                        type="text"
                        maxlength="180"
                        minlength="4"
                        required
                    >
                </div>

                <div class="form-field">
                    <label for="body">
                        <?= Security::e(I18n::t('forum.body_label')) ?>
                    </label>

                    <textarea
                        id="body"
                        name="body"
                        rows="10"
                        minlength="10"
                        required
                    ></textarea>
                </div>

                <div class="form-actions">
                    <button class="button" type="submit">
                        <?= Security::e(I18n::t('common.publish')) ?>
                    </button>

                    <a
                        class="button button-outline"
                        href="<?= Security::e(I18n::url('/forum')) ?>"
                    >
                        <?= Security::e(I18n::t('common.cancel')) ?>
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>
