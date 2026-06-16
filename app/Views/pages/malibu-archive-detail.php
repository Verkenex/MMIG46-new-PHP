<?php
$title = $article['title'] ?? 'Archivbeitrag';
$subtitle = $article['subtitle'] ?? '';
$sourceLabel = $article['source_label'] ?? 'Archivbeitrag der bisherigen MMIG46-Website';
$bodyHtml = $bodyHtml ?? '';
?>

<section class="section">
  <div class="container prose">
    <p class="eyebrow">Malibu Mirage Archiv</p>
    <h1><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></h1>

    <?php if ($subtitle !== ''): ?>
      <h2><?= htmlspecialchars($subtitle, ENT_QUOTES, 'UTF-8') ?></h2>
    <?php endif; ?>

    <p class="fineprint">
      <?= htmlspecialchars($sourceLabel, ENT_QUOTES, 'UTF-8') ?>
    </p>

    <p>
      <a class="button button-outline" href="/malibu-mirage">Zurück zur Malibu-Mirage-Seite</a>
    </p>
  </div>
</section>

<section class="section section-tight">
  <div class="container">
    <article class="card content-card malibu-article-card">
      <?= $bodyHtml ?>
    </article>
  </div>
</section>