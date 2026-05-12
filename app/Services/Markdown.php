<?php
namespace MMIG46\Services;
final class Markdown {
    public static function render(string $text): string {
        if (class_exists('Parsedown')) { $p = new \Parsedown(); $p->setSafeMode(true); return $p->text($text); }
        return nl2br(htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
    }
}
