<?php

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

        $blocks = preg_split("/\n{2,}/", $markdown);
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

            if (str_starts_with($block, '# ')) {
                $html[] = '<h1>' . self::inline(substr($block, 2)) . '</h1>';
                continue;
            }

            $html[] = '<p>' . self::inline($block) . '</p>';
        }

        return implode("\n", $html);
    }

    private static function inline(string $text): string
    {
        $escaped = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

        $escaped = preg_replace_callback(
            '/\[([^\]]+)\]\(([^)]+)\)/',
            static function (array $matches): string {
                $label = htmlspecialchars($matches[1], ENT_QUOTES, 'UTF-8');
                $url = htmlspecialchars($matches[2], ENT_QUOTES, 'UTF-8');

                return '<a href="' . $url . '" target="_blank" rel="noopener noreferrer">' . $label . '</a>';
            },
            $escaped
        );

        return nl2br($escaped);
    }
}