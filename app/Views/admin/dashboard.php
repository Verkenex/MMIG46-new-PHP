<section class="page">
  <p class="eyebrow">Verwaltung</p>
  <h1>Administration der MMIG46-Plattform</h1>
  <p>Nutzerkonten, Mitgliederliste und Inhalte können hier vorbereitet und gepflegt werden.</p>

  <section class="grid two">
    <article>
      <h2>Account anlegen</h2>

      <form method="post" action="/verwaltung/users">
        <?= \MMIG46\Core\Security::csrfField() ?>

        <label>
          Name
          <input name="name" required>
        </label>

        <label>
          E-Mail
          <input type="email" name="email" required>
        </label>

        <label>
          Passwort
          <input type="password" name="password" required>
        </label>

        <label>
          Rolle
          <select name="role">
            <option value="member">member</option>
            <option value="moderator">moderator</option>
            <option value="admin">admin</option>
          </select>
        </label>

        <button class="primary">Speichern</button>
      </form>
    </article>

    <article>
      <h2>Mitglied eintragen</h2>

      <form method="post" action="/verwaltung/members">
        <?= \MMIG46\Core\Security::csrfField() ?>

        <label>
          Name
          <input name="name" required>
        </label>

        <label>
          E-Mail
          <input type="email" name="email">
        </label>

        <label>
          Aircraft
          <input name="aircraft" placeholder="PA46-310P">
        </label>

        <label>
          Base
          <input name="base" placeholder="EDFE">
        </label>

        <label>
          Rolle
          <input name="role_label" placeholder="Pilot, Owner, Vorstand">
        </label>

        <label>
          Mitgliedschaft
          <input name="member_type" placeholder="Mitglied, Vorstand, Ehrenmitglied">
        </label>

        <label>
          Website
          <input name="website" placeholder="https://...">
        </label>

        <label>
          Sortierung
          <input type="number" name="sort_order" value="100">
        </label>

        <label>
          <input type="checkbox" name="is_public" checked>
          Öffentlich anzeigen
        </label>

        <button class="primary">Speichern</button>
      </form>
    </article>
  </section>

  <section>
    <h2>Inhaltsseite bearbeiten</h2>

    <form method="post" action="/verwaltung/pages">
      <?= \MMIG46\Core\Security::csrfField() ?>

      <label>
        Slug
        <input name="slug" placeholder="verein" required>
      </label>

      <label>
        Titel
        <input name="title" required>
      </label>

      <label>
        Teaser
        <input name="teaser">
      </label>

      <label>
        Inhalt / Markdown
        <textarea name="body" rows="12" required></textarea>
      </label>

      <label>
        Meta Title
        <input name="meta_title">
      </label>

      <label>
        Meta Description
        <input name="meta_description">
      </label>

      <label>
        <input type="checkbox" name="is_published" checked>
        Öffentlich anzeigen
      </label>

      <button class="primary">Speichern</button>
    </form>
  </section>

  <section>
    <h2>Inhaltsseiten</h2>

    <div class="table">
      <table>
        <thead>
          <tr>
            <th>Slug</th>
            <th>Titel</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach (($pages ?? []) as $page): ?>
            <tr>
              <td><?= htmlspecialchars($page['slug']) ?></td>
              <td><?= htmlspecialchars($page['title']) ?></td>
              <td><?= !empty($page['is_published']) ? 'öffentlich' : 'intern' ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

  <section>
    <h2>Nutzer</h2>

    <div class="table">
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>E-Mail</th>
            <th>Rolle</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach (($users ?? []) as $user): ?>
            <tr>
              <td><?= htmlspecialchars($user['name']) ?></td>
              <td><?= htmlspecialchars($user['email']) ?></td>
              <td><?= htmlspecialchars($user['role']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>

  <section>
    <h2>Mitglieder</h2>

    <div class="table">
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Aircraft</th>
            <th>Base</th>
            <th>Rolle</th>
            <th>Mitgliedschaft</th>
            <th>Öffentlich</th>
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
              <td><?= !empty($member['is_public']) ? 'Ja' : 'Nein' ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>
</section>