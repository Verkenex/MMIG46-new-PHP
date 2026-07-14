<?php

use MMIG46\Core\I18n;
use MMIG46\Core\Security;
?>

<section class="page">
    <p class="eyebrow">404</p>

    <h1><?= Security::e(I18n::t('error.404.title')) ?></h1>

    <p><?= Security::e(I18n::t('error.404.text')) ?></p>

    <a
        class="button button--primary"
        href="<?= Security::e(I18n::url('/')) ?>"
    >
        <?= Security::e(I18n::t('error.404.home')) ?>
    </a>
</section>
