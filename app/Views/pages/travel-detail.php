<?php
/** @var array $item */
/** @var string $bodyHtml */
?>

<article class="content-page travel-detail">
    <header class="page-header">
        <p class="eyebrow">Reisen</p>
        <h1><?= e($item['title'] ?? '') ?></h1>

        <?php if (!empty($item['location'])): ?>
            <p><?= e($item['location']) ?></p>
        <?php endif; ?>

        <?php if (!empty($item['starts_on'])): ?>
            <p>
                <?= e($item['starts_on']) ?>
                <?php if (!empty($item['ends_on']) && $item['ends_on'] !== $item['starts_on']): ?>
                    – <?= e($item['ends_on']) ?>
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </header>

    <?php if (!empty($item['image_path'])): ?>
        <img src="<?= e($item['image_path']) ?>" alt="<?= e($item['title'] ?? '') ?>" class="hero-image">
    <?php endif; ?>

    <div class="content-body">
        <?= $bodyHtml ?>
    </div>

    <?php if (!empty($item['legacy_pdf_url'])): ?>
        <p>
            <a class="button" href="<?= e($item['legacy_pdf_url']) ?>" target="_blank" rel="noopener">
                <?= e($item['cta_label'] ?: 'PDF öffnen') ?>
            </a>
        </p>
    <?php endif; ?>

    <?php if (!empty($item['legacy_pdf_path'])): ?>
        <p>
            <a class="button" href="<?= e($item['legacy_pdf_path']) ?>">
                <?= e($item['cta_label'] ?: 'PDF öffnen') ?>
            </a>
        </p>
    <?php endif; ?>
</article>