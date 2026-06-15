<section class="page">
  <div class="split">
    <div>
      <p class="eyebrow">Fly-Ins & Reisen</p>
      <h1>Reisen</h1>
      <p class="meta">Geplante und vergangene Reiseaktivitäten der MMIG46.</p>
    </div>
  </div>

  <div class="cards">
    <?php if (empty($items)): ?>
      <article class="card">
        <p>Derzeit sind keine Reisen veröffentlicht.</p>
      </article>
    <?php else: ?>
      <?php foreach ($items as $item): ?>
        <article class="card">
          <div class="card-body">
            <p class="badge">
              <?= htmlspecialchars($item['status']) ?>
              <?php if (!empty($item['location'])): ?>
                · <?= htmlspecialchars($item['location']) ?>
              <?php endif; ?>
            </p>

            <h2><?= htmlspecialchars($item['title']) ?></h2>

            <?php if (!empty($item['teaser'])): ?>
              <p><?= htmlspecialchars($item['teaser']) ?></p>
            <?php endif; ?>

            <?php if (!empty($item['starts_on'])): ?>
              <p class="meta">
                <?= htmlspecialchars(date('d.m.Y', strtotime($item['starts_on']))) ?>
                <?php if (!empty($item['ends_on'])): ?>
                  – <?= htmlspecialchars(date('d.m.Y', strtotime($item['ends_on']))) ?>
                <?php endif; ?>
              </p>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</section>