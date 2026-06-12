<section class="page">
    <div class="container page-grid">
        <div>
            <header class="page-hero">
                <p class="page-kicker">Kontakt</p>
                <h1 class="page-title">Fragen, Hinweise oder Interesse an der MMIG46?</h1>
                <p class="page-lead">
                    Nutzen Sie das Formular für Anfragen zum Verein, zu Reisen, technischen Themen oder zur Mitgliedschaft.
                </p>
            </header>

            <form class="content-card form-stack" method="post" action="/kontakt">
                <input type="hidden" name="_csrf" value="<?= \MMIG46\Core\Security::csrf() ?>">
                <input type="hidden" name="a" value="<?= (int)($a ?? 0) ?>">
                <input type="hidden" name="b" value="<?= (int)($b ?? 0) ?>">

                <div class="form-grid">
                    <div class="form-field">
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text" autocomplete="name" required>
                    </div>

                    <div class="form-field">
                        <label for="email">E-Mail</label>
                        <input id="email" name="email" type="email" autocomplete="email" required>
                    </div>

                    <div class="form-field form-field--full">
                        <label for="message">Nachricht</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>

                    <div class="form-field form-field--captcha">
                        <label for="captcha">Captcha: <?= (int)($a ?? 0) ?> + <?= (int)($b ?? 0) ?> =</label>
                        <input id="captcha" name="captcha" type="number" inputmode="numeric" required>
                    </div>
                </div>

                <div class="action-row">
                    <button class="button button--primary" type="submit">Senden</button>
                    <p class="form-note">Ihre Anfrage wird gespeichert und per E-Mail weitergeleitet.</p>
                </div>
            </form>
        </div>

        <aside class="sidebar-card">
            <h2>Kontaktbereiche</h2>
            <ul class="sidebar-list">
                <li>Mitgliedschaft und Vereinsfragen</li>
                <li>Fly-Ins, Reisen und Veranstaltungen</li>
                <li>Forum, Login und Mitgliederbereich</li>
                <li>Technische Hinweise zur PA46</li>
            </ul>
        </aside>
    </div>
</section>