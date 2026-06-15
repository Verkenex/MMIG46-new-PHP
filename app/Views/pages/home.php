<section class="hero dynamic-hero">
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

<section class="page">
  <div class="split">
    <h2>Aktuelles</h2>
    <a class="text-link" href="/news">Alle News anzeigen →</a>
  </div>

  <div class="cards">
    <?php if (empty($latestNews)): ?>
      <article class="card">
        <div class="card-body">
          <p class="meta">Noch keine veröffentlichten News.</p>
        </div>
      </article>
    <?php else: ?>
      <?php foreach ($latestNews as $item): ?>
        <article class="card">
          <div class="card-body">
            <p class="badge">News</p>
            <h3><?= htmlspecialchars($item['title']) ?></h3>
            <p><?= htmlspecialchars($item['teaser'] ?? '') ?></p>
            <p class="meta"><?= htmlspecialchars(date('d.m.Y', strtotime($item['published_at']))) ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>

<section class="page">
  <div class="split">
    <h2>Reisen & Fly-Ins</h2>
    <a class="text-link" href="/reisen">Alle Reisen anzeigen →</a>
  </div>

  <div class="cards">
    <?php if (empty($latestTravels)): ?>
      <article class="card">
        <div class="card-body">
          <p class="meta">Noch keine veröffentlichten Reisen.</p>
        </div>
      </article>
    <?php else: ?>
      <?php foreach ($latestTravels as $item): ?>
        <article class="card">
          <div class="card-body">
            <p class="badge">
              <?= htmlspecialchars($item['status']) ?>
              <?php if (!empty($item['location'])): ?>
                · <?= htmlspecialchars($item['location']) ?>
              <?php endif; ?>
            </p>
            <h3><?= htmlspecialchars($item['title']) ?></h3>
            <p><?= htmlspecialchars($item['teaser'] ?? '') ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>


