<section class="page">
  <p class="eyebrow">Fly-Ins & Reisen</p>

  <p>
    <a class="button button-outline" href="/reisen">← Zurück zu Reisen</a>
  </p>

  <article class="image-card travel-detail">
    <?php if (!empty($item['image_path'])): ?>
      <div class="image-card__media travel-detail__media">
        <img
          src="<?= htmlspecialchars($item['image_path']) ?>"
          alt="<?= htmlspecialchars($item['title']) ?>"
        >
        <span class="image-card__badge">
          <?= htmlspecialchars($item['status']) ?>
          <?php if (!empty($item['location'])): ?>
            · <?= htmlspecialchars($item['location']) ?>
          <?php endif; ?>
        </span>
      </div>
    <?php endif; ?>

    <div class="image-card__body">
      <h1><?= htmlspecialchars($item['title']) ?></h1>

      <?php if (!empty($item['starts_on'])): ?>
        <p class="meta">
          <?= htmlspecialchars(date('d.m.Y', strtotime($item['starts_on']))) ?>
          <?php if (!empty($item['ends_on'])): ?>
            – <?= htmlspecialchars(date('d.m.Y', strtotime($item['ends_on']))) ?>
          <?php endif; ?>
        </p>
      <?php endif; ?>

      <?php if (!empty($item['teaser'])): ?>
        <p class="lead"><?= htmlspecialchars($item['teaser']) ?></p>
      <?php endif; ?>

      <div class="prose">
        <?= $bodyHtml ?>
      </div>
    </div>
  </article>
</section>