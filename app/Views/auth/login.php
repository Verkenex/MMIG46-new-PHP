<?php

use MMIG46\Core\I18n;
use MMIG46\Core\Security;
?>

<section class="auth-shell">
    <div class="container">
        <form
            class="auth-card"
            method="post"
            action="<?= Security::e(I18n::url('/login')) ?>"
        >
            <h1><?= Security::e(I18n::t('auth.title')) ?></h1>

            <p><?= Security::e(I18n::t('auth.intro')) ?></p>

            <input
                type="hidden"
                name="_csrf"
                value="<?= Security::e(Security::csrf()) ?>"
            >

            <div class="form-stack">
                <div class="form-field">
                    <label for="email">
                        <?= Security::e(I18n::t('auth.email')) ?>
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        required
                    >
                </div>

                <div class="form-field">
                    <label for="password">
                        <?= Security::e(I18n::t('auth.password')) ?>
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <button
                    class="button button--primary"
                    type="submit"
                >
                    <?= Security::e(I18n::t('auth.submit')) ?>
                </button>
            </div>
        </form>
    </div>
</section>
