<section class="page">
  <div class="split">
    <div>
      <p class="eyebrow">News</p>
      <h1>Aktuelles aus Verein, Technik und Community.</h1>
      <p class="meta">Hinweise, Ankündigungen und relevante Informationen für Mitglieder und PA46-Interessierte.</p>
    </div>
  </div>

  <div class="cards">
    <?php if (empty($items)): ?>
      <article class="card">
        <div class="card-body">
          <p>Derzeit sind keine News veröffentlicht.</p>
        </div>
      </article>
    <?php else: ?>
      <?php foreach ($items as $item): ?>
        <article class="card">
          <div class="card-body">
            <p class="badge">News</p>

            <h2><?= htmlspecialchars($item['title']) ?></h2>

            <?php if (!empty($item['teaser'])): ?>
              <p><?= htmlspecialchars($item['teaser']) ?></p>
            <?php endif; ?>

            <p class="meta">
              <?= htmlspecialchars(date('d.m.Y', strtotime($item['published_at']))) ?>
            </p>
          </div>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>