<?php

use MMIG46\Core\I18n;
use MMIG46\Core\Security;

$members = $members ?? [];
?>

<section class="page">
    <p class="eyebrow">MMIG46</p>

    <h1><?= Security::e(I18n::t('members.title')) ?></h1>

    <p class="meta">
        <?= Security::e(I18n::t('members.intro')) ?>
    </p>

    <?php if (empty($members)): ?>
        <div class="empty-state">
            <h2>
                <?= Security::e(I18n::t('members.empty_title')) ?>
            </h2>

            <p>
                <?= Security::e(I18n::t('members.empty_text')) ?>
            </p>
        </div>
    <?php else: ?>
        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th><?= Security::e(I18n::t('members.aircraft')) ?></th>
                        <th><?= Security::e(I18n::t('members.base')) ?></th>
                        <th><?= Security::e(I18n::t('members.role')) ?></th>
                        <th><?= Security::e(I18n::t('members.membership')) ?></th>
                        <th><?= Security::e(I18n::t('common.website')) ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($members as $member): ?>
                        <tr>
                            <td><?= Security::e($member['name'] ?? '') ?></td>
                            <td><?= Security::e($member['aircraft'] ?? '') ?></td>
                            <td><?= Security::e($member['base'] ?? '') ?></td>
                            <td><?= Security::e($member['role_label'] ?? '') ?></td>
                            <td><?= Security::e($member['member_type'] ?? '') ?></td>
                            <td>
                                <?php if (!empty($member['website'])): ?>
                                    <a
                                        href="<?= Security::e($member['website']) ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        <?= Security::e(I18n::t('common.website')) ?>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
