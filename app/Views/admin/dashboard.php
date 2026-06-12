<section class="page">
    <div class="container">
        <header class="page-hero">
            <p class="page-kicker">Verwaltung</p>
            <h1 class="page-title">Administration der MMIG46-Plattform.</h1>
            <p class="page-lead">
                Nutzerkonten, Mitgliederliste und Inhalte können hier vorbereitet und gepflegt werden.
            </p>
        </header>

        <div class="admin-grid">
            <form class="content-card form-stack" method="post" action="/verwaltung/users">
                <input type="hidden" name="_csrf" value="<?= \MMIG46\Core\Security::csrf() ?>">

                <h2>Account anlegen</h2>

                <div class="form-field">
                    <label for="user-name">Name</label>
                    <input id="user-name" name="name" type="text" required>
                </div>

                <div class="form-field">
                    <label for="user-email">E-Mail</label>
                    <input id="user-email" name="email" type="email" required>
                </div>

                <div class="form-field">
                    <label for="user-password">Passwort</label>
                    <input id="user-password" name="password" type="password" required>
                </div>

                <div class="form-field">
                    <label for="user-role">Rolle</label>
                    <select id="user-role" name="role">
                        <option value="member">member</option>
                        <option value="moderator">moderator</option>
                        <option value="admin">admin</option>
                    </select>
                </div>

                <button class="button button--primary" type="submit">Speichern</button>
            </form>

            <form class="content-card form-stack" method="post" action="/verwaltung/members">
                <input type="hidden" name="_csrf" value="<?= \MMIG46\Core\Security::csrf() ?>">

                <h2>Mitglied eintragen</h2>

                <div class="form-field">
                    <label for="member-name">Name</label>
                    <input id="member-name" name="name" type="text" required>
                </div>

                <div class="form-field">
                    <label for="member-email">E-Mail</label>
                    <input id="member-email" name="email" type="email">
                </div>

                <div class="form-field">
                    <label for="member-aircraft">Aircraft</label>
                    <input id="member-aircraft" name="aircraft" type="text" placeholder="PA46-350P">
                </div>

                <div class="form-field">
                    <label for="member-base">Base</label>
                    <input id="member-base" name="base" type="text" placeholder="EDFE">
                </div>

                <div class="form-field">
                    <label for="member-role">Rolle</label>
                    <input id="member-role" name="role" type="text" placeholder="Mitglied">
                </div>

                <label class="checkbox-row">
                    <input name="is_public" type="checkbox" value="1" checked>
                    <span>Öffentlich anzeigen</span>
                </label>

                <button class="button button--primary" type="submit">Speichern</button>
            </form>
        </div>

        <div class="split-grid" style="margin-top: 24px;">
            <article class="table-card">
                <div class="table-card__header">
                    <h2>Nutzer</h2>
                    <span class="badge">Demo</span>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>E-Mail</th>
                            <th>Rolle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Admin</td>
                            <td>admin@example.test</td>
                            <td>admin</td>
                        </tr>
                        <tr>
                            <td>Moderator</td>
                            <td>moderator@example.test</td>
                            <td>moderator</td>
                        </tr>
                    </tbody>
                </table>
            </article>

            <article class="table-card">
                <div class="table-card__header">
                    <h2>Mitglieder</h2>
                    <span class="badge">Demo</span>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Aircraft</th>
                            <th>Base</th>
                            <th>Öffentlich</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Thomas B.</td>
                            <td>PA46-310P</td>
                            <td>EDFE</td>
                            <td>Ja</td>
                        </tr>
                        <tr>
                            <td>Sabine K.</td>
                            <td>PA46-310P</td>
                            <td>LOWW</td>
                            <td>Ja</td>
                        </tr>
                    </tbody>
                </table>
            </article>
        </div>
    </div>
</section>