<?php

namespace MMIG46\Services;

class Markdown
{
    public static function toHtml(string $text): string
    {
        $text = trim($text);

        if ($text === '') {
            return '';
        }

        $escaped = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

        $paragraphs = preg_split("/\n\s*\n/", $escaped);

        $html = [];

        foreach ($paragraphs as $paragraph) {
            $paragraph = trim($paragraph);

            if ($paragraph === '') {
                continue;
            }

            $paragraph = nl2br($paragraph);
            $html[] = '<p>' . $paragraph . '</p>';
        }

        return implode("\n", $html);
    }
}