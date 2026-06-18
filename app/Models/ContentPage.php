public function contentPage(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $slug = trim((string)$path, '/');

    if (in_array($slug, ['verein', 'impressum', 'datenschutz', 'agb'], true)) {
        http_response_code(404);
        return View::render('errors/404');
    }

    $lang = I18n::current();
    $page = ContentPage::findPublishedBySlug($slug, $lang);

    if (!$page && $lang !== 'de') {
        $page = ContentPage::findPublishedBySlug($slug, 'de');
    }

    if (!$page) {
        http_response_code(404);
        return View::render('errors/404');
    }

    return View::render('pages/content', [
        'page' => $page,
        'bodyHtml' => Markdown::toHtml($page['body'] ?? ''),
        'lang' => $lang,
    ]);
}