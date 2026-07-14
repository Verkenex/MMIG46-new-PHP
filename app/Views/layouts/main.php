<?php

use MMIG46\Core\Security;
use MMIG46\Core\Session;
use MMIG46\Core\I18n;
use MMIG46\Models\SiteSetting;
use MMIG46\Core\Seo;

$lang = I18n::current();
$currentQuery = isset($_GET['q']) ? (string) $_GET['q'] : '';

$isLoggedIn = !empty($_SESSION['user']);
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

$currentUserRole = $_SESSION['user']['role'] ?? '';

$canViewMemberList = $isLoggedIn
    && in_array(
        $currentUserRole,
        ['member', 'moderator', 'admin'],
        true
    );

$siteName = 'MMIG46 e.V.';
$copyrightName = 'MMIG46 e.V.';

try {
    $siteName = SiteSetting::get('site_name', $siteName) ?? $siteName;
    $copyrightName = SiteSetting::get('copyright_name', $copyrightName) ?? $copyrightName;
} catch (Throwable $e) {
    // Fallback, falls die site_settings-Tabelle lokal noch nicht installiert ist.
}

$seo = Seo::metaForCurrentRequest($seo ?? []);

function nav_active(string $path, string $currentPath): string
{
    if ($path === '/') {
        return $currentPath === '/' ? ' is-active' : '';
    }

    return str_starts_with($currentPath, $path) ? ' is-active' : '';
}

$menuLabel = $lang === 'en' ? 'Menu' : 'Menü';
$menuOpenLabel = $lang === 'en' ? 'Open menu' : 'Menü öffnen';
$homeLabel = $lang === 'en' ? 'Home' : 'Startseite';
$mainNavLabel = $lang === 'en' ? 'Main navigation' : 'Hauptnavigation';
$legalNavLabel = $lang === 'en' ? 'Legal information' : 'Rechtliches';
$adminLabel = $lang === 'en' ? 'Administration' : 'Verwaltung';
$memberAreaLabel = $lang === 'en' ? 'Member area' : 'Mitgliederbereich';
?>

<!doctype html>
<html lang="<?= Security::e($lang) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= Security::e($seo['title']) ?></title>
    <meta name="description" content="<?= Security::e($seo['description']) ?>">
    <meta name="robots" content="<?= Security::e($seo['robots']) ?>">
    <link rel="canonical" href="<?= Security::e($seo['canonical']) ?>">

    <meta property="og:locale" content="<?= $lang === 'en' ? 'en_US' : 'de_DE' ?>">
    <meta property="og:site_name" content="<?= Security::e($siteName) ?>">
    <meta property="og:type" content="<?= Security::e($seo['og_type']) ?>">
    <meta property="og:title" content="<?= Security::e($seo['title']) ?>">
    <meta property="og:description" content="<?= Security::e($seo['description']) ?>">
    <meta property="og:url" content="<?= Security::e($seo['canonical']) ?>">
    <meta property="og:image" content="<?= Security::e($seo['og_image']) ?>">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= Security::e($seo['title']) ?>">
    <meta name="twitter:description" content="<?= Security::e($seo['description']) ?>">
    <meta name="twitter:image" content="<?= Security::e($seo['og_image']) ?>">

    <link rel="icon" href="/assets/img/favicon.svg" type="image/svg+xml">
    <?php
    $cssPath = dirname(__DIR__, 3) . '/public/assets/css/app.css';
    $jsPath = dirname(__DIR__, 3) . '/public/assets/js/app.js';

    $cssVersion = is_file($cssPath)
        ? (string) filemtime($cssPath)
        : '20260714';

    $jsVersion = is_file($jsPath)
        ? (string) filemtime($jsPath)
        : '20260714';
    ?>

    <link
        rel="stylesheet"
        href="/assets/css/app.css?v=<?= Security::e($cssVersion) ?>"
    >

    <script
        defer
        src="/assets/js/app.js?v=<?= Security::e($jsVersion) ?>"
    ></script>
