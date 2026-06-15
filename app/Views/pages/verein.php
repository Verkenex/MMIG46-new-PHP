<?php
$eyebrow = $data['eyebrow'] ?? 'Verein';
$headline = $data['headline'] ?? ($page['title'] ?? 'MMIG46 e.V.');
$intro = $data['intro'] ?? ($page['teaser'] ?? '');
$cards = $data['cards'] ?? [];
$actions = $data['actions'] ?? [];
?>

<section class="verein-hero">
    <div class="container verein-layout">
        <div class="verein-main">
            <p class="eyebrow"><?= htmlspecialchars($eyebrow) ?></p>
            <h1><?= htmlspecialchars($headline) ?></h1>

            <?php if ($intro): ?>
                <p class="lead"><?= htmlspecialchars($intro) ?></p>
            <?php endif; ?>

            <div class="verein-card-stack">
                <?php foreach ($cards as $card): ?>
                    <article class="verein-info-card">
                        <h2><?= htmlspecialchars($card['title'] ?? '') ?></h2>
                        <p><?= htmlspecialchars($card['text'] ?? '') ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>

        <aside class="verein-side">
            <?php foreach ($actions as $action): ?>
                <a class="verein-action-card" href="<?= htmlspecialchars($action['url'] ?? '#') ?>">
                    <span>
                        <strong><?= htmlspecialchars($action['title'] ?? '') ?></strong>
                        <small><?= htmlspecialchars($action['text'] ?? '') ?></small>
                    </span>
                    <span aria-hidden="true">›</span>
                </a>
            <?php endforeach; ?>
        </aside>
    </div>
</section>