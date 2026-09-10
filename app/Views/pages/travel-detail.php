<?php
/** @var array $item */
/** @var string $bodyHtml */
use MMIG46\Core\Security;
use MMIG46\Core\I18n;
$seo = [
    'title'=>(string)($item['title']??'MMIG46'),
    'description'=>(string)($item['teaser']??''),
    'structured_data'=>['@context'=>'https://schema.org','@type'=>'Event','name'=>(string)($item['title']??''),'startDate'=>$item['starts_on']??null,'endDate'=>$item['ends_on']??null,'eventStatus'=>'https://schema.org/EventScheduled','location'=>['@type'=>'Place','name'=>(string)($item['location']??'')],'organizer'=>['@id'=>\MMIG46\Core\Seo::absoluteUrl('/').'#organization'],'inLanguage'=>$lang],
];
$travelAlternates=[];
foreach(['de','en'] as $candidateLang) if(\MMIG46\Models\TravelItem::findPublishedBySlug((string)$item['slug'],$candidateLang)) $travelAlternates[$candidateLang]=\MMIG46\Core\Seo::canonicalUrl('/reisen/'.(string)$item['slug'],$candidateLang);
if(isset($travelAlternates['de'])) $travelAlternates['x-default']=$travelAlternates['de'];
$seo['alternates']=$travelAlternates;
?>

<article class="content-page travel-detail">
    <header class="page-header">
        <p class="eyebrow"><?= $lang === 'en' ? 'Fly-ins & Trips' : 'Reisen' ?></p>
        <h1><?= Security::e($item['title'] ?? '') ?></h1>

        <?php if (!empty($item['location'])): ?>
            <p><?= Security::e($item['location']) ?></p>
        <?php endif; ?>

        <?php if (!empty($item['starts_on'])): ?>
            <p>
                <?= Security::e($item['starts_on']) ?>
                <?php if (!empty($item['ends_on']) && $item['ends_on'] !== $item['starts_on']): ?>
                    – <?= Security::e($item['ends_on']) ?>
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </header>

    <?php if (!empty($item['image_path'])): ?>
        <img src="<?= Security::e($item['image_path']) ?>" alt="<?= Security::e($item['title'] ?? '') ?>" class="hero-image">
    <?php endif; ?>

    <div class="content-body">
        <?= $bodyHtml ?>
    </div>

    <?php if (!empty($item['legacy_pdf_url'])): ?>
        <p>
            <a class="button" href="<?= Security::e($item['legacy_pdf_url']) ?>" target="_blank" rel="noopener">
                <?= Security::e($item['cta_label'] ?: ($lang === 'en' ? 'Open PDF' : 'PDF öffnen')) ?>
            </a>
        </p>
    <?php endif; ?>

    <?php if (!empty($item['legacy_pdf_path'])): ?>
        <p>
            <a class="button" href="<?= Security::e($item['legacy_pdf_path']) ?>">
                <?= Security::e($item['cta_label'] ?: ($lang === 'en' ? 'Open PDF' : 'PDF öffnen')) ?>
            </a>
        </p>
    <?php endif; ?>
</article>
