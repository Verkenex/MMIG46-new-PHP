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
        <?php
          $title = $item['title'] ?? '';
          $slug = $item['slug'] ?? '';
          $category = $item['category'] ?? 'News';
          $teaser = $item['teaser'] ?? '';
          $imagePath = $item['image_path'] ?? '';
          $publishedAt = $item['published_at'] ?? null;
          $newsUrl = '/news/' . rawurlencode($slug);
        ?>

        <article class="image-card">
          <a class="image-card__link" href="<?= htmlspecialchars($newsUrl) ?>" aria-label="Artikel lesen: <?= htmlspecialchars($title) ?>">
            <?php if (!empty($imagePath)): ?>
              <div class="image-card__media">
                <img src="<?= htmlspecialchars($imagePath) ?>" alt="">
                <span class="image-card__badge">
                  <?= htmlspecialchars($category) ?>
                </span>
              </div>
            <?php else: ?>
              <div class="image-card__media image-card__media--empty">
                <span class="image-card__badge">
                  <?= htmlspecialchars($category) ?>
                </span>
              </div>
            <?php endif; ?>

            <div class="image-card__body">
              <h2><?= htmlspecialchars($title) ?></h2>

              <?php if (!empty($teaser)): ?>
                <p><?= htmlspecialchars($teaser) ?></p>
              <?php endif; ?>

              <div class="image-card__meta">
                <?php if (!empty($publishedAt)): ?>
                  <span><?= htmlspecialchars(date('d.m.Y', strtotime($publishedAt))) ?></span>
                <?php endif; ?>

                <?php if (isset($item['comment_count'])): ?>
                  <span><?= (int)$item['comment_count'] ?> Kommentare</span>
                <?php endif; ?>
              </div>

              <span class="image-card__read-more">Artikel lesen</span>
            </div>
          </a>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>