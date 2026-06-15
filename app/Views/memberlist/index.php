<section class="page">
  <p class="eyebrow">MMIG46</p>
  <h1>Memberlist</h1>
  <p class="meta">Öffentlich sichtbare Mitglieder der MMIG46.</p>

  <div class="table">

    <?php if (empty($members)): ?>
    <div class="empty-state">...</div>
<?php else: ?>
    <table>
        ...
    </table>
<?php endif; ?>

    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Flugzeug</th>
          <th>Heimatflughafen</th>
          <th>Rolle</th>
          <th>Mitgliedschaft</th>
          <th>Website</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (($members ?? []) as $member): ?>
          <tr>
            <td><?= htmlspecialchars($member['name']) ?></td>
            <td><?= htmlspecialchars($member['aircraft'] ?? '') ?></td>
            <td><?= htmlspecialchars($member['base'] ?? '') ?></td>
            <td><?= htmlspecialchars($member['role_label'] ?? '') ?></td>
            <td><?= htmlspecialchars($member['member_type'] ?? '') ?></td>
            <td>
              <?php if (!empty($member['website'])): ?>
                <a href="<?= htmlspecialchars($member['website']) ?>" target="_blank" rel="noopener">
                  Website
                </a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>