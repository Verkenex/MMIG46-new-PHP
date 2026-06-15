<section class="page-hero compact">
    <div class="container">
        <p class="eyebrow"><?= htmlspecialchars($item['category'] ?? 'Aktuelles') ?></p>
        <h1><?= htmlspecialchars($item['title']) ?></h1>
        <p class="muted">
            <?= htmlspecialchars(date('d.m.Y', strtotime($item['published_at']))) ?>
        </p>
    </div>
</section>

<section class="section">
    <div class="container article-layout">
        <?php if (!empty($item['image_path'])): ?>
            <img
                class="article-hero-image"
                src="<?= htmlspecialchars($item['image_path']) ?>"
                alt="<?= htmlspecialchars($item['title']) ?>"
            >
        <?php endif; ?>

        <?php if (!empty($item['teaser'])): ?>
            <p class="lead"><?= htmlspecialchars($item['teaser']) ?></p>
        <?php endif; ?>

        <article class="richtext">
            <?= $bodyHtml ?>
        </article>

        <p class="back-link">
            <a href="/news">← Zurück zu Aktuelles</a>
        </p>
    </div>
</section>