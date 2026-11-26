<?php
$title = $isEn ? 'Annual General Meeting' : 'Ordentliche Mitgliederversammlung';
?>
<section class="training-banner">
    <div class="container">
        <p class="training-banner__eyebrow"><?= $isEn ? 'Saturday, 5 December 2026 · 11:00' : 'Samstag, 5. Dezember 2026 · 11:00 Uhr' ?></p>
        <h2><?= $title ?></h2>
        <p><?= $isEn ? 'RAS seminar room at Mönchengladbach Airport. Join us from 10:30 for coffee and conversation.' : 'Seminarraum der RAS am Flughafen Mönchengladbach. Ab 10:30 Uhr treffen wir uns zu Kaffee und Gesprächen.' ?></p>
        <details id="meeting-invitation">
            <summary><?= $isEn ? 'Read the invitation and agenda' : 'Einladung und Tagesordnung lesen' ?></summary>
            <article class="meeting-letter">
                <h2 id="meeting-title"><?= $title ?></h2>
                <?php if ($isEn): ?>
                    <p>Dear members,</p>
                    <p>On behalf of the board, we invite you to our Annual General Meeting under section 12 of our statutes on <strong>Saturday, 5 December 2026 at 11:00</strong>. Join us from <strong>10:30</strong> for snacks, coffee, tea and conversation.</p>
                    <p><strong>RAS seminar room, Mönchengladbach Airport</strong><br>Flughafenstraße 31, 41066 Mönchengladbach-Ost. If you are driving, take the first RAS entrance on the left.</p>
                    <h3>Agenda</h3>
                    <ol>
                        <li>Report by the Chairman, Klaus Gerecht</li>
                        <li>Report by the Treasurer, Helmuth Sontag</li>
                        <li>Report by Kurt Levy, Managing Director and Deputy Club Spokesman</li>
                        <li>Auditors’ report</li>
                        <li>Vote on the discharge of the board</li>
                        <li>Any other business</li>
                    </ol>
                    <p>Under our <a href="/satzung?lang=en">statutes</a>, members’ motions must reach the board at least eight days before the meeting.</p>
                    <p>Please let us know in good time if you will attend. Email <a href="mailto:dr.gerecht@mmig46.org">dr.gerecht@mmig46.org</a> or <a href="mailto:support@mmig46.org">support@mmig46.org</a>. If you have already registered, you are all set.</p>
                    <p>After the meeting, please join us for a sparkling wine reception and lunch to catch up and plan future activities.</p>
                    <p>Happy flying!<br>Malibu Mirage Interessengemeinschaft 46<br>On behalf of the board<br><strong>Klaus Gerecht</strong></p>
                <?php else: ?>
                    <p>Liebe Mitglieder,</p>
                    <p>wir laden Euch gemäß § 12 unserer Satzung herzlich zur diesjährigen Mitgliederversammlung am <strong>Samstag, den 5. Dezember 2026, um 11:00 Uhr</strong> ein. Ab <strong>10:30 Uhr</strong> treffen wir uns zu Gesprächen bei Snacks, Kaffee und Tee.</p>
                    <p><strong>Seminarraum der RAS am Flughafen Mönchengladbach</strong><br>Flughafenstraße 31, 41066 Mönchengladbach-Ost. Für Autofahrer ist es die erste Einfahrt der RAS auf der linken Seite.</p>
                    <h3>Tagesordnung</h3>
                    <ol>
                        <li>Bericht des Vorsitzenden Klaus Gerecht</li>
                        <li>Bericht des Schatzmeisters Helmuth Sontag</li>
                        <li>Bericht des Geschäftsführers bzw. stellvertretenden Vereinssprechers Kurt Levy</li>
                        <li>Bericht der Rechnungsprüfer</li>
                        <li>Entlastung des Vorstandes</li>
                        <li>Verschiedenes</li>
                    </ol>
                    <p>Anträge von Mitgliedern müssen gemäß unserer <a href="/satzung?lang=de">Satzung</a> mindestens acht Tage vor der Hauptversammlung beim Vorstand eingegangen sein.</p>
                    <p>Bitte teilt mir Eure Teilnahme rechtzeitig per E-Mail an <a href="mailto:dr.gerecht@mmig46.org">dr.gerecht@mmig46.org</a> oder <a href="mailto:support@mmig46.org">support@mmig46.org</a> mit. Wenn Ihr Euch bereits angemeldet habt, ist nichts weiter zu tun.</p>
                    <p>Im Anschluss laden wir Euch zum Sektempfang und zum gemeinsamen Mittagessen ein. Dabei haben wir Gelegenheit zum Austausch und zur Planung neuer Aktionen.</p>
                    <p>Mit besten Fliegergrüßen!<br>Malibu Mirage Interessengemeinschaft 46<br>Für den Vorstand<br><strong>Klaus Gerecht</strong></p>
                <?php endif; ?>
            </article>
        </details>
    </div>
</section>
<dialog id="meeting-dialog" aria-labelledby="meeting-title">
    <form method="dialog"><button type="submit" autofocus><?= $isEn ? 'Close' : 'Schließen' ?></button></form>
</dialog>
