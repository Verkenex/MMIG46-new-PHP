<section class="page narrow">
  <?php if (!empty($page['teaser'])): ?>
    <p class="eyebrow"><?= htmlspecialchars($page['teaser']) ?></p>
  <?php endif; ?>

  <h1><?= htmlspecialchars($page['title'] ?? '') ?></h1>

  <article class="content-body">
    <?php if (!empty($bodyHtml)): ?>
      <?= $bodyHtml ?>
    <?php else: ?>
      <p><?= nl2br(htmlspecialchars($page['body'] ?? '')) ?></p>
    <?php endif; ?>
  </article>
</section>

