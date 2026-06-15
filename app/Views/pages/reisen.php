<section class="page">
  <p class="eyebrow">Fly-Ins & Reisen</p>
  <h1>Reisen</h1>
  <p class="meta">Geplante und vergangene Reiseaktivitäten der MMIG46.</p>

  <div class="grid">
    <?php if (empty($items)): ?>
      <article>
        <p>Derzeit sind keine Reisen veröffentlicht.</p>
      </article>
    <?php else: ?>
      <?php foreach ($items as $item): ?>
        <article>
          <p class="meta">
            <?= htmlspecialchars($item['status']) ?>
            <?php if (!empty($item['location'])): ?>
              · <?= htmlspecialchars($item['location']) ?>
            <?php endif; ?>
            <?php if (!empty($item['starts_on'])): ?>
              · <?= htmlspecialchars(date('d.m.Y', strtotime($item['starts_on']))) ?>
            <?php endif; ?>
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