<?php

use MMIG46\Core\Security;
use MMIG46\Core\Session;
use MMIG46\Core\I18n;
use MMIG46\Models\SiteSetting;

$lang = I18n::current();
$currentQuery = isset($_GET['q']) ? (string) $_GET['q'] : '';

$isLoggedIn = !empty($_SESSION['user']);
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

$siteName = 'MMIG46 e.V.';
$copyrightName = 'MMIG46 e.V.';

try {
    $siteName = SiteSetting::get('site_name', $siteName) ?? $siteName;
    $copyrightName = SiteSetting::get('copyright_name', $copyrightName) ?? $copyrightName;
} catch (Throwable $e) {
    // Fallback, falls die site_settings-Tabelle lokal noch nicht installiert ist.
}

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
    <title><?= Security::e($siteName) ?></title>
    <link rel="icon" href="/assets/img/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="/assets/css/app.css">
    <script defer src="/assets/js/app.js"></script>
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

            <a class="<?= nav_active('/mitglieder', $currentPath) ?>" href="<?= Security::e(I18n::url('/mitglieder')) ?>">
                <?= Security::e(I18n::t('nav.members')) ?>
            </a>

            <a class="<?= nav_active('/forum', $currentPath) ?>" href="<?= Security::e(I18n::url('/forum')) ?>">
                <?= Security::e(I18n::t('nav.forum')) ?>
            </a>

            <a class="<?= nav_active('/kontakt', $currentPath) ?>" href="<?= Security::e(I18n::url('/kontakt')) ?>">
                <?= Security::e(I18n::t('nav.contact')) ?>
            </a>

            <form class="site-search" action="/suche" method="get" role="search">
                <input
                    type="search"
                    name="q"
                    value="<?= Security::e($currentQuery) ?>"
                    placeholder="<?= Security::e(I18n::t('search.placeholder')) ?>"
                    minlength="2"
                    aria-label="<?= Security::e(I18n::t('search.placeholder')) ?>"
                >

                <select name="lang" aria-label="<?= Security::e(I18n::t('language.label')) ?>">
                    <option value="de" <?= $lang === 'de' ? 'selected' : '' ?>>
                        <?= Security::e(I18n::t('language.de')) ?>
                    </option>
                    <option value="en" <?= $lang === 'en' ? 'selected' : '' ?>>
                        <?= Security::e(I18n::t('language.en')) ?>
                    </option>
                </select>

                <button type="submit">
                    <?= Security::e(I18n::t('search.button')) ?>
                </button>
            </form>
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
                    <a class="admin-action" href="<?= Security::e(I18n::url('/forum')) ?>" aria-label="<?= Security::e($memberAreaLabel) ?>">
                        <span aria-hidden="true">⚙</span>
                        <span><?= Security::e($memberAreaLabel) ?></span>
                    </a>
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
</body>
</html>