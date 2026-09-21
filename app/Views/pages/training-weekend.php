<?php

use MMIG46\Core\Security;
use MMIG46\Core\Session;

$error = Session::flash('error');
$success = Session::flash('success');

$aircraftModels = [
    'PA46-310',
    'PA46-350',
    'PA46-JetPROP',
    'PA46R-350T',
    'PA46-M500',
    'PA46-M600',
    'PA46-M700',
    'Sonstiges',
];
?>

<section class="event-hero">
    <div class="container event-hero__inner">
        <p class="event-kicker">MMIG46 TRAININGSWOCHENENDE</p>

        <h1>Use it or lose it.</h1>

        <p class="event-hero__date">
            25.–26. September 2026 · Flughafen Mönchengladbach EDLN
        </p>

        <p class="event-hero__lead">
            Zwei Tage IFR-Refresher, praktische Übungen, Avionik,
            Feuerwehrdemonstration, Checkflüge und persönlicher Austausch
            im modernen RAS-Seminarbereich.
        </p>

        <div class="event-alert">
            <strong>First come, first served:</strong>
            Die Kapazitäten für einzelne Programmpunkte und Trainer
            sind begrenzt.
        </div>

        <div class="event-price-box" aria-label="Teilnahmegebühren">
            <div class="event-price-box__heading">
                Teilnahmegebühren
            </div>

            <div class="event-price-box__prices">
                <div class="event-price">
                    <span class="event-price__label">MMIG46-Mitglieder</span>
                    <strong>450 €</strong>
                </div>

                <div class="event-price">
                    <span class="event-price__label">Nichtmitglieder</span>
                    <strong>650 €</strong>
                </div>
            </div>

            <p class="event-price-box__note">
                Die Teilnahme ist ausschließlich nach vorheriger Registrierung
                und anschließender Bestätigung durch den Veranstalter möglich.
            </p>
        </div>

        <a class="button button--primary" href="#anmeldung">
            Jetzt Programmpunkte anfragen
        </a>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="event-facts">

            <article class="event-fact">
                <span class="event-fact__label">Location</span>
                <strong>RAS-Seminarräume, EDLN</strong>
                <p>
                    Moderner Seminar- und Trainingsbereich am Flughafen
                    Mönchengladbach.
                </p>
                <p class="event-fact__thanks">
                    Unser besonderer Dank gilt RAS und insbesondere
                    Herrn Frank Prochaska für die Unterstützung sowie die
                    Bereitstellung der Seminarräume.
                </p>
            </article>

            <article class="event-fact">
                <span class="event-fact__label">Für Teilnehmer</span>
                <strong>50 % reduzierte Landegebühr</strong>
                <p>
                    Während des Trainingswochenendes wird keine
                    Abstellgebühr erhoben.
                </p>
            </article>

            <article class="event-fact">
                <span class="event-fact__label">Teilnahme</span>
                <strong>Vorherige Registrierung erforderlich</strong>
                <p>
                    Die Teilnahme und die Buchung einzelner Programmpunkte
                    sind nur nach vorheriger Anmeldung und Bestätigung möglich.
                </p>
            </article>

        </div>
    </div>
</section>

