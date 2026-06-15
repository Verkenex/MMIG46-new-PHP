<section class="page">
  <div class="split">
    <div>
      <p class="eyebrow">News</p>
      <h1>Aktuelles aus Verein, Technik und Community.</h1>
      <p class="meta">
        Hinweise, Ankündigungen und relevante Informationen für Mitglieder und PA46-Interessierte.
      </p>
    </div>
  </div>

  <div class="image-card-grid">
    <?php if (empty($items)): ?>
      <article class="image-card">
        <div class="image-card__body">
          <p>Derzeit sind keine News veröffentlicht.</p>
        </div>
      </article>
    <?php else: ?>
      <?php foreach ($items as $item): ?>
        <article class="image-card">
          <?php if (!empty($item['image_path'])): ?>
            <div class="image-card__media">
              <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="">
              <span class="image-card__badge">
                <?= htmlspecialchars($item['category'] ?? 'News') ?>
              </span>
            </div>
          <?php else: ?>
            <div class="image-card__media image-card__media--empty">
              <span class="image-card__badge">
                <?= htmlspecialchars($item['category'] ?? 'News') ?>
              </span>
            </div>
          <?php endif; ?>

          <div class="image-card__body">
            <h2><?= htmlspecialchars($item['title']) ?></h2>

            <?php if (!empty($item['teaser'])): ?>
              <p><?= htmlspecialchars($item['teaser']) ?></p>
            <?php endif; ?>

            <div class="image-card__meta">
              <span><?= htmlspecialchars(date('d.m.Y', strtotime($item['published_at']))) ?></span>

              <?php if (isset($item['comment_count'])): ?>
                <span><?= (int)$item['comment_count'] ?> Kommentare</span>
              <?php endif; ?>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>