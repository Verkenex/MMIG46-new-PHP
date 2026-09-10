<?php
$title = htmlspecialchars($item['title'] ?? 'Artikel', ENT_QUOTES, 'UTF-8');
$category = htmlspecialchars($item['category'] ?? 'Aktuelles', ENT_QUOTES, 'UTF-8');
$publishedAt = htmlspecialchars($item['published_at'] ?? '', ENT_QUOTES, 'UTF-8');
$image = trim((string)($item['image_path'] ?? ''));
$excerpt = htmlspecialchars($item['teaser'] ?? '', ENT_QUOTES, 'UTF-8');
$seo = [
    'title' => (string)($item['title'] ?? 'MMIG46'),
    'description' => (string)($item['teaser'] ?? ''),
    'og_type' => 'article',
    'og_image' => $image !== '' ? \MMIG46\Core\Seo::absoluteUrl(mmig_asset_path($image)) : \MMIG46\Core\Seo::absoluteUrl('/assets/img/og-default.jpg'),
    'structured_data' => ['@context'=>'https://schema.org','@type'=>'Article','headline'=>(string)($item['title']??''),'datePublished'=>(string)($item['published_at']??''),'inLanguage'=>$lang,'publisher'=>['@id'=>\MMIG46\Core\Seo::absoluteUrl('/').'#organization']],
];
$newsAlternates=[];
foreach(['de','en'] as $candidateLang) if(\MMIG46\Models\NewsItem::findPublishedBySlug((string)$item['slug'],$candidateLang)) $newsAlternates[$candidateLang]=\MMIG46\Core\Seo::canonicalUrl('/news/'.(string)$item['slug'],$candidateLang);
if(isset($newsAlternates['de'])) $newsAlternates['x-default']=$newsAlternates['de'];
$seo['alternates']=$newsAlternates;

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
      <a href="<?= htmlspecialchars(\MMIG46\Core\I18n::url('/news', $lang), ENT_QUOTES, 'UTF-8') ?>" class="back-link">← <?= $lang === 'en' ? 'Back to news' : 'Zurück zu Aktuelles' ?></a>
    </footer>
  </article>
</section>