<section class="section section--soft">
    <div class="container event-content">
        <div>
            <p class="section-eyebrow">PROGRAMM</p>
            <h2>Freitag, 25. September</h2>

            <ol class="event-schedule">
                <li>
                    <time>12:00–14:30 Uhr</time>
                    <div>
                        <h3>Anreise und Shuttle zur RAS</h3>
                        <p>
                            Bitte bei der Rollkontrolle angeben, dass Sie zur
                            MMIG46 gehören, und das Flugzeug auf dem
                            Hauptvorfeld (A5 oder A6) abstellen. Anschließend
                            Frank Prochaska unter
                            <a href="tel:+491782550246">0178 2550246</a>
                            kontaktieren; der Shuttle bringt Sie vom Vorfeld
                            zur RAS.
                        </p>
                        <p>
                            Autofahrer nutzen bitte den RAS-Hauptparkplatz:
                            nicht direkt vor dem Hauptgebäude abbiegen,
                            sondern ein kurzes Stück weiterfahren und dann
                            links abbiegen.
                        </p>
                    </div>
                </li>

                <li>
                    <time>15:00–17:00 Uhr</time>
                    <div>
                        <h3>Flughafenfeuerwehr</h3>
                        <p>
                            Individuelle Demonstration der Flughafenfeuerwehr
                            mit einem Einsatzfahrzeug unter Leitung von Herrn Hensen.
                        </p>
                    </div>
                </li>

                <li>
                    <time>ab 15:00 Uhr</time>
                    <div>
                        <h3>Simulator, Trainings-/Checkflüge und Garmin</h3>
                        <p>
                            Stündliche Simulator-Sitzungen bei MG-Flyers nach
                            Programm. Frank Lumnitzer und Ralph Wendt bieten
                            bereits am Freitagnachmittag beziehungsweise
                            -abend Trainingsflüge an. Im Rahmen dieser Flüge
                            können auch IFR- beziehungsweise SET-Checkflüge
                            abgenommen werden; bei Interesse bitte direkt
                            melden. Fabian Kienzle demonstriert die neuesten
                            Garmin-Geräte.
                        </p>
                    </div>
                </li>

                <li>
                    <time>17:00–18:00 Uhr</time>
                    <div>
                        <h3>Wasserfliegen in Deutschland</h3>
                        <p>Vortrag von Norbert Klippel.</p>
                    </div>
                </li>

                <li>
                    <time>18:00–19:00 Uhr</time>
                    <div>
                        <h3>Transfer zum Ramshof</h3>
                        <p>
                            Transfer zum Landgut Ramshof. Das gemeinsame
                            Abendessen beginnt um 19:30 Uhr im Oval Office.
                        </p>

                        <div class="event-self-pay-notice">
                            <strong>Hinweis zum Eigenanteil:</strong>
                            Die beim gemeinsamen Abendessen bestellten Getränke sind
                            von den Teilnehmern selbst zu bezahlen.
                        </div>
                    </div>
                </li>
            </ol>
        </div>

        <div>
            <p class="section-eyebrow">PROGRAMM</p>
            <h2>Samstag, 26. September</h2>

            <ol class="event-schedule">

                <li>
                    <time>08:30–09:00 Uhr</time>

                    <div>
                        <h3>Ankunft und Tagesbriefing</h3>
                        <p>Ankunft bei RAS, Kaffee und Tagesbriefing.</p>
                    </div>
                </li>

                <li>
                    <time>ab 09:00 Uhr</time>

                    <div>
                        <h3>Simulatortraining</h3>
                        <p>
                            Stündliche Simulator-Sitzungen bei MG-Flyers nach
                            Programm.
                        </p>
                    </div>
                </li>

                <li>
                    <time>09:00–10:30 Uhr</time>

                    <div>
                        <h3>IFR-Refresher und Wetter-Apps</h3>

                        <p>
                            Vorträge von <strong>Frank Lumnitzer</strong> zum
                            IFR-Refresher sowie zur Auswahl und Nutzung von
                            Wetter-Apps.
                        </p>
                    </div>
                </li>

                <li>
                    <time>10:30–11:00 Uhr</time>

                    <div>
                        <h3>Garmin-Avionik und PA46-Nachrüstung</h3>
                        <p>
                            <strong>Fabian Kienzle</strong> stellt Neuheiten
                            aus der Garmin-Avionik und spezifische
                            Nachrüstungsmöglichkeiten für die PA46 vor.
                        </p>
                    </div>
                </li>

                <li>
                    <time>ab 11:00 Uhr</time>

                    <div>
                        <h3>Persönliches Flugtraining, Checkflüge und Beratung</h3>

                        <p>
                            Persönliches Training mit Frank Lumnitzer und
                            Ralph Wendt; dabei können auch IFR- beziehungsweise
                            SET-Checkflüge abgenommen werden. Stefan Bassiri
                            steht beratend zur Verfügung. Individuelle
                            Garmin-Beratung und Trainingsflüge können mit
                            Fabian Kienzle vereinbart werden. Fabian Kienzle
                            steht bei Interesse auch am Sonntag für gemeinsame
                            Trainingsflüge zur Verfügung.
                        </p>
                    </div>
                </li>

                <li>
                    <time>11:00–13:00 Uhr</time>

                    <div>
                        <h3>Flugmedizin, Stress und Simulatortraining</h3>

                        <p>
                            Vorträge von <strong>Dr. Michael Offermann</strong>:
                        </p>
                        <p><strong>1.</strong> Murphys Law und der Nutzen von Simulatortraining auch für nicht kommerzielle Piloten</p>
                        <p><strong>2.</strong> Umgang mit nicht systemimmanentem Stress an Bord</p>
                        <p><strong>3.</strong> Die 30 wichtigsten medizinischen Probleme, die mit einem Fliegerarzt besprochen werden sollten</p>
                        <p><strong>4.</strong> Engagement als Pilot oder Copilot bei Flying Hope</p>
                    </div>
                </li>

                <li>
                    <time>13:00–14:00 Uhr (und länger)</time>

                    <div>
                        <h3>Mittagspause und Nachmittagsprogramm</h3>

                        <p>
                            Snacks, belegte Brötchen, Kaffee und Mineralwasser.
                            Anschließend Fortsetzung des individuellen
                            Trainings und der geplanten Simulator-Sitzungen.
                        </p>
                    </div>
                </li>

                <li>
                    <time>17:30–18:00 Uhr</time>
                    <div>
                        <h3>Feedback und Abschluss</h3>
                        <p>
                            Ab 17:30 Uhr Feedback und Planung weiterer
                            Veranstaltungen; um 18:00 Uhr Abschluss und Abreise.
                        </p>
                    </div>
                </li>

            </ol>
        </div>
    </div>
