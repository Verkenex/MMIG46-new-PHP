<?php

$topic = $topic ?? null;
$posts = $posts ?? [];
$canWrite = (bool) ($canWrite ?? false);

$e = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

$formatDate = static function ($value): string {
    if (!$value) {
        return '-';
    }

    $timestamp = strtotime((string) $value);

    if (!$timestamp) {
        return (string) $value;
    }

    return date('d.m.Y H:i', $timestamp);
};

$renderForumText = static function ($value) use ($e): string {
    $text = (string) $value;

    $html = $e($text);

    $html = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $html);
    $html = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $html);

    $html = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $html);

    $blocks = preg_split("/\n{2,}/", trim((string) $html));
    $out = [];

    foreach ($blocks as $block) {
        $block = trim($block);

        if ($block === '') {
            continue;
        }

        if (str_starts_with($block, '<h2>') || str_starts_with($block, '<h3>')) {
            $out[] = $block;
            continue;
        }

        if (preg_match('/^- /m', $block)) {
            $items = preg_split('/\n/', $block);
            $lis = [];

            foreach ($items as $item) {
                $item = trim((string) $item);

                if (str_starts_with($item, '- ')) {
                    $lis[] = '<li>' . substr($item, 2) . '</li>';
                }
            }

            if ($lis) {
                $out[] = '<ul>' . implode('', $lis) . '</ul>';
            }

            continue;
        }

        $out[] = '<p>' . nl2br($block) . '</p>';
    }

    return implode("\n", $out);
};
?>

<section class="hero hero-compact">
    <div class="container forum-page-narrow">
        <p class="eyebrow">Forum</p>

        <?php if (!$topic): ?>
            <h1>Thema nicht gefunden</h1>
            <p>Das angeforderte Forumsthema existiert nicht oder wurde entfernt.</p>
        <?php else: ?>
            <h1><?= $e($topic['title']) ?></h1>
            <p>
                Von <?= $e($topic['author'] ?? 'Unbekannt') ?>
                · <?= $e($formatDate($topic['created_at'] ?? null)) ?>
            </p>
        <?php endif; ?>
    </div>
</section>

<section class="section">
    <div class="container forum-page-narrow">
        <p class="back-link">
            <a href="/forum">← Zurück zur Übersicht</a>
        </p>

        <?php if ($topic): ?>
            <div class="forum-thread">
                <?php foreach ($posts as $post): ?>
                    <article class="card forum-card forum-post">
                        <div class="forum-post-meta">
                            <strong><?= $e($post['author'] ?? 'Unbekannt') ?></strong>
                            <span>· <?= $e($formatDate($post['created_at'] ?? null)) ?></span>
                        </div>

                        <div class="forum-post-body">
                            <?= $renderForumText($post['body'] ?? '') ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php if ((int) ($topic['is_locked'] ?? 0) === 1): ?>
                <div class="card forum-card">
                    <h2>Thema geschlossen</h2>
                    <p>Zu diesem Thema können keine weiteren Antworten geschrieben werden.</p>
                </div>
            <?php elseif ($canWrite): ?>
                <div class="card forum-card forum-form-card">
                    <h2>Antwort schreiben</h2>

                    <form method="post" action="/forum/<?= $e($topic['slug']) ?>/antwort" class="form-stack">
                        <div class="form-field">
                            <label for="body">Antwort</label>
                            <textarea id="body" name="body" rows="8" required></textarea>
                        </div>

                        <div class="form-actions">
                            <button class="button" type="submit">Antwort veröffentlichen</button>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div class="card forum-card forum-login-callout">
                    <div>
                        <h2>Antwort schreiben</h2>
                        <p>Zum Antworten müssen Sie als Vereinsmitglied angemeldet sein.</p>
                    </div>

                    <a class="button button-outline" href="/login">Einloggen</a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
