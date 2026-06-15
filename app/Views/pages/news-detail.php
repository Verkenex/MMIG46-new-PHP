<?php
$title = htmlspecialchars($item['title'] ?? 'Artikel', ENT_QUOTES, 'UTF-8');
$category = htmlspecialchars($item['category'] ?? 'Aktuelles', ENT_QUOTES, 'UTF-8');
$publishedAt = htmlspecialchars($item['published_at'] ?? '', ENT_QUOTES, 'UTF-8');
$image = trim((string)($item['image'] ?? ''));
$excerpt = htmlspecialchars($item['excerpt'] ?? '', ENT_QUOTES, 'UTF-8');

function mmig_asset_path(string $path): string {
    $path = trim($path);
    if ($path === '') {
        return '';
    }
    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
        return $path;
    }
    return '/' . ltrim($path, '/');
}
?>

<section class="article-page">
  <article class="article-shell">
    <header class="article-header">
      <p class="eyebrow"><?= $category ?></p>
      <h1><?= $title ?></h1>

      <?php if ($excerpt !== ''): ?>
        <p class="article-lead"><?= $excerpt ?></p>
      <?php endif; ?>

      <?php if ($publishedAt !== ''): ?>
        <p class="article-meta"><?= $publishedAt ?></p>
      <?php endif; ?>
    </header>

    <?php if ($image !== ''): ?>
      <figure class="article-hero">
        <img src="<?= htmlspecialchars(mmig_asset_path($image), ENT_QUOTES, 'UTF-8') ?>" alt="<?= $title ?>">
      </figure>
    <?php endif; ?>

    <div class="article-body">
      <?= $bodyHtml ?>
    </div>

    <footer class="article-footer">
      <a href="/aktuelles" class="back-link">← Zurück zu Aktuelles</a>
    </footer>
  </article>
</section>