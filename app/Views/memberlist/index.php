<?php

use MMIG46\Core\I18n;
use MMIG46\Core\Security;

$members = is_array($members ?? null) ? $members : [];

$lang = I18n::current();
$isEnglish = $lang === 'en';

$labels = $isEnglish
    ? [
        'eyebrow' => 'MMIG46',
        'name' => 'Name',
        'aircraft' => 'Aircraft',
        'base' => 'Home airport',
        'role' => 'Role',
        'membership' => 'Membership',
        'website' => 'Website',
        'open_website' => 'Open website',
        'not_available' => '—',
    ]
    : [
        'eyebrow' => 'MMIG46',
        'name' => 'Name',
        'aircraft' => 'Flugzeug',
        'base' => 'Heimatflugplatz',
        'role' => 'Rolle',
        'membership' => 'Mitgliedschaft',
        'website' => 'Website',
        'open_website' => 'Website öffnen',
        'not_available' => '—',
    ];

?>

<section class="page memberlist-page">
    <p class="eyebrow">
        <?= Security::e($labels['eyebrow']) ?>
    </p>

    <h1>
        <?= Security::e(I18n::t('members.title')) ?>
    </h1>

    <p class="meta">
        <?= Security::e(I18n::t('members.intro')) ?>
    </p>

    <?php if ($members === []): ?>
        <div class="empty-state">
            <h2>
                <?= Security::e(I18n::t('members.empty_title')) ?>
            </h2>

            <p>
                <?= Security::e(I18n::t('members.empty_text')) ?>
            </p>
        </div>
    <?php else: ?>
        <div class="table memberlist-table-wrap">
            <table class="memberlist-table">
                <thead>
                    <tr>
                        <th scope="col">
                            <?= Security::e($labels['name']) ?>
                        </th>

                        <th scope="col">
                            <?= Security::e(I18n::t('members.aircraft')) ?>
                        </th>

                        <th scope="col">
                            <?= Security::e(I18n::t('members.base')) ?>
                        </th>

                        <th scope="col">
                            <?= Security::e(I18n::t('members.role')) ?>
                        </th>

                        <th scope="col">
                            <?= Security::e(I18n::t('members.membership')) ?>
                        </th>

                        <th scope="col">
                            <?= Security::e(I18n::t('common.website')) ?>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($members as $member): ?>
                        <?php
                        $name = trim((string) ($member['name'] ?? ''));
                        $aircraft = trim((string) ($member['aircraft'] ?? ''));
                        $base = trim((string) ($member['base'] ?? ''));
                        $role = trim((string) ($member['role_label'] ?? ''));
                        $membership = trim((string) ($member['member_type'] ?? ''));
                        $website = trim((string) ($member['website'] ?? ''));
                        ?>

                        <tr>
                            <td data-label="<?= Security::e($labels['name']) ?>">
                                <?= Security::e(
                                    $name !== ''
                                        ? $name
                                        : $labels['not_available']
                                ) ?>
                            </td>

                            <td data-label="<?= Security::e($labels['aircraft']) ?>">
                                <?= Security::e(
                                    $aircraft !== ''
                                        ? $aircraft
                                        : $labels['not_available']
                                ) ?>
                            </td>

                            <td data-label="<?= Security::e($labels['base']) ?>">
                                <?= Security::e(
                                    $base !== ''
                                        ? $base
                                        : $labels['not_available']
                                ) ?>
                            </td>

                            <td data-label="<?= Security::e($labels['role']) ?>">
                                <?= Security::e(
                                    $role !== ''
                                        ? $role
                                        : $labels['not_available']
                                ) ?>
                            </td>

                            <td data-label="<?= Security::e($labels['membership']) ?>">
                                <?= Security::e(
                                    $membership !== ''
                                        ? $membership
                                        : $labels['not_available']
                                ) ?>
                            </td>

                            <td data-label="<?= Security::e($labels['website']) ?>">
                                <?php if ($website !== ''): ?>
                                    <a
                                        href="<?= Security::e($website) ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        aria-label="<?= Security::e(
                                            $labels['open_website'] . ': ' . $name
                                        ) ?>"
                                    >
                                        <?= Security::e($labels['website']) ?>
                                    </a>
                                <?php else: ?>
                                    <?= Security::e($labels['not_available']) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>