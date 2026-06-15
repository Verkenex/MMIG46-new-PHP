<section class="hero">
  <div>
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

  <div class="orb">
    <span>PA-46</span>
  </div>
</section>

<section class="grid two">
  <article>
    <h2>Aktuell</h2>

    <?php if (empty($latestNews)): ?>
      <p class="meta">Noch keine veröffentlichten News.</p>
    <?php else: ?>
      <?php foreach ($latestNews as $item): ?>
        <div class="card">
          <p class="meta">
            <?= htmlspecialchars(date('d.m.Y', strtotime($item['published_at']))) ?>
          </p>
          <h3><?= htmlspecialchars($item['title']) ?></h3>
          <p><?= htmlspecialchars($item['teaser'] ?? '') ?></p>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

    <p><a class="btn" href="/news">Alle News</a></p>
  </article>

  <article>
    <h2>Reisen & Fly-Ins</h2>

    <?php if (empty($latestTravels)): ?>
      <p class="meta">Noch keine veröffentlichten Reisen.</p>
    <?php else: ?>
      <?php foreach ($latestTravels as $item): ?>
        <div class="card">
          <p class="meta">
            <?= htmlspecialchars($item['status']) ?>
            <?php if (!empty($item['location'])): ?>
              · <?= htmlspecialchars($item['location']) ?>
            <?php endif; ?>
          </p>
          <h3><?= htmlspecialchars($item['title']) ?></h3>
          <p><?= htmlspecialchars($item['teaser'] ?? '') ?></p>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>

    <p><a class="btn" href="/reisen">Alle Reisen</a></p>
  </article>
</section>