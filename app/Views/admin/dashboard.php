<section class="page admin-shell">
  <div class="admin-hero">
      <div>
          <p class="eyebrow">Verwaltung</p>
          <h1>Administration der MMIG46-Plattform</h1>
          <p>Nutzerkonten, Mitgliederliste, Beiträge und Reisen zentral pflegen.</p>
      </div>

      <div class="admin-hero-actions">
          <a class="button ghost" href="/">Website ansehen</a>
          <a class="button ghost" href="/news">News prüfen</a>
          <a class="button ghost" href="/reisen">Reisen prüfen</a>
      </div>
  </div>

  <section class="admin-card-grid">
<article class="admin-card">

  <div class="admin-card-header">
      <span class="admin-icon">👤</span>
      <div>
          <h2>Account anlegen</h2>
          <p>Neuen Nutzer mit Rolle erstellen.</p>
      </div>
  </div>

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

  <article class="admin-card">

  <div class="admin-card-header">
      <span class="admin-icon">✈</span>
      <div>
          <h2>Mitglied eintragen</h2>
          <p>Öffentliches Mitgliedsprofil pflegen.</p>
      </div>
  </div>

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



<section class="admin-panel admin-card admin-card-wide">

  <div class="admin-card-header">
      <span class="admin-icon">📰</span>
      <div>
          <h2>Beiträge verwalten</h2>
          <p>News anlegen oder über bestehenden Slug aktualisieren.</p>
      </div>
  </div>


    <form method="post" action="/verwaltung/news" class="admin-form">
        <?= \MMIG46\Core\Security::csrfField() ?>

        <label>Titel
            <input name="title" required>
        </label>

        <label>Slug
            <input name="slug" required placeholder="fly-in-woerthersee-2026">
        </label>

        <label>Kategorie
            <input name="category" placeholder="Verein, Reisen, Aktuelles">
        </label>

        <label>Bildpfad
            <input name="image_path" placeholder="/assets/img/news-meeting.jpg">
        </label>

        <label>Teaser
            <textarea name="teaser"></textarea>
        </label>

        <label>Artikeltext / Markdown
            <textarea name="body" rows="10" required></textarea>
        </label>

        <label>Veröffentlichungsdatum
            <input name="published_at" placeholder="2026-06-15 12:00:00">
        </label>

        <label>
            <input type="checkbox" name="is_published" value="1" checked>
            Veröffentlicht
        </label>

        <button class="button" type="submit">Beitrag speichern</button>
    </form>

    <h3>Bestehende Beiträge</h3>
    <table>
        <thead>
            <tr>
                <th>Titel</th>
                <th>Slug</th>
                <th>Datum</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($news as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['title']) ?></td>
                    <td><code><?= htmlspecialchars($item['slug']) ?></code></td>
                    <td><?= htmlspecialchars($item['published_at']) ?></td>
                    <td>
                        <span class="status-badge <?= !empty($item['is_published']) ? 'is-online' : 'is-offline' ?>">
                            <?= !empty($item['is_published']) ? 'online' : 'offline' ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<section class="admin-card admin-card-wide">

  <div class="admin-card-header">
      <span class="admin-icon">🧭</span>
      <div>
          <h2>Reise bearbeiten</h2>
          <p>Reisen per Slug neu anlegen oder aktualisieren.</p>
      </div>
  </div>

  <form method="post" action="/verwaltung/travels">
    <?= \MMIG46\Core\Security::csrfField() ?>

    <label>
      Slug
      <input name="slug" placeholder="fly-in-woerthersee-2026" required>
    </label>

    <label>
      Titel
      <input name="title" required>
    </label>

    <label>
      Bildpfad
      <input name="image_path" placeholder="/assets/img/woerthersee.jpg">
    </label>

    <label>
      Ort
      <input name="location" placeholder="Woerthersee">
    </label>

    <label>
      Startdatum
      <input type="date" name="starts_on">
    </label>

    <label>
      Enddatum
      <input type="date" name="ends_on">
    </label>

    <label>
      Status
      <select name="status">
        <option value="planned">planned</option>
        <option value="completed">completed</option>
        <option value="archived">archived</option>
      </select>
    </label>

    <label>
      Teaser
      <input name="teaser">
    </label>

    <label>
      CTA Label
      <input name="cta_label" placeholder="Details ansehen">
    </label>

    <label>
      Inhalt
      <textarea name="body" rows="8"></textarea>
    </label>

    <label>
      <input type="checkbox" name="is_published" checked>
      Öffentlich anzeigen
    </label>

    <button class="primary">Reise speichern</button>
  </form>
</section>

<section class="admin-card admin-card-wide">

  <div class="admin-card-header">
      <span class="admin-icon">🔐</span>
      <div>
          <h2>Nutzer</h2>
          <p>Bestehende Logins und Rollen.</p>
      </div>
  </div>

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

<section class="admin-card admin-card-wide">

  <div class="admin-card-header">
      <span class="admin-icon">🛩</span>
      <div>
          <h2>Mitglieder</h2>
          <p>Öffentliche und interne Mitgliederprofile.</p>
      </div>
  </div>

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
              <td>
                  <span class="status-badge <?= !empty($member['is_public']) ? 'is-online' : 'is-offline' ?>">
                      <?= !empty($member['is_public']) ? 'Ja' : 'Nein' ?>
                  </span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </section>
</section>