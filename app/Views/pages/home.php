<?php

use MMIG46\Core\I18n;
use MMIG46\Core\Security;

$lang = $lang ?? I18n::current();
$isEn = $lang === 'en';

$latestNews = $latestNews ?? [];
$latestTravels = $latestTravels ?? [];

$copy = [
    'de' => [
        'hero_eyebrow' => 'MMIG46 e.V.',
        'hero_title' => 'Malibu Mirage Interessengemeinschaft 46',
        'hero_lead' => 'Vereinigung von Besitzern, Haltern und Piloten der Piper PA46.',
        'hero_travels' => 'Reisen ansehen',
        'hero_club' => 'Mehr über den Verein',
        'hero_contact' => 'Kontakt aufnehmen',

        'feature_travels_title' => 'Fly-Ins & Reisen',
        'feature_travels_text' => 'Gemeinsame Ausflüge, Fly-Ins und Reiseziele in Europa.',
        'feature_members_title' => 'Mitgliederbereich',
        'feature_members_text' => 'Exklusive Inhalte, interne Informationen und direkter Austausch.',
        'feature_tech_title' => 'Technischer Austausch',
        'feature_tech_text' => 'Erfahrungen teilen, Fragen stellen und von der Gemeinschaft profitieren.',
        'feature_forum_title' => 'Forum & News',
        'feature_forum_text' => 'Aktuelle News, Diskussionen und hilfreiche Beiträge aus der Community.',

        'news_title' => 'Aktuelles',
        'news_all' => 'Alle News anzeigen →',
        'news_empty_title' => 'Noch keine veröffentlichten News',
        'news_empty_text' => 'Neue Beiträge erscheinen hier, sobald sie im Adminbereich veröffentlicht wurden.',
        'read_article' => 'Artikel lesen →',
        'comments' => 'Kommentare',
    ],
    'en' => [
        'hero_eyebrow' => 'MMIG46 e.V.',
        'hero_title' => 'Malibu Mirage Interest Group 46',
        'hero_lead' => 'Association of owners, operators and pilots of the Piper PA46.',
        'hero_travels' => 'View travels',
        'hero_club' => 'Learn more about the club',
        'hero_contact' => 'Contact us',

        'feature_travels_title' => 'Fly-ins & travels',
        'feature_travels_text' => 'Joint trips, fly-ins and travel destinations across Europe.',
        'feature_members_title' => 'Member area',
        'feature_members_text' => 'Exclusive content, internal information and direct exchange.',
        'feature_tech_title' => 'Technical exchange',
        'feature_tech_text' => 'Share experience, ask questions and benefit from the community.',
        'feature_forum_title' => 'Forum & news',
        'feature_forum_text' => 'Current news, discussions and helpful contributions from the community.',

        'news_title' => 'News',
        'news_all' => 'View all news →',
        'news_empty_title' => 'No published news yet',
        'news_empty_text' => 'New posts will appear here once they have been published in the admin area.',
        'read_article' => 'Read article →',
        'comments' => 'comments',
    ],
];

$t = $copy[$isEn ? 'en' : 'de'];

function mmig_format_date(?string $date): string
{
    if (!$date) {
        return '';
    }

    $timestamp = strtotime($date);

    if (!$timestamp) {
        return $date;
    }

    return date('d.m.Y', $timestamp);
}

?>


<section class="training-banner">
    <div class="container training-banner__inner">
        <div>
            <p class="training-banner__eyebrow">
                <?= $isEn
                    ? '25–26 September 2026 · EDLN'
                    : '25.–26. September 2026 · EDLN' ?>
            </p>

            <h2>
                <?= $isEn
                    ? 'MMIG46 Training Weekend'
                    : 'MMIG46 Trainingswochenende' ?>
            </h2>

            <p>
                <?= $isEn
                    ? 'Use it or lose it: IFR refresher training, fire-safety exercises, avionics, simulator training, hands-on sessions and proficiency check flights.'
                    : 'Use it or lose it: IFR-Refresher, Feuerlöschübungen, Avionik, Simulatortraining, praktische Übungen und Checkflüge.' ?>
            </p>

            <p class="training-banner__limited">
                <?= $isEn
                    ? 'Limited capacity – first come, first served.'
                    : 'Begrenzte Kapazitäten – first come, first served.' ?>
            </p>
        </div>

        <a class="button button--light"
           href="<?= $isEn
               ? '/trainingswochenende-2026?lang=en'
               : '/trainingswochenende-2026?lang=de' ?>">
            <?= $isEn
                ? 'View programme and register'
                : 'Programm ansehen und anmelden' ?>
        </a>
    </div>
</section>

<section class="home-hero">
    <div class="home-hero__content">
        <p class="eyebrow"><?= Security::e($t['hero_eyebrow']) ?></p>

    <h1 class="home-hero__title">
        <?php if ($isEn): ?>
            Malibu Mirage<br>
            <span class="home-hero__association">
                Interest Group 46
            </span>
        <?php else: ?>
            Malibu Mirage<br>
            <span class="home-hero__association">
                Interessen<wbr>gemeinschaft 46
            </span>
        <?php endif; ?>
    </h1>

        <p><?= Security::e($t['hero_lead']) ?></p>

        <div class="actions">
            <a class="button button--primary" href="<?= Security::e(I18n::url('/reisen', $lang)) ?>">
                <?= Security::e($t['hero_travels']) ?>
            </a>

            <a class="button button--secondary" href="<?= Security::e(I18n::url('/verein', $lang)) ?>">
                <?= Security::e($t['hero_club']) ?>
            </a>

            <a class="button button--secondary" href="<?= Security::e(I18n::url('/kontakt', $lang)) ?>">
                <?= Security::e($t['hero_contact']) ?>
            </a>
        </div>
    </div>
</section>

<section class="feature-strip">
    <article>
        <span aria-hidden="true">✈</span>
        <div>
            <h2><?= Security::e($t['feature_travels_title']) ?></h2>
            <p><?= Security::e($t['feature_travels_text']) ?></p>
        </div>
    </article>

    <article>
        <span aria-hidden="true">♟</span>
        <div>
            <h2><?= Security::e($t['feature_members_title']) ?></h2>
            <p><?= Security::e($t['feature_members_text']) ?></p>
        </div>
    </article>

    <article>
        <span aria-hidden="true">🔧</span>
        <div>
            <h2><?= Security::e($t['feature_tech_title']) ?></h2>
            <p><?= Security::e($t['feature_tech_text']) ?></p>
        </div>
    </article>

    <article>
        <span aria-hidden="true">💬</span>
        <div>
            <h2><?= Security::e($t['feature_forum_title']) ?></h2>
            <p><?= Security::e($t['feature_forum_text']) ?></p>
        </div>
    </article>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading">
            <h2><?= Security::e($t['news_title']) ?></h2>

            <a href="<?= Security::e(I18n::url('/news', $lang)) ?>">
                <?= Security::e($t['news_all']) ?>
            </a>
        </div>

        <?php if (empty($latestNews)): ?>
            <div class="empty-state">
                <h2><?= Security::e($t['news_empty_title']) ?></h2>
                <p><?= Security::e($t['news_empty_text']) ?></p>
            </div>
        <?php else: ?>
            <div class="home-news-grid">
                <?php foreach ($latestNews as $item): ?>
                    <?php
                    $title = (string)($item['title'] ?? '');
                    $slug = (string)($item['slug'] ?? '');
                    $category = trim((string)($item['category'] ?? ''));
                    $image = trim((string)($item['image_path'] ?? ''));
                    $teaser = trim((string)($item['teaser'] ?? ''));
                    $publishedAt = mmig_format_date($item['published_at'] ?? null);
                    $commentCount = (int)($item['comment_count'] ?? 0);

                    $href = $slug !== ''
                        ? I18n::url('/news/' . rawurlencode($slug), $lang)
                        : I18n::url('/news', $lang);
                    ?>

                    <article class="home-news-card">
                        <a class="home-news-card__link" href="<?= Security::e($href) ?>">
                            <figure class="home-news-card__media">
                                <?php if ($image !== ''): ?>
                                    <img src="<?= Security::e($image) ?>" alt="<?= Security::e($title) ?>">
                                <?php endif; ?>

                                <?php if ($category !== ''): ?>
                                    <span class="home-news-card__badge">
                                        <?= Security::e($category) ?>
                                    </span>
                                <?php endif; ?>
                            </figure>

                            <div class="home-news-card__body">
                                <h3><?= Security::e($title) ?></h3>

                                <?php if ($teaser !== ''): ?>
                                    <p class="home-news-card__teaser">
                                        <?= Security::e($teaser) ?>
                                    </p>
                                <?php endif; ?>

                                <?php if ($publishedAt !== '' || $commentCount > 0): ?>
                                    <p class="home-news-card__meta">
                                        <?php if ($publishedAt !== ''): ?>
                                            <span><?= Security::e($publishedAt) ?></span>
                                        <?php endif; ?>

                                        <?php if ($commentCount > 0): ?>
                                            <span>
                                                <?= Security::e((string)$commentCount) ?>
                                                <?= Security::e($t['comments']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </p>
                                <?php endif; ?>

                                <span class="home-news-card__more">
                                    <?= Security::e($t['read_article']) ?>
                                </span>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>