</head>
<body>
<header class="site-header">
    <div class="container site-header__inner">
        <a class="brand" href="<?= Security::e(I18n::url('/')) ?>" aria-label="<?= Security::e($siteName . ' ' . $homeLabel) ?>">
            <span><?= Security::e($siteName) ?></span>
        </a>

        <button class="nav-toggle" type="button" data-nav aria-label="<?= Security::e($menuOpenLabel) ?>" aria-expanded="false">
            <?= Security::e($menuLabel) ?>
        </button>

        <nav class="site-nav" aria-label="<?= Security::e($mainNavLabel) ?>">
            <a class="<?= nav_active('/news', $currentPath) ?>" href="<?= Security::e(I18n::url('/news')) ?>">
                <?= Security::e(I18n::t('nav.news')) ?>
            </a>

            <a class="<?= nav_active('/reisen', $currentPath) ?>" href="<?= Security::e(I18n::url('/reisen')) ?>">
                <?= Security::e(I18n::t('nav.travels')) ?>
            </a>

            <a class="<?= nav_active('/malibu-mirage', $currentPath) ?>" href="<?= Security::e(I18n::url('/malibu-mirage')) ?>">
                <?= Security::e(I18n::t('nav.malibu')) ?>
            </a>

            <a class="<?= nav_active('/verein', $currentPath) ?>" href="<?= Security::e(I18n::url('/verein')) ?>">
                <?= Security::e(I18n::t('nav.club')) ?>
            </a>

            <?php if ($canViewMemberList): ?>
                <a class="<?= nav_active('/mitglieder', $currentPath) ?>" href="<?= Security::e(I18n::url('/mitglieder')) ?>">
                    <?= Security::e(I18n::t('nav.members')) ?>
                </a>
            <?php endif; ?>

            <a class="<?= nav_active('/forum', $currentPath) ?>" href="<?= Security::e(I18n::url('/forum')) ?>">
                <?= Security::e(I18n::t('nav.forum')) ?>
            </a>

            <a class="<?= nav_active('/kontakt', $currentPath) ?>" href="<?= Security::e(I18n::url('/kontakt')) ?>">
                <?= Security::e(I18n::t('nav.contact')) ?>
            </a>

            <div class="site-tools">
                <form class="site-search" action="/suche" method="get" role="search">
                    <input type="hidden" name="lang" value="<?= Security::e($lang) ?>">

                    <input
                        type="search"
                        name="q"
                        value="<?= Security::e($currentQuery) ?>"
                        placeholder="<?= Security::e(I18n::t('search.placeholder')) ?>"
                        minlength="2"
                        aria-label="<?= Security::e(I18n::t('search.placeholder')) ?>"
                    >

                    <button type="submit">
                        <?= Security::e(I18n::t('search.button')) ?>
                    </button>
                </form>

                <nav class="language-switch" aria-label="<?= Security::e(I18n::t('language.label')) ?>">
                    <a
                        class="<?= $lang === 'de' ? 'is-active' : '' ?>"
                        href="<?= Security::e(I18n::languageUrl('de')) ?>"
                        hreflang="de"
                        lang="de"
                    >DE</a>

                    <a
                        class="<?= $lang === 'en' ? 'is-active' : '' ?>"
                        href="<?= Security::e(I18n::languageUrl('en')) ?>"
                        hreflang="en"
                        lang="en"
                    >EN</a>
                </nav>
            </div>
        </nav>

        <div class="site-actions">
            <?php if ($isLoggedIn): ?>
                <?php $userRole = $_SESSION['user']['role'] ?? ''; ?>

                <?php if ($userRole === 'admin'): ?>
                    <a class="admin-action" href="<?= Security::e(I18n::url('/verwaltung')) ?>" aria-label="<?= Security::e($adminLabel) ?>">
                        <span aria-hidden="true">⚙</span>
                        <span><?= Security::e($adminLabel) ?></span>
                    </a>
                <?php else: ?>
                    <?php if ($canViewMemberList): ?>
                        <a class="admin-action" href="<?= Security::e(I18n::url('/forum')) ?>" aria-label="<?= Security::e($memberAreaLabel) ?>">
                            <span aria-hidden="true">⚙</span>
                            <span><?= Security::e($memberAreaLabel) ?></span>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>

                <form method="post" action="/logout" class="inline">
                    <input type="hidden" name="_csrf" value="<?= Security::csrf() ?>">
                    <button class="plain-action" type="submit">
                        <?= Security::e(I18n::t('nav.logout')) ?>
                    </button>
                </form>
            <?php else: ?>
                <a class="admin-action" href="<?= Security::e(I18n::url('/login')) ?>" aria-label="<?= Security::e(I18n::t('nav.login')) ?>">
                    <span aria-hidden="true">⚙</span>
                    <span><?= Security::e(I18n::t('nav.login')) ?></span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>

