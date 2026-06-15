<?php

use MMIG46\Core\Security;

$siteName = $settings['site_name'] ?? 'MMIG46 e.V.';
$siteClaim = $settings['site_claim'] ?? 'Malibu Mirage Interessengemeinschaft 46';
$siteDescription = $settings['site_description'] ?? 'Vereinigung von Besitzern, Haltern und Piloten der Piper PA46.';
?>

<section class="home-hero">
    <div class="home-hero__content">
        <p class="eyebrow"><?= Security::e($siteName) ?></p>

        <h1><?= Security::e($siteClaim) ?></h1>

        <p>
            <?= Security::e($siteDescription) ?>
        </p>

        <div class="actions">
            <a class="btn primary" href="/reisen">Reisen ansehen</a>
            <a class="btn" href="/verein">Mehr über den Verein</a>
            <a class="btn" href="/kontakt">Kontakt aufnehmen</a>
        </div>
    </div>
</section>

<section class="feature-strip">
    <article>
        <span aria-hidden="true">✈</span>
        <div>
            <h2>Fly-Ins & Reisen</h2>
            <p>Gemeinsame Ausflüge, Fly-Ins und Reiseziele in Europa.</p>
        </div>
    </article>

    <article>
        <span aria-hidden="true">♟</span>
        <div>
            <h2>Mitgliederbereich</h2>
            <p>Exklusive Inhalte, interne Informationen und direkter Austausch.</p>
        </div>
    </article>

    <article>
        <span aria-hidden="true">🔧</span>
        <div>
            <h2>Technischer Austausch</h2>
            <p>Erfahrungen teilen, Fragen stellen und von der Gemeinschaft profitieren.</p>
        </div>
    </article>

    <article>
        <span aria-hidden="true">💬</span>
        <div>
            <h2>Forum & News</h2>
            <p>Aktuelle News, Diskussionen und hilfreiche Beiträge aus der Community.</p>
        </div>
    </article>
</section>

<section class="page">
    <div class="split">
        <h2>Aktuelles</h2>
        <a class="text-link" href="/news">Alle News anzeigen →</a>
    </div>

    <?php if (empty($latestNews)): ?>
        <div class="empty-state">
            <h2>Noch keine veröffentlichten News</h2>
            <p>Neue Beiträge erscheinen hier, sobald sie im Adminbereich veröffentlicht wurden.</p>
        </div>
    <?php else: ?>
        <div class="home-news-grid">
            <?php foreach ($latestNews as $item): ?>
                <?php
                $newsSlug = trim((string)($item['slug'] ?? ''));
                $newsUrl = $newsSlug !== ''
                    ? '/news/' . rawurlencode($newsSlug)
                    : '/news';

                $newsTitle = Security::e($item['title'] ?? 'News');
                $newsTeaser = Security::e($item['teaser'] ?? '');
                $newsCategory = Security::e($item['category'] ?? 'News');

                $publishedAt = (string)($item['published_at'] ?? '');
                $timestamp = $publishedAt !== '' ? strtotime($publishedAt) : false;
                $newsDate = $timestamp ? date('d.m.Y', $timestamp) : '';

                $imagePath = trim((string)($item['image_path'] ?? ''));
                ?>

                <article class="home-news-card">
                    <a class="home-news-card__link" href="<?= Security::e($newsUrl) ?>">
                        <figure class="home-news-card__media">
                            <?php if ($imagePath !== ''): ?>
                                <img src="<?= Security::e($imagePath) ?>" alt="<?= $newsTitle ?>">
                            <?php endif; ?>

                            <span class="home-news-card__badge"><?= $newsCategory ?></span>
                        </figure>

                        <div class="home-news-card__body">
                            <h3><?= $newsTitle ?></h3>

                            <?php if ($newsTeaser !== ''): ?>
                                <p class="home-news-card__teaser"><?= $newsTeaser ?></p>
                            <?php endif; ?>

                            <?php if ($newsDate !== ''): ?>
                                <p class="home-news-card__meta"><?= Security::e($newsDate) ?></p>
                            <?php endif; ?>

                            <span class="home-news-card__more">
                                <?= $newsSlug !== '' ? 'Artikel lesen →' : 'Alle News anzeigen →' ?>
                            </span>
                        </div>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>