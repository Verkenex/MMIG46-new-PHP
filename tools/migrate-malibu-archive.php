<?php

declare(strict_types=1);

$root = dirname(__DIR__);

$targetDir = $root . '/storage/malibu-archive';

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0775, true);
}

$articles = [
    'kansas-to-kruger' => [
        'url' => 'https://mmig46.de/org/malibumirage/kansassouthafrica/index.html',
        'title' => 'Piper Malibu JetPROP from Kansas to Kruger',
    ],
    'ultimate-piston-single' => [
        'url' => 'https://mmig46.de/org/malibumirage/ultimatepiston/index.html',
        'title' => 'The Ultimate Piston Single?',
    ],
    'pipers-perfection' => [
        'url' => 'https://mmig46.de/org/malibumirage/pipersperfection/index.html',
        'title' => 'Piper’s Perfection?',
    ],
    'optimum-flight-levels' => [
        'url' => 'https://mmig46.de/org/malibumirage/optimumflightlevels/index.html',
        'title' => 'Optimum Flight Levels',
    ],
    '100th-jetprop' => [
        'url' => 'https://mmig46.de/org/malibumirage/100th/index.html',
        'title' => 'I picked up the 100th JetPROP',
    ],
];

foreach ($articles as $slug => $article) {
    $html = fetchUrl($article['url']);

    if ($html === '') {
        fwrite(STDERR, "Failed to fetch {$article['url']}\n");
        continue;
    }

    $fragment = extractMainContent($html, $article['title']);
    $fragment = normalizeFragment($fragment, $article['url']);

    $targetFile = $targetDir . '/' . $slug . '.html';
    file_put_contents($targetFile, $fragment);

    echo "Wrote {$targetFile}\n";
}

function fetchUrl(string $url): string
{
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'timeout' => 20,
            'header' => implode("\r\n", [
                'User-Agent: MMIG46 archive migration',
                'Accept: text/html,application/xhtml+xml',
            ]),
        ],
        'ssl' => [
            'verify_peer' => true,
            'verify_peer_name' => true,
        ],
    ]);

    $html = @file_get_contents($url, false, $context);

    if ($html === false) {
        return '';
    }

    return $html;
}

function extractMainContent(string $html, string $expectedTitle): string
{
    libxml_use_internal_errors(true);

    $dom = new DOMDocument();

    $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
    $dom->loadHTML($html);

    $xpath = new DOMXPath($dom);

    $candidates = [
        '//main',
        '//*[@id="content"]',
        '//*[@class[contains(., "content")]]',
        '//*[@class[contains(., "item-page")]]',
        '//*[@class[contains(., "blog")]]',
        '//body',
    ];

    foreach ($candidates as $query) {
        $nodes = $xpath->query($query);

        if ($nodes === false || $nodes->length === 0) {
            continue;
        }

        foreach ($nodes as $node) {
            $text = trim($node->textContent ?? '');

            if ($text !== '' && stripos($text, $expectedTitle) !== false) {
                return innerHtml($dom, $node);
            }
        }
    }

    $body = $xpath->query('//body')->item(0);

    if ($body) {
        return innerHtml($dom, $body);
    }

    return $html;
}

function normalizeFragment(string $html, string $sourceUrl): string
{
    $html = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $html) ?? $html;
    $html = preg_replace('/<style\b[^>]*>.*?<\/style>/is', '', $html) ?? $html;
    $html = preg_replace('/<nav\b[^>]*>.*?<\/nav>/is', '', $html) ?? $html;
    $html = preg_replace('/<footer\b[^>]*>.*?<\/footer>/is', '', $html) ?? $html;

    $html = preg_replace('/\sclass="[^"]*"/i', '', $html) ?? $html;
    $html = preg_replace('/\sid="[^"]*"/i', '', $html) ?? $html;
    $html = preg_replace('/\sstyle="[^"]*"/i', '', $html) ?? $html;

    $base = dirname($sourceUrl) . '/';

    $html = preg_replace_callback(
        '/\s(src|href)="(?!https?:\/\/|mailto:|tel:|\/|#)([^"]+)"/i',
        static function (array $matches) use ($base): string {
            return ' ' . $matches[1] . '="' . htmlspecialchars($base . $matches[2], ENT_QUOTES, 'UTF-8') . '"';
        },
        $html
    ) ?? $html;

    $html = trim($html);

    return <<<HTML
<div class="legacy-article-fragment">
{$html}
</div>

HTML;
}

function innerHtml(DOMDocument $dom, DOMNode $node): string
{
    $html = '';

    foreach ($node->childNodes as $child) {
        $html .= $dom->saveHTML($child);
    }

    return $html;
}