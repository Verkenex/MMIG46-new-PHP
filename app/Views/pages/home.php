<section class="home-hero">
  <div class="home-hero__content">
    <p class="eyebrow"><?= htmlspecialchars($settings['site_name'] ?? 'MMIG46 e.V.') ?></p>

    <h1><?= htmlspecialchars($settings['site_claim'] ?? 'Malibu Mirage Interessengemeinschaft 46') ?></h1>

    <p>
      <?= htmlspecialchars($settings['site_description'] ?? 'Vereinigung von Besitzern, Haltern und Piloten der Piper PA46.') ?>
    </p>

    <div class="actions">
      <a class="btn primary" href="/reisen">Reisen ansehen</a>
      <a class="btn" href="/verein">Mehr über den Verein</a>
      <a class="btn" href="/kontakt">Kontakt aufnehmen</a>
    </div>
  </div>
</section>

<section class="feature-strip">
  <article>
    <span>✈</span>
    <div>
      <h2>Fly-Ins & Reisen</h2>
      <p>Gemeinsame Ausflüge, Fly-Ins und Reiseziele in Europa.</p>
    </div>
  </article>

  <article>
    <span>♟</span>
    <div>
      <h2>Mitgliederbereich</h2>
      <p>Exklusive Inhalte, interne Informationen und direkter Austausch.</p>
    </div>
  </article>

  <article>
    <span>🔧</span>
    <div>
      <h2>Technischer Austausch</h2>
      <p>Erfahrungen teilen, Fragen stellen und von der Gemeinschaft profitieren.</p>
    </div>
  </article>

  <article>
    <span>💬</span>
    <div>
      <h2>Forum & News</h2>
      <p>Aktuelle News, Diskussionen und hilfreiche Beiträge aus der Community.</p>
    </div>
  </article>
</section>

<section class="page">
  <div class="split">
    <h2>Aktuelles</h2>
    <a class="text-link" href="/news">Alle News anzeigen →</a>
  </div>

  <div class="image-card-grid">
    <?php if (empty($latestNews)): ?>
      <article class="image-card">
        <div class="image-card__body">
          <p class="meta">Noch keine veröffentlichten News.</p>
        </div>
      </article>
    <?php else: ?>
      <?php foreach ($latestNews as $item): ?>
        <?php
          $newsUrl = '/news/' . rawurlencode($item['slug']);
          $newsTitle = htmlspecialchars($item['title']);
          $newsTeaser = htmlspecialchars($item['teaser'] ?? '');
          $newsCategory = htmlspecialchars($item['category'] ?? 'News');
          $newsDate = htmlspecialchars(date('d.m.Y', strtotime($item['published_at'])));
        ?>

        <article class="image-card">
          <?php if (!empty($item['image_path'])): ?>
            <a class="image-card__media" href="<?= htmlspecialchars($newsUrl) ?>" aria-label="Artikel lesen: <?= $newsTitle ?>">
              <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= $newsTitle ?>">
              <span class="image-card__badge">
                <?= $newsCategory ?>
              </span>
            </a>
          <?php endif; ?>

          <div class="image-card__body">
            <h2>
              <a href="<?= htmlspecialchars($newsUrl) ?>">
                <?= $newsTitle ?>
              </a>
            </h2>

            <p><?= $newsTeaser ?></p>

            <div class="image-card__meta">
              <span><?= $newsDate ?></span>
              <?php if (isset($item['comment_count'])): ?>
                <span><?= (int)$item['comment_count'] ?> Kommentare</span>
              <?php endif; ?>
            </div>

            <a class="text-link" href="<?= htmlspecialchars($newsUrl) ?>">
              Artikel lesen →
            </a>
          </div>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>