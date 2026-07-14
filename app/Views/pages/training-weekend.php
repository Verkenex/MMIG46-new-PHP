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
            Feuerlöschtraining, Checkflüge und persönlicher Austausch
            im modernen RAS-Seminarbereich.
        </p>

        <div class="event-alert">
            <strong>First come, first served:</strong>
            Die Kapazitäten für einzelne Programmpunkte und Trainer
            sind begrenzt.
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
                <strong>RAS-Seminarraum, EDLN</strong>
                <p>
                    Moderner Seminar- und Trainingsbereich am Flughafen
                    Mönchengladbach.
                </p>
            </article>

            <article class="event-fact">
                <span class="event-fact__label">Für Mitglieder</span>
                <strong>50 % reduzierte Landegebühr</strong>
                <p>
                    Während des Trainingswochenendes wird keine
                    Abstellgebühr erhoben.
                </p>
            </article>

            <article class="event-fact">
                <span class="event-fact__label">Verpflegung</span>
                <strong>Durch die MMIG46</strong>
                <p>
                    Snacks, Kaffee, Getränke und das gemeinsame
                    Abendessen werden von der MMIG46 übernommen.
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
                    <time>ab 16:00 Uhr</time>
                    <div>
                        <h3>Feuerlöschübungen</h3>
                        <p>
                            Praktische Übungen mit der Flughafenfeuerwehr
                            in kleinen Gruppen.
                        </p>
                    </div>
                </li>

                <li>
                    <time>18:15 Uhr</time>
                    <div>
                        <h3>Wasserfliegen in Deutschland</h3>
                        <p>Vortrag von Norbert Klippe.</p>
                    </div>
                </li>

                <li>
                    <time>19:30 Uhr</time>
                    <div>
                        <h3>Transfer zum Ramshof</h3>
                        <p>
                            Anschließend gemeinsames Abendessen.
                            Getränke beim Abendessen sind selbst zu zahlen.
                        </p>
                    </div>
                </li>
            </ol>
        </div>

        <div>
            <p class="section-eyebrow">PROGRAMM</p>
            <h2>Samstag, 26. September</h2>

            <ol class="event-schedule">
                <li>
                    <time>ab 09:00 Uhr</time>
                    <div>
                        <h3>Vorträge und IFR-Refresher</h3>
                        <p>
                            IFR-Refresher, IFR-Meteorologie, aktuelle
                            Entwicklungen in der Avionik sowie spezielle
                            Lösungen für die Nachrüstung der PA46,
                            insbesondere von Garmin.
                        </p>
                    </div>
                </li>

                <li>
                    <time>anschließend</time>
                    <div>
                        <h3>Hands-on-Training</h3>
                        <p>
                            Training im eigenen Flugzeug mit erfahrenen
                            Trainern oder Übungen im modernen Simulator.
                        </p>
                    </div>
                </li>

                <li>
                    <time>nach Verfügbarkeit</time>
                    <div>
                        <h3>Checkflüge und Beratung</h3>
                        <p>
                            Möglichkeit zu IFR- oder SET-Checkflügen
                            sowie persönliche Beratung zur Garmin-Avionik.
                        </p>
                    </div>
                </li>
            </ol>
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

            <div class="notice notice--warning">
                Die Übernachtung sowie die Getränke beim gemeinsamen
                Abendessen sind nicht in den Leistungen der MMIG46
                enthalten und müssen selbst bezahlt werden.
            </div>
        </div>

        <div>
            <p class="section-eyebrow">ZUSATZPROGRAMM</p>
            <h2>RAS-Karriereevent</h2>

            <p>
                Am selben Wochenende veranstaltet RAS in EDLN ein
                Karriereevent zur Gewinnung neuer Auszubildender.
                Nach aktuellem Plan sollen dabei auch Einblicke in
                die Hallen und Arbeitsbereiche möglich sein.
            </p>

            <p>
                Die konkrete Einbindung in das MMIG46-Programm erfolgt
                abhängig vom finalen Ablauf der RAS-Veranstaltung.
            </p>
        </div>
    </div>
</section>

<section class="section section--accent" id="anmeldung">
    <div class="container event-registration">
        <div>
            <p class="section-eyebrow">ANMELDUNG</p>
            <h2>Gewünschte Programmpunkte anfragen</h2>

            <p>
                Bitte wählen Sie die gewünschten Elemente aus.
                Die Anmeldung ist zunächst eine verbindliche Anfrage.
                Dr. Gerecht koordiniert die verfügbaren Plätze und
                meldet sich anschließend per E-Mail.
            </p>

            <p>
                Wegen der begrenzten Kapazitäten gilt:
                <strong>First come, first served.</strong>
            </p>
        </div>

        <form method="post"
              action="/trainingswochenende-2026/anmeldung"
              class="event-form">

            <?= Security::csrfField() ?>

            <input type="text"
                   name="website"
                   value=""
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

                <label>
                    <input type="checkbox"
                           name="elements[]"
                           value="fire_training">
                    Feuerlöschübung am Freitag
                </label>

                <label>
                    <input type="checkbox"
                           name="elements[]"
                           value="water_flying_lecture">
                    Vortrag „Wasserfliegen in Deutschland“
                </label>

                <label>
                    <input type="checkbox"
                           name="elements[]"
                           value="dinner">
                    Gemeinsames Abendessen
                </label>

                <label>
                    <input type="checkbox"
                           name="elements[]"
                           value="ifr_refresher">
                    IFR-Refresher
                </label>

                <label>
                    <input type="checkbox"
                           name="elements[]"
                           value="ifr_meteorology">
                    IFR-Meteorologie
                </label>

                <label>
                    <input type="checkbox"
                           name="elements[]"
                           value="avionics_lecture">
                    Avionik und PA46-Nachrüstung
                </label>

                <label>
                    <input type="checkbox"
                           name="elements[]"
                           value="hands_on_training">
                    Hands-on-Training im eigenen Flugzeug
                </label>

                <label>
                    <input type="checkbox"
                           name="elements[]"
                           value="simulator_training">
                    Simulatortraining
                </label>

                <label>
                    <input type="checkbox"
                           name="elements[]"
                           value="ifr_check_flight">
                    IFR-Checkflug
                </label>

                <label>
                    <input type="checkbox"
                           name="elements[]"
                           value="set_check_flight">
                    SET-Checkflug
                </label>

                <label>
                    <input type="checkbox"
                           name="elements[]"
                           value="garmin_consultation">
                    Persönliche Garmin-Beratung
                </label>

                <label>
                    <input type="checkbox"
                           name="elements[]"
                           value="ras_career_event">
                    Interesse am RAS-Karriereevent
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