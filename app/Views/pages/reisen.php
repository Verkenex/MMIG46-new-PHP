<section class="page">
  <div class="split">
    <div>
      <p class="eyebrow">Fly-Ins & Reisen</p>
      <h1>Reisen</h1>
      <p class="meta">Geplante und vergangene Reiseaktivitäten der MMIG46.</p>
    </div>
  </div>

  <div class="image-card-grid">
    <?php if (empty($items)): ?>
      <article class="image-card">
        <div class="image-card__body">
          <p>Derzeit sind keine Reisen veröffentlicht.</p>
        </div>
      </article>
    <?php else: ?>
      <?php foreach ($items as $item): ?>
        <article class="image-card">
          <?php if (!empty($item['image_path'])): ?>
            <div class="image-card__media">
              <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="">
              <span class="image-card__badge">
                <?= htmlspecialchars($item['status']) ?>
                <?php if (!empty($item['location'])): ?>
                  · <?= htmlspecialchars($item['location']) ?>
                <?php endif; ?>
              </span>
            </div>
          <?php else: ?>
            <div class="image-card__media image-card__media--empty">
              <span class="image-card__badge">
                <?= htmlspecialchars($item['status']) ?>
                <?php if (!empty($item['location'])): ?>
                  · <?= htmlspecialchars($item['location']) ?>
                <?php endif; ?>
              </span>
            </div>
          <?php endif; ?>

          <div class="image-card__body">
            <h2><?= htmlspecialchars($item['title']) ?></h2>

            <?php if (!empty($item['teaser'])): ?>
              <p><?= htmlspecialchars($item['teaser']) ?></p>
            <?php endif; ?>

            <div class="image-card__meta">
              <?php if (!empty($item['starts_on'])): ?>
                <span>
                  <?= htmlspecialchars(date('d.m.Y', strtotime($item['starts_on']))) ?>
                  <?php if (!empty($item['ends_on'])): ?>
                    – <?= htmlspecialchars(date('d.m.Y', strtotime($item['ends_on']))) ?>
                  <?php endif; ?>
                </span>
              <?php else: ?>
                <span><?= htmlspecialchars($item['status']) ?></span>
              <?php endif; ?>

              <?php if (!empty($item['cta_label'])): ?>
                <span><?= htmlspecialchars($item['cta_label']) ?></span>
              <?php endif; ?>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>