<?php

use MMIG46\Core\Security;
use MMIG46\Core\Session;
use MMIG46\Models\SiteSetting;

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
?>

<!doctype html>
<html lang="de">
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
        <a class="brand" href="/" aria-label="<?= Security::e($siteName) ?> Startseite">
            <span><?= Security::e($siteName) ?></span>
        </a>

        <button class="nav-toggle" type="button" data-nav aria-label="Menü öffnen">
            Menü
        </button>

        <nav class="site-nav" aria-label="Hauptnavigation">
            <a class="<?= nav_active('/news', $currentPath) ?>" href="/news">News</a>
            <a class="<?= nav_active('/reisen', $currentPath) ?>" href="/reisen">Reisen</a>
            <a class="<?= nav_active('/verein', $currentPath) ?>" href="/verein">Verein</a>
            <a class="<?= nav_active('/memberlist', $currentPath) ?>" href="/memberlist">Memberlist</a>
            <a class="<?= nav_active('/forum', $currentPath) ?>" href="/forum">Forum</a>
            <a class="<?= nav_active('/kontakt', $currentPath) ?>" href="/kontakt">Kontakt</a>
        </nav>

        <div class="site-actions">
            <?php if ($isLoggedIn): ?>
                <form method="post" action="/logout" class="inline">
                    <input type="hidden" name="_csrf" value="<?= Security::csrf() ?>">
                    <button class="plain-action" type="submit">Logout</button>
                </form>
            <?php else: ?>
                <a class="plain-action" href="/login">Login</a>
            <?php endif; ?>

            <a class="admin-action" href="/verwaltung">
                <span aria-hidden="true">⚙</span>
                <span>Verwaltung</span>
            </a>
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
        <nav class="footer-links" aria-label="Rechtliches">
            <a href="/impressum">Impressum</a>
            <a href="/datenschutz">Datenschutz</a>
            <a href="/agb">AGB</a>
        </nav>

        <p>
            © <?= date('Y') ?> <?= Security::e($copyrightName) ?>.
            Diese Website verwendet notwendige Session-Cookies.
            Mehr Informationen finden Sie in der
            <a href="/datenschutz">Datenschutzerklärung</a>.
        </p>
    </div>
</footer>

<div id="cookie" class="cookie">
    <p>Wir verwenden nur notwendige Session-Cookies. Tracking/Marketing ist standardmäßig deaktiviert.</p>
    <button type="button" data-cookie>Verstanden</button>
</div>
</body>
</html>