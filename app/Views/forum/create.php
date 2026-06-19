<section class="hero hero-compact">
    <div class="container">
        <p class="eyebrow">Forum</p>
        <h1>Neuer Beitrag</h1>
        <p>Erstellen Sie einen neuen Beitrag. Markdown kann für einfache Formatierungen verwendet werden.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="card forum-form-card">
            <form method="post" action="/forum/neu" class="form-stack">
                <div class="form-field">
                    <label for="title">Titel</label>
                    <input id="title" name="title" type="text" maxlength="180" required>
                </div>

                <div class="form-field">
                    <label for="body">Text / Markdown</label>
                    <textarea id="body" name="body" rows="10" required></textarea>
                </div>

                <div class="form-actions">
                    <button class="button" type="submit">Veröffentlichen</button>
                    <a class="button button-outline" href="/forum">Abbrechen</a>
                </div>
            </form>
        </div>
    </div>
</section>
