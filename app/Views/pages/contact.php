<section class="page">
  <div class="split">
    <div>
      <p class="eyebrow">Kontakt</p>
      <h1>Fragen, Hinweise oder Interesse an der MMIG46?</h1>
      <p class="meta">
        Nutzen Sie das Formular für Anfragen zum Verein, zu Reisen, technischen Themen oder zur Mitgliedschaft.
      </p>
    </div>

    <aside class="info-card">
      <h2>Kontaktbereiche</h2>
      <ul class="clean-list">
        <li>Mitgliedschaft und Vereinsfragen</li>
        <li>Fly-Ins, Reisen und Veranstaltungen</li>
        <li>Forum, Login und Mitgliederbereich</li>
        <li>Technische Hinweise zur PA46</li>
      </ul>
    </aside>
  </div>

  <form class="form-card" method="post" action="/kontakt">
    <?= \MMIG46\Core\Security::csrfField() ?>

    <div class="form-grid">
      <label>
        Name
        <input name="name" required>
      </label>

      <label>
        E-Mail
        <input type="email" name="email" required>
      </label>
    </div>

    <label>
      Nachricht
      <textarea name="message" rows="8" required></textarea>
    </label>

    <label>
      Captcha: <?= htmlspecialchars((string)($captcha ?? '')) ?> =
      <input type="number" name="captcha" required>
    </label>

    <div class="actions">
      <button class="btn primary" type="submit">Senden</button>
      <p class="meta">Ihre Anfrage wird gespeichert und per E-Mail weitergeleitet.</p>
    </div>
  </form>
</section>