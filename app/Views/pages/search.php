<?php

use MMIG46\Core\I18n;
use MMIG46\Core\Security;

$title = I18n::t('search.title');
?>

<section class="page-hero">
    <div class="container">
        <p class="eyebrow"><?= Security::e(I18n::t('search.title')) ?></p>
        <h1><?= Security::e(I18n::t('search.title')) ?></h1>

        <?php if (mb_strlen($q) >= 2): ?>
            <p>
                <?= Security::e(I18n::t('search.results_for')) ?>
                <strong><?= Security::e($q) ?></strong>
            </p>
        <?php else: ?>
            <p><?= Security::e(I18n::t('search.min_length')) ?></p>
        <?php endif; ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <form class="search-page-form" action="/suche" method="get">
            <input
                type="search"
                name="q"
                value="<?= Security::e($q) ?>"
                placeholder="<?= Security::e(I18n::t('search.placeholder')) ?>"
                minlength="2"
                required
            >

            <select name="lang" aria-label="<?= Security::e(I18n::t('language.label')) ?>">
                <option value="de" <?= $lang === 'de' ? 'selected' : '' ?>>
                    <?= Security::e(I18n::t('language.de')) ?>
                </option>
                <option value="en" <?= $lang === 'en' ? 'selected' : '' ?>>
                    <?= Security::e(I18n::t('language.en')) ?>
                </option>
            </select>

            <button type="submit">
                <?= Security::e(I18n::t('search.button')) ?>
            </button>
        </form>

        <?php if (mb_strlen($q) >= 2 && empty($results)): ?>
            <p class="muted"><?= Security::e(I18n::t('search.no_results')) ?></p>
        <?php endif; ?>

        <?php if (!empty($results)): ?>
            <div class="search-results">
                <?php foreach ($results as $result): ?>
                    <?php
                        $typeKey = 'search.type.' . ($result['type'] ?? 'page');
                        $url = (string)($result['url'] ?? '#');
                        $url .= str_contains($url, '?') ? '&' : '?';
                        $url .= 'lang=' . rawurlencode($lang);
                    ?>

                    <article class="search-result-card">
                        <p class="eyebrow">
                            <?= Security::e(I18n::t($typeKey)) ?>
                        </p>

                        <h2>
                            <a href="<?= Security::e($url) ?>">
                                <?= Security::e($result['title'] ?? '') ?>
                            </a>
                        </h2>

                        <?php if (!empty($result['excerpt'])): ?>
                            <p>
                                <?= Security::e(mb_strimwidth(strip_tags((string)$result['excerpt']), 0, 260, '…')) ?>
                            </p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>