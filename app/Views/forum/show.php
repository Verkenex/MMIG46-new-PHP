<?php

use MMIG46\Core\I18n;
use MMIG46\Core\Security;

$topic = $topic ?? null;
$posts = $posts ?? [];
$canWrite = (bool) ($canWrite ?? false);

$formatDate = static function ($value): string {
    if (!$value) {
        return '—';
    }

    $timestamp = strtotime((string) $value);

    if (!$timestamp) {
        return (string) $value;
    }

    return I18n::current() === 'en'
        ? date('j M Y, H:i', $timestamp)
        : date('d.m.Y H:i', $timestamp);
};

$renderForumText = static function ($value): string {
    $html = Security::e((string) $value);
    $html = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $html);
    $html = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $html);
    $html = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $html);

    $blocks = preg_split("/\n{2,}/", trim((string) $html));
    $output = [];

    foreach ($blocks as $block) {
        $block = trim((string) $block);

        if ($block === '') {
            continue;
        }

        if (
            str_starts_with($block, '<h2>')
            || str_starts_with($block, '<h3>')
        ) {
            $output[] = $block;
            continue;
        }

        if (preg_match('/^- /m', $block)) {
            $items = preg_split('/\n/', $block);
            $listItems = [];

            foreach ($items as $item) {
                $item = trim((string) $item);

                if (str_starts_with($item, '- ')) {
                    $listItems[] = '<li>' . substr($item, 2) . '</li>';
                }
            }

            if ($listItems !== []) {
                $output[] = '<ul>' . implode('', $listItems) . '</ul>';
            }

            continue;
        }

        $output[] = '<p>' . nl2br($block) . '</p>';
    }

    return implode("\n", $output);
};
?>

<section class="hero hero-compact">
    <div class="container forum-page-narrow">
        <p class="eyebrow">
            <?= Security::e(I18n::t('forum.eyebrow')) ?>
        </p>

        <?php if (!$topic): ?>
            <h1><?= Security::e(I18n::t('forum.topic_not_found')) ?></h1>
            <p><?= Security::e(I18n::t('forum.topic_not_found_text')) ?></p>
        <?php else: ?>
            <h1><?= Security::e($topic['title'] ?? '') ?></h1>

            <p>
                <?= Security::e(I18n::t('forum.by')) ?>
                <?= Security::e(
                    $topic['author']
                    ?? I18n::t('common.unknown')
                ) ?>
                ·
                <?= Security::e(
                    $formatDate($topic['created_at'] ?? null)
                ) ?>
            </p>
        <?php endif; ?>
    </div>
</section>

<?php if ($topic): ?>
    <section class="section" id="posts">
        <div class="container forum-page-narrow">
            <?php if (empty($posts)): ?>
                <div class="card">
                    <p><?= Security::e(I18n::t('forum.no_posts')) ?></p>
                </div>
            <?php else: ?>
                <div class="forum-post-list">
                    <?php foreach ($posts as $post): ?>
                        <article class="card forum-post">
                            <header class="forum-post__header">
                                <strong>
                                    <?= Security::e(
                                        $post['author']
                                        ?? I18n::t('common.unknown')
                                    ) ?>
                                </strong>

                                <span>
                                    <?= Security::e(
                                        $formatDate($post['created_at'] ?? null)
                                    ) ?>
                                </span>
                            </header>

                            <div class="forum-post__body">
                                <?= $renderForumText($post['body'] ?? '') ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="card forum-form-card" id="reply">
                <?php if ((int) ($topic['is_locked'] ?? 0) === 1): ?>
                    <p><?= Security::e(I18n::t('forum.locked')) ?></p>
                <?php elseif ($canWrite): ?>
                    <form
                        method="post"
                        action="<?= Security::e(
                            I18n::url(
                                '/forum/'
                                . rawurlencode((string) $topic['slug'])
                                . '/antwort'
                            )
                        ) ?>"
                        class="form-stack"
                    >
                        <input
                            type="hidden"
                            name="_csrf"
                            value="<?= Security::e(Security::csrf()) ?>"
                        >

                        <div class="form-field">
                            <label for="body">
                                <?= Security::e(I18n::t('forum.reply_label')) ?>
                            </label>

                            <textarea
                                id="body"
                                name="body"
                                rows="7"
                                minlength="10"
                                required
                            ></textarea>
                        </div>

                        <button class="button" type="submit">
                            <?= Security::e(I18n::t('forum.reply')) ?>
                        </button>
                    </form>
                <?php else: ?>
                    <p><?= Security::e(I18n::t('forum.login_reply')) ?></p>

                    <a
                        class="button button-outline"
                        href="<?= Security::e(I18n::url('/login')) ?>"
                    >
                        <?= Security::e(I18n::t('nav.login')) ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