<main>
    <?php if ($m = Session::flash('ok')): ?>
        <div class="container">
            <div class="flash ok"><?= Security::e($m) ?></div>
        </div>
    <?php endif; ?>

    <?php if ($m = Session::flash('error')): ?>
        <div class="container">
            <div class="flash error"><?= Security::e($m) ?></div>
        </div>
    <?php endif; ?>

    <?= $content ?>
</main>

<section class="partner-section" aria-labelledby="partner-section-title">
    <div class="container">
        <div class="partner-section__header">
            <p class="eyebrow">
                <?= $lang === 'en' ? 'Our partners' : 'Unsere Partner' ?>
            </p>

            <h2 id="partner-section-title">
                <?= $lang === 'en'
                    ? 'Strong partners in general aviation'
                    : 'Starke Partner der Allgemeinen Luftfahrt'
                ?>
            </h2>
        </div>

        <div class="partner-grid">
            <a
                class="partner-card partner-card--piper"
                href="https://www.piper-germany.de/"
                target="_blank"
                rel="noopener noreferrer sponsored"
                aria-label="<?= $lang === 'en'
                    ? 'Visit Piper Germany'
                    : 'Piper Deutschland besuchen'
                ?>"
            >
                <div class="partner-card__visual">
                    <img
                        src="/assets/img/partners/piper-deutschland-m600.webp"
                        alt="<?= $lang === 'en'
                            ? 'Piper M-Class aircraft'
                            : 'Flugzeug der Piper M-Class'
                        ?>"
                        loading="lazy"
                        width="1536"
                        height="728"
                    >
                </div>

                <div class="partner-card__content">
                    <span class="partner-card__label">
                        <?= $lang === 'en'
                            ? 'Aircraft · Maintenance · Parts'
                            : 'Flugzeuge · Wartung · Ersatzteile'
                        ?>
                    </span>

                    <h3>Piper Deutschland</h3>

                    <p>
                        <?= $lang === 'en'
                            ? 'Exclusive Piper dealer for Germany, Austria, Switzerland and Türkiye.'
                            : 'Exklusiver Piper-Händler für Deutschland, Österreich, die Schweiz und die Türkei.'
                        ?>
                    </p>

                    <span class="partner-card__link">
                        <?= $lang === 'en'
                            ? 'Discover Piper Germany →'
                            : 'Piper Deutschland entdecken →'
                        ?>
                    </span>
                </div>
            </a>

            <a
                class="partner-card partner-card--ras"
                href="https://ras.de/"
                target="_blank"
                rel="noopener noreferrer sponsored"
                aria-label="<?= $lang === 'en'
                    ? 'Visit Rheinland Air Service'
                    : 'Rheinland Air Service besuchen'
                ?>"
            >
                <div class="partner-card__visual">
                    <img
                        src="/assets/img/partners/ras-hangar.jpg"
                        alt="<?= $lang === 'en'
                            ? 'Rheinland Air Service hangars'
                            : 'Hangars von Rheinland Air Service'
                        ?>"
                        loading="lazy"
                        width="1000"
                        height="635"
                    >
                </div>

                <div class="partner-card__content">
                    <span class="partner-card__label">
                        <?= $lang === 'en'
                            ? 'MRO · Aircraft sales · AOG service'
                            : 'MRO · Flugzeugverkauf · AOG-Service'
                        ?>
                    </span>

                    <h3>Rheinland Air Service</h3>

                    <p>
                        <?= $lang === 'en'
                            ? 'Maintenance, repair, aircraft sales and comprehensive support for business aviation.'
                            : 'Wartung, Reparatur, Flugzeugverkauf und umfassender Service für die Business Aviation.'
                        ?>
                    </p>

                    <span class="partner-card__link">
                        <?= $lang === 'en'
                            ? 'Discover RAS →'
                            : 'RAS entdecken →'
                        ?>
                    </span>
                </div>
            </a>
        </div>

        <p class="partner-section__notice">
            <?= $lang === 'en'
                ? 'Advertisement · External partner websites'
                : 'Werbung · Externe Websites unserer Partner'
            ?>
        </p>
    </div>
