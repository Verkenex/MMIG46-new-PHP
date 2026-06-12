<section class="auth-shell">
    <div class="container">
        <form class="auth-card" method="post" action="/login">
            <h1>Login</h1>
            <p>Zugang für Mitglieder, Moderatoren und Verwaltung.</p>

            <input type="hidden" name="_csrf" value="<?= \MMIG46\Core\Security::csrf() ?>">

            <div class="form-stack">
                <div class="form-field">
                    <label for="email">E-Mail</label>
                    <input id="email" name="email" type="email" autocomplete="email" required>
                </div>

                <div class="form-field">
                    <label for="password">Passwort</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required>
                </div>

                <button class="button button--primary" type="submit">Einloggen</button>
            </div>
        </form>
    </div>
</section>