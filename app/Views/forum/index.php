<?php

$topics = $topics ?? [];
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

    return date('d.m.Y', $timestamp);
};
?>

<section class="hero hero-compact">
    <div class="container">
        <p class="eyebrow">Forum</p>
        <h1>Austausch für Mitglieder und PA46-Interessierte.</h1>
        <p>Fragen, Erfahrungsberichte und Hinweise rund um Reisen, Betrieb, Technik und Vereinsleben.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="card">
            <div class="section-head">
                <h2>Aktuelle Themen</h2>

                <?php if ($canWrite): ?>
                    <a class="button button-outline" href="/forum/neu">Beitrag erstellen</a>
                <?php else: ?>
                    <a class="button button-outline" href="/login">Einloggen zum Schreiben</a>
                <?php endif; ?>
            </div>

            <?php if (empty($topics)): ?>
                <p>Es gibt aktuell noch keine Themen.</p>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="forum-table">
                        <thead>
                            <tr>
                                <th>Thema</th>
                                <th>Autor</th>
                                <th>Antworten</th>
                                <th>Letzter Beitrag</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($topics as $topic): ?>
                                <tr>
                                    <td>
                                        <a href="/forum/<?= $e($topic['slug']) ?>">
                                            <?= $e($topic['title']) ?>
                                        </a>
                                    </td>
                                    <td><?= $e($topic['author'] ?? 'Unbekannt') ?></td>
                                    <td><?= max(0, (int) ($topic['reply_count'] ?? 1) - 1) ?></td>
                                    <td><?= $e($formatDate($topic['updated_at'] ?: $topic['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