</section>

<section class="section event-speakers-section">
    <div class="container">

        <div class="event-section-heading">
            <p class="section-eyebrow">REFERENTEN &amp; EXPERTEN</p>
            <h2>Erfahrung aus Flugbetrieb, Training und Avionik</h2>
            <p>
                Fachliche Impulse und persönliche Beratung durch
                erfahrene Experten aus der allgemeinen Luftfahrt.
            </p>
        </div>

        <div class="event-speakers">

            <article class="event-speaker">
                <div class="event-speaker__image">
                    <img
                        src="/assets/img/training-weekend/frank-lumnitzer.jpg"
                        alt="Frank Lumnitzer"
                        loading="lazy"
                        width="640"
                        height="800">
                </div>

                <div class="event-speaker__content">
                    <h3>Frank Lumnitzer</h3>
                    <p class="event-speaker__role">
                        Senior Aviation Executive
                    </p>
                    <p>
                        Referent für IFR-Refresher und Wetter-Apps sowie
                        Trainer für individuelle Trainings- und Checkflüge.
                    </p>
                </div>
            </article>

            <article class="event-speaker">
                <div class="event-speaker__image">
                    <img
                        src="/assets/img/training-weekend/fabian-kienzle.jpg"
                        alt="Fabian Kienzle"
                        loading="lazy"
                        width="640"
                        height="800">
                </div>

                <div class="event-speaker__content">
                    <h3>Fabian Kienzle</h3>
                    <p class="event-speaker__role">
                        Garmin-Avionik und PA46-Nachrüstung
                    </p>
                    <p>
                        Persönliche Beratung zu Garmin-Systemen,
                        Avioniklösungen und Nachrüstungsmöglichkeiten
                        für die PA46.
                    </p>
                </div>
            </article>

            <article class="event-speaker">
                <div class="event-speaker__image event-speaker__image--placeholder">
                    <span aria-hidden="true">RW</span>
                </div>

                <div class="event-speaker__content">
                    <h3>Ralph Wendt</h3>
                    <p class="event-speaker__role">
                        Flugtraining und Checkflüge
                    </p>
                    <p>
                        Persönliches Training im eigenen Flugzeug sowie
                        Abnahme von IFR- und SET-Checkflügen.
                    </p>
                </div>
            </article>

            <article class="event-speaker">
                <div class="event-speaker__image">
                    <img
                        src="/assets/img/training-weekend/norbert-klippel.jpg"
                        alt="Norbert Klippel"
                        loading="lazy"
                        width="640"
                        height="800">
                </div>

                <div class="event-speaker__content">
                    <h3>Norbert Klippel</h3>
                    <p class="event-speaker__role">
                        Referent „Wasserfliegen in Deutschland“
                    </p>
                    <p>
                        Vortrag über die besonderen fliegerischen und
                        organisatorischen Aspekte des Wasserfliegens.
                    </p>
                </div>
            </article>

            <article class="event-speaker">
                <div class="event-speaker__image event-speaker__image--placeholder">
                    <span aria-hidden="true">MO</span>
                </div>

                <div class="event-speaker__content">
                    <h3>Dr. Michael Offermann</h3>
                    <p class="event-speaker__role">
                        Flugmedizin, Stress und Simulatortraining
                    </p>
                    <p>
                        Vorträge zu Simulatortraining, Stressmanagement,
                        flugmedizinischen Fragestellungen und Flying Hope.
                    </p>
                </div>
            </article>

            <article class="event-speaker">
                <div class="event-speaker__image event-speaker__image--placeholder">
                    <span aria-hidden="true">SB</span>
                </div>

                <div class="event-speaker__content">
                    <h3>Stefan Bassiri</h3>
                    <p class="event-speaker__role">Beratung</p>
                    <p>
                        Stefan Bassiri steht den Teilnehmern am Samstag
                        beratend zur Verfügung.
                    </p>
                </div>
            </article>

        </div>

    </div>
