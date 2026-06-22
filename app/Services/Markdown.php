<?php

declare(strict_types=1);

namespace MMIG46\Services;

final class Markdown
{
    public static function toHtml(string $markdown): string
    {
        $markdown = trim($markdown);

        if ($markdown === '') {
            return '';
        }

        $markdown = str_replace(["\r\n", "\r"], "\n", $markdown);

        $blocks = preg_split("/\n{2,}/", $markdown) ?: [];
        $html = [];

        foreach ($blocks as $block) {
            $block = trim($block);

            if ($block === '') {
                continue;
            }

            if (str_starts_with($block, '### ')) {
                $html[] = '<h3>' . self::inline(substr($block, 4)) . '</h3>';
                continue;
            }

            if (str_starts_with($block, '## ')) {
                $html[] = '<h2>' . self::inline(substr($block, 3)) . '</h2>';
                continue;
            }

            /*
             * Deliberately map "# Heading" to h2 instead of h1.
             * Public pages should normally have one h1 from the template/page title.
             */
            if (str_starts_with($block, '# ')) {
                $html[] = '<h2>' . self::inline(substr($block, 2)) . '</h2>';
                continue;
            }

            if (self::isUnorderedList($block)) {
                $html[] = self::unorderedList($block);
                continue;
            }

            if (self::isOrderedList($block)) {
                $html[] = self::orderedList($block);
                continue;
            }

            $html[] = '<p>' . self::inline($block) . '</p>';
        }

        return implode("\n", $html);
    }

    private static function inline(string $text): string
    {
        /*
         * Important:
         * Escape first. This prevents raw HTML such as <script>, <img onerror>,
         * <iframe>, inline event handlers, and arbitrary tags from becoming HTML.
         */
        $escaped = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        /*
         * Images:
         * ![Alt text](https://example.com/image.jpg)
         * ![Alt text](/assets/img/example.jpg)
         */
        $escaped = preg_replace_callback(
            '/!\[([^\]]*)\]\(([^)\s]+)(?:\s+"([^"]*)")?\)/',
            static function (array $matches): string {
                $alt = htmlspecialchars_decode($matches[1], ENT_QUOTES);
                $url = htmlspecialchars_decode($matches[2], ENT_QUOTES);
                $title = isset($matches[3]) ? htmlspecialchars_decode($matches[3], ENT_QUOTES) : '';

                if (!self::isSafeUrl($url)) {
                    return self::escape($alt);
                }

                $html = '<img src="' . self::escape($url) . '" alt="' . self::escape($alt) . '" loading="lazy" decoding="async"';

                if ($title !== '') {
                    $html .= ' title="' . self::escape($title) . '"';
                }

                $html .= '>';

                return $html;
            },
            $escaped
        );

        /*
         * Links:
         * [Label](https://example.com)
         * [Label](/interne-seite)
         * [Label](mailto:test@example.com)
         */
        $escaped = preg_replace_callback(
            '/\[([^\]]+)\]\(([^)\s]+)(?:\s+"([^"]*)")?\)/',
            static function (array $matches): string {
                $label = htmlspecialchars_decode($matches[1], ENT_QUOTES);
                $url = htmlspecialchars_decode($matches[2], ENT_QUOTES);
                $title = isset($matches[3]) ? htmlspecialchars_decode($matches[3], ENT_QUOTES) : '';

                if (!self::isSafeUrl($url)) {
                    return self::escape($label);
                }

                $isExternal = self::isExternalUrl($url);

                $html = '<a href="' . self::escape($url) . '"';

                if ($title !== '') {
                    $html .= ' title="' . self::escape($title) . '"';
                }

                if ($isExternal) {
                    $html .= ' target="_blank" rel="noopener noreferrer"';
                }

                $html .= '>' . self::escape($label) . '</a>';

                return $html;
            },
            $escaped
        );

        /*
         * Inline code before bold/italic would be cleaner, but this small parser
         * intentionally stays conservative.
         */
        $escaped = preg_replace('/`([^`]+)`/', '<code>$1</code>', $escaped);

        /*
         * Bold and italic.
         */
        $escaped = preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $escaped);
        $escaped = preg_replace('/__([^_]+)__/', '<strong>$1</strong>', $escaped);
        $escaped = preg_replace('/\*([^*]+)\*/', '<em>$1</em>', $escaped);
        $escaped = preg_replace('/_([^_]+)_/', '<em>$1</em>', $escaped);

        return nl2br($escaped, false);
    }

    private static function unorderedList(string $block): string
    {
        $items = preg_split("/\n/", $block) ?: [];
        $html = ['<ul>'];

        foreach ($items as $item) {
            $item = trim($item);

            if (!preg_match('/^[-*]\s+(.+)$/', $item, $matches)) {
                continue;
            }

            $html[] = '<li>' . self::inline($matches[1]) . '</li>';
        }

        $html[] = '</ul>';

        return implode("\n", $html);
    }

    private static function orderedList(string $block): string
    {
        $items = preg_split("/\n/", $block) ?: [];
        $html = ['<ol>'];

        foreach ($items as $item) {
            $item = trim($item);

            if (!preg_match('/^\d+\.\s+(.+)$/', $item, $matches)) {
                continue;
            }

            $html[] = '<li>' . self::inline($matches[1]) . '</li>';
        }

        $html[] = '</ol>';

        return implode("\n", $html);
    }

    private static function isUnorderedList(string $block): bool
    {
        $lines = preg_split("/\n/", $block) ?: [];

        foreach ($lines as $line) {
            if (!preg_match('/^\s*[-*]\s+.+$/', $line)) {
                return false;
            }
        }

        return $lines !== [];
    }

    private static function isOrderedList(string $block): bool
    {
        $lines = preg_split("/\n/", $block) ?: [];

        foreach ($lines as $line) {
            if (!preg_match('/^\s*\d+\.\s+.+$/', $line)) {
                return false;
            }
        }

        return $lines !== [];
    }

    private static function isSafeUrl(string $url): bool
    {
        $url = html_entity_decode($url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $url = trim(str_replace(["\r", "\n", "\t", "\0"], '', $url));

        if ($url === '') {
            return false;
        }

        /*
         * Relative fragment or path.
         */
        if (str_starts_with($url, '#') || str_starts_with($url, '/')) {
            return true;
        }

        /*
         * Relative URL without scheme, e.g. news/example.
         */
        $scheme = parse_url($url, PHP_URL_SCHEME);

        if ($scheme === null) {
            return !str_contains($url, ':');
        }

        return in_array(strtolower($scheme), ['http', 'https', 'mailto'], true);
    }

    private static function isExternalUrl(string $url): bool
    {
        $scheme = parse_url($url, PHP_URL_SCHEME);

        return in_array(strtolower((string)$scheme), ['http', 'https'], true);
    }

    private static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}