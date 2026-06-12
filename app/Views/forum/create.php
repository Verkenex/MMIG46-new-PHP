<section class="page page--narrow">
    <div class="container">
        <header class="page-hero">
            <p class="page-kicker">Forum</p>
            <h1 class="page-title">Neuer Beitrag</h1>
            <p class="page-lead">
                Erstellen Sie einen neuen Beitrag. Markdown kann für einfache Formatierungen verwendet werden.
            </p>
        </header>

        <form class="content-card form-stack" method="post" action="/forum/neu">
            <input type="hidden" name="_csrf" value="<?= \MMIG46\Core\Security::csrf() ?>">

            <div class="form-field">
                <label for="title">Titel</label>
                <input id="title" name="title" type="text" required>
            </div>

            <div class="form-field">
                <label for="body">Text / Markdown</label>
                <textarea id="body" name="body" required></textarea>
            </div>

            <div class="action-row">
                <button class="button button--primary" type="submit">Veröffentlichen</button>
                <a class="button button--secondary" href="/forum">Abbrechen</a>
            </div>
        </form>
    </div>
</section>