<section class="page">
  <div class="split">
    <div>
      <p class="eyebrow">MMIG46</p>
      <h1>News</h1>
      <p class="meta">Aktuelle Hinweise, Ankündigungen und Vereinsmeldungen.</p>
    </div>
  </div>

  <div class="grid">
    <?php if (empty($items)): ?>
      <article>
        <p>Derzeit sind keine News veröffentlicht.</p>
      </article>
    <?php else: ?>
      <?php foreach ($items as $item): ?>
        <article>
          <p class="meta">
            <?= htmlspecialchars(date('d.m.Y', strtotime($item['published_at']))) ?>
          </p>
          <h2><?= htmlspecialchars($item['title']) ?></h2>
          <?php if (!empty($item['teaser'])): ?>
            <p><?= htmlspecialchars($item['teaser']) ?></p>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>