</section>

<section class="section">
    <div class="container event-content">
        <div>
            <p class="section-eyebrow">ÜBERNACHTUNG</p>
            <h2>Landgut Ramshof in Willich</h2>

            <p>
                Für die MMIG46 wurde ein begrenztes Zimmerkontingent
                vereinbart. Ein Doppelzimmer ist für
                <strong>110 Euro für eine Nacht</strong> buchbar.
            </p>

            <p>
                Die Zimmerbuchung erfolgt direkt beim Ramshof und muss
                von den Teilnehmern selbst vorgenommen werden.
                Bitte bei der Buchung unbedingt das Stichwort
                <strong>„MMIG46“</strong> angeben.
            </p>

            <address class="event-contact-card">
                <strong>Landgut Ramshof</strong>

                <span>
                    Ramshof 1<br>
                    47877 Willich-Neersen
                </span>

                <span>
                    Telefon:
                    <a href="tel:+49215695890">02156 95890</a>
                </span>

                <span>
                    E-Mail:
                    <a href="mailto:stay@ramshof.de">stay@ramshof.de</a>
                </span>
            </address>

            <div class="event-self-pay-notice">
                <strong>Eigenanteil:</strong>
                Die Übernachtung sowie die beim gemeinsamen Abendessen
                bestellten Getränke sind nicht in den Leistungen der MMIG46
                enthalten und müssen von den Teilnehmern selbst bezahlt werden.
            </div>
        </div>

        <div>
            <p class="section-eyebrow">BEGLEITPROGRAMM</p>
            <h2>Samstag ab ca. 10:00 Uhr</h2>

            <div class="event-additional-programme">
                <h3>Programm für Begleitpersonen</h3>

                <p>
                    Je nach Wetter sind ein Rundgang durch die historische
                    Kempener Altstadt oder ein Besuch des Niederrheinischen
                    Freilichtmuseums in Grefrath vorgesehen. Bei schlechtem
                    Wetter findet bei uns ein Kaffeekranz mit Sekt statt.
                </p>

                <p class="event-additional-programme__condition">
                    Leitung: Bärbel Gerecht
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section section--accent" id="anmeldung">
    <div class="container event-registration">
        <div>
            <p class="section-eyebrow">ANMELDUNG</p>
            <h2>Gewünschte Programmpunkte anfragen</h2>

            <p>
                Eine vorherige Registrierung ist für sämtliche Teilnehmer
                erforderlich. Bitte wählen Sie die gewünschten Programmpunkte aus.
                Die Anmeldung stellt zunächst eine verbindliche Anfrage dar.
                Dr. Gerecht koordiniert die verfügbaren Plätze und meldet sich
                anschließend per E-Mail.
            </p>

            <div class="event-registration-prices">
                <strong>Teilnahmegebühren:</strong>
                450 € für MMIG46-Mitglieder · 650 € für Nichtmitglieder
            </div>

            <p>
                Wegen der begrenzten Kapazitäten gilt:
                <strong>First come, first served.</strong>
            </p>
        </div>

        <form method="post"
              action="/trainingswochenende-2026/anmeldung"
              class="event-form">

            <?= Security::csrfField() ?>

            <input type="hidden" name="idempotency_token" value="<?= Security::e((string) ($idempotencyToken ?? '')) ?>">

            <input type="checkbox"
                   name="registration_check"
                   value="1"
                   tabindex="-1"
                   autocomplete="off"
                   class="form-honeypot"
                   aria-hidden="true">

            <?php if ($error): ?>
                <div class="form-message form-message--error">
                    <?= Security::e($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="form-message form-message--success">
                    <?= Security::e($success) ?>
                </div>
            <?php endif; ?>

            <div class="form-grid">
                <label>
                    Name *
                    <input type="text"
                           name="name"
                           required
                           maxlength="150"
                           autocomplete="name">
                </label>

                <label>
                    E-Mail *
                    <input type="email"
                           name="email"
                           required
                           maxlength="190"
                           autocomplete="email">
                </label>

                <label>
                    Flugzeugkennung *
                    <input type="text"
                           name="callsign"
                           required
                           maxlength="20"
                           placeholder="z. B. D-EXYZ">
                </label>

                <label>
                    Flugzeugtyp
                    <select name="aircraft_model">
                        <option value="">Bitte wählen</option>

                        <?php foreach ($aircraftModels as $model): ?>
                            <option value="<?= Security::e($model) ?>">
                                <?= Security::e($model) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label>
                    Teilnehmerzahl
                    <input type="number"
                           name="participants"
                           min="1"
                           max="4"
                           value="1">
                </label>
            </div>

            <fieldset class="programme-options">
                <legend>Gewünschte Programmpunkte *</legend>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="fire_training"
                    >
                    <span class="programme-option__text">
                        Feuerwehrdemonstration am Freitag
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="water_flying_lecture"
                    >
                    <span class="programme-option__text">
                        Vortrag „Wasserfliegen in Deutschland“ von Norbert Klippel
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="dinner"
                    >
                    <span class="programme-option__text">
                        Gemeinsames Abendessen im Ramshof
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="ifr_refresher"
                    >
                    <span class="programme-option__text">
                        IFR-Refresher
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="ifr_meteorology"
                    >
                    <span class="programme-option__text">
                        Wetter-Apps und deren Nutzung mit Frank Lumnitzer
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="avionics_lecture"
                    >
                    <span class="programme-option__text">
                        Avionik und PA46-Nachrüstung
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="hands_on_training"
                    >
                    <span class="programme-option__text">
                        Persönliches Trainings-/Übungsfliegen im eigenen Flugzeug
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="simulator_training"
                    >
                    <span class="programme-option__text">
                        Simulatortraining auf einem ALSIM-Simulator bei MG-Flyers
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="ifr_check_flight"
                    >
                    <span class="programme-option__text">
                        IFR-Checkflug
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="set_check_flight"
                    >
                    <span class="programme-option__text">
                        SET-Checkflug
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="garmin_consultation"
                    >
                    <span class="programme-option__text">
                        Persönliche Garmin-Beratung durch Fabian Kienzle
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="offermann_lectures"
                    >
                    <span class="programme-option__text">
                        Vorträge von Dr. Michael Offermann
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="kempen_old_town_tour">

                    <span class="programme-option__text">
                        Begleitprogramm am Samstag
                        <small>
                            Je nach Wetter: Altstadt Kempen, Freilichtmuseum
                            Grefrath oder Kaffeekranz mit Sekt
                        </small>
                    </span>
                </label>

            </fieldset>


            <label class="event-notes-field">
                <span>Anmerkungen</span>

                <textarea
                    name="notes"
                    rows="5"
                    maxlength="2000"
                    placeholder="Besondere Trainingswünsche, Checkflug, Anzahl der Piloten etc."
                ></textarea>
            </label>

            <label class="consent-label">
                <input
                    type="checkbox"
                    name="privacy_consent"
                    value="1"
                    required
                >

                <span class="consent-label__text">
                    Ich bin damit einverstanden, dass meine Angaben zur
                    Organisation des Trainingswochenendes verarbeitet und
                    an den zuständigen Organisator übermittelt werden.

                    <span class="consent-label__privacy">
                        Weitere Informationen stehen in der
                        <a href="/datenschutz">Datenschutzerklärung</a>.
                    </span>
                </span>
            </label>

            <button type="submit" class="button button--primary">
                Anfrage verbindlich absenden
            </button>
        </form>
    </div>
</section>
