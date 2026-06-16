<section class="page">
    <p class="eyebrow">Fly-Ins & Reisen</p>

    <h1><?= htmlspecialchars($item['title']) ?></h1>

    <p class="meta">
        <?php if (!empty($item['location'])): ?>
            <?= htmlspecialchars($item['location']) ?>
        <?php endif; ?>

        <?php if (!empty($item['starts_on'])): ?>
            · <?= htmlspecialchars(date('d.m.Y', strtotime($item['starts_on']))) ?>
            <?php if (!empty($item['ends_on'])): ?>
                – <?= htmlspecialchars(date('d.m.Y', strtotime($item['ends_on']))) ?>
            <?php endif; ?>
        <?php endif; ?>
    </p>

    <?php if (!empty($item['image_path'])): ?>
        <div class="hero-media">
            <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['title']) ?>">
        </div>
    <?php endif; ?>

    <article class="content-body">
        <?= $bodyHtml ?>
    </article>

    <p>
        <a class="button button--secondary" href="/reisen">Zurück zu Reisen</a>
    </p>
</section>