</section>


<footer class="site-footer">
    <div class="container site-footer__inner">
        <nav class="footer-links" aria-label="<?= Security::e($legalNavLabel) ?>">
            <a href="<?= Security::e(I18n::url('/malibu-mirage')) ?>">
                <?= Security::e(I18n::t('nav.malibu')) ?>
            </a>

            <a href="<?= Security::e(I18n::url('/impressum')) ?>">
                <?= Security::e(I18n::t('nav.legal')) ?>
            </a>

            <a href="<?= Security::e(I18n::url('/datenschutz')) ?>">
                <?= Security::e(I18n::t('nav.privacy')) ?>
            </a>

            <a href="<?= Security::e(I18n::url('/agb')) ?>">
                <?= Security::e(I18n::t('nav.terms')) ?>
            </a>
        </nav>

        <p>
            © <?= date('Y') ?> <?= Security::e($copyrightName) ?>.
            <?= Security::e(I18n::t('cookie.text')) ?>
            <a href="<?= Security::e(I18n::url('/datenschutz')) ?>">
                <?= Security::e(I18n::t('nav.privacy')) ?>
            </a>.
        </p>
    </div>
</footer>

<div id="cookie" class="cookie">
    <p><?= Security::e(I18n::t('cookie.text')) ?></p>
    <button type="button" data-cookie>
        <?= Security::e(I18n::t('cookie.accept')) ?>
    </button>
</div>

<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$isTrainingPage = $currentPath === '/trainingswochenende-2026';
?>

<?php if (!$isTrainingPage): ?>
    <div class="event-popup"
         id="training-weekend-popup"
         hidden
         role="dialog"
         aria-modal="true"
         aria-labelledby="training-popup-title">

        <div class="event-popup__backdrop"
             data-close-training-popup></div>

        <div class="event-popup__dialog">
            <button type="button"
                    class="event-popup__close"
                    aria-label="<?= I18n::current() === 'en'
                        ? 'Close'
                        : 'Schließen' ?>"
                    data-close-training-popup>
                ×
            </button>

            <p class="event-popup__eyebrow">
                <?= I18n::current() === 'en'
                    ? '25–26 September 2026 · EDLN'
                    : '25.–26. September 2026 · EDLN' ?>
            </p>

            <h2 id="training-popup-title">
                <?= I18n::current() === 'en'
                    ? 'MMIG46 Training Weekend'
                    : 'MMIG46 Trainingswochenende' ?>
            </h2>

            <p>
                <?= I18n::current() === 'en'
                    ? 'Use it or lose it: Two days of practical PA46 training, IFR refresher sessions, avionics and proficiency checks.'
                    : 'Use it or lose it: Zwei Tage praktische PA46-Trainings, IFR-Refresher, Avionik und Checkflüge.' ?>
            </p>

            <p>
                <strong>
                    <?= I18n::current() === 'en'
                        ? 'Limited capacity – first come, first served.'
                        : 'Begrenzte Kapazitäten – first come, first served.' ?>
                </strong>
            </p>

            <a class="button button--primary"
               href="<?= I18n::url(
                   '/trainingswochenende-2026'
               ) ?>">
                <?= I18n::current() === 'en'
                    ? 'View programme and register'
                    : 'Programm ansehen und anmelden' ?>
            </a>
        </div>
    </div>
<?php endif; ?>

</body>
</html>