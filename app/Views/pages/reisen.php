<?php

use MMIG46\Core\I18n;
use MMIG46\Core\Security;

$lang = $lang ?? I18n::current();
$isEn = $lang === 'en';
$items = $items ?? [];

$labelEyebrow = $isEn ? 'Fly-ins & travels' : 'Fly-Ins & Reisen';
$labelTitle = $isEn ? 'Travels' : 'Reisen';
$labelIntro = $isEn
    ? 'Planned and past MMIG46 travel activities.'
    : 'Geplante und vergangene Reiseaktivitäten der MMIG46.';
$labelEmpty = $isEn
    ? 'No travel activities are currently published.'
    : 'Derzeit sind keine Reisen veröffentlicht.';

$statusLabels = [
    'planned' => $isEn ? 'Planned' : 'Geplant',
    'completed' => $isEn ? 'Completed' : 'Abgeschlossen',
];

function travel_date_range(?string $start, ?string $end): string
{
    if (!$start && !$end) {
        return '';
    }

    $format = static function (?string $date): string {
        if (!$date) {
            return '';
        }

        $timestamp = strtotime($date);

        if (!$timestamp) {
            return $date;
        }

        return date('d.m.Y', $timestamp);
    };

    $startFormatted = $format($start);
    $endFormatted = $format($end);

    if ($startFormatted !== '' && $endFormatted !== '' && $startFormatted !== $endFormatted) {
        return $startFormatted . ' – ' . $endFormatted;
    }

    return $startFormatted ?: $endFormatted;
}

?>

<section class="page-hero">
    <div class="container">
        <p class="eyebrow"><?= Security::e($labelEyebrow) ?></p>
        <h1><?= Security::e($labelTitle) ?></h1>
        <p><?= Security::e($labelIntro) ?></p>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (empty($items)): ?>
            <div class="card">
                <p><?= Security::e($labelEmpty) ?></p>
            </div>
        <?php else: ?>
            <div class="card-grid travel-grid">
                <?php foreach ($items as $item): ?>
                    <?php
                    $title = (string)($item['title'] ?? '');
                    $slug = (string)($item['slug'] ?? '');
                    $image = (string)($item['image_path'] ?? '');
                    $location = (string)($item['location'] ?? '');
                    $teaser = (string)($item['teaser'] ?? '');
                    $status = (string)($item['status'] ?? '');
                    $statusLabel = $statusLabels[$status] ?? ucfirst($status);
                    $dateRange = travel_date_range($item['starts_on'] ?? null, $item['ends_on'] ?? null);

                    $ctaLabel = trim((string)($item['cta_label'] ?? ''));
                    if ($ctaLabel === '') {
                        $ctaLabel = $status === 'completed'
                            ? ($isEn ? 'View review' : 'Rückblick ansehen')
                            : ($isEn ? 'View details' : 'Details ansehen');
                    }

                    $href = $slug !== '' ? I18n::url('/reisen/' . rawurlencode($slug), $lang) : I18n::url('/reisen', $lang);

                    if (!empty($item['legacy_pdf_url'])) {
                        $href = (string)$item['legacy_pdf_url'];
                    } elseif (!empty($item['legacy_pdf_path'])) {
                        $href = (string)$item['legacy_pdf_path'];
                    }

                    $badge = trim($statusLabel . ($location !== '' ? ' · ' . $location : ''));
                    ?>
                    <article class="card travel-card">
                        <?php if ($image !== ''): ?>
                            <div class="travel-card__image">
                                <img src="<?= Security::e($image) ?>" alt="<?= Security::e($title) ?>">
                                <?php if ($badge !== ''): ?>
                                    <span class="badge"><?= Security::e($badge) ?></span>
                                <?php endif; ?>
                            </div>
                        <?php elseif ($badge !== ''): ?>
                            <p class="eyebrow"><?= Security::e($badge) ?></p>
                        <?php endif; ?>

                        <div class="travel-card__body">
                            <h2><?= Security::e($title) ?></h2>

                            <?php if ($teaser !== ''): ?>
                                <p><?= Security::e($teaser) ?></p>
                            <?php endif; ?>

                            <div class="travel-card__meta">
                                <?php if ($dateRange !== ''): ?>
                                    <span><?= Security::e($dateRange) ?></span>
                                <?php endif; ?>

                                <a href="<?= Security::e($href) ?>">
                                    <?= Security::e($ctaLabel) ?>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>