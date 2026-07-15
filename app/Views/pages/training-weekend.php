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
                        <p>Vortrag von Norbert Klippel.</p>
                    </div>
                </li>

                <li>
                    <time>19:30 Uhr</time>
                    <div>
                        <h3>Transfer zum Ramshof</h3>
                            <p>
                                Anschließend gemeinsames Abendessen im Landgut Ramshof.
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
                    <time>ab 09:00 Uhr</time>

                    <div>
                        <h3>Vorträge</h3>

                        <p>
                            IFR-Refresher, IFR-Meteorologie durch
                            <strong>Frank Lumnitzer</strong>
                            <span class="speaker-role">
                                (Senior Aviation Executive)
                            </span>,
                            aktuelle Entwicklungen in der Avionik sowie
                            spezielle Lösungen für die Nachrüstung der PA46.
                        </p>

                        <p>
                            Die persönliche Beratung zu Garmin-Systemen
                            erfolgt durch <strong>Fabian Kienzle</strong>.
                            Zum Experten- und Referententeam gehört außerdem
                            <strong>Dr. Ralf Wendt</strong>.
                        </p>
                    </div>
                </li>

                <li>
                    <time>anschließend</time>

                    <div>
                        <h3>Hands-on-Training</h3>

                        <p>
                            Training im eigenen Flugzeug mit den besten
                            Trainern im deutschsprachigen Raum sowie praktische
                            Übungen und individuelle Trainingssequenzen.
                        </p>
                    </div>
                </li>

                <li>
                    <time>parallel / nach Verfügbarkeit</time>

                    <div>
                        <h3>Simulatortraining</h3>

                        <p>
                            Übungen auf einem modernen Simulator von
                            <strong>ALSIM</strong>, FNTP-zugelassen,
                            bei <strong>MG-Flyers</strong>.
                        </p>
                    </div>
                </li>

                <li>
                    <time>nach Verfügbarkeit</time>

                    <div>
                        <h3>Checkflüge und Garmin-Beratung</h3>

                        <p>
                            Möglichkeit zu IFR- oder SET-Checkflügen sowie
                            persönliche Beratung zur Garmin-Avionik durch
                            <strong>Fabian Kienzle</strong>.
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
                        Referent für IFR-Meteorologie und operative
                        Themen der professionellen Luftfahrt.
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
                    <h3>Dr. Ralf Wendt</h3>
                    <p class="event-speaker__role">
                        Referent und Luftfahrtexperte
                    </p>
                    <p>
                        Dr. Ralf Wendt ergänzt das Referenten- und
                        Expertenteam des Trainingswochenendes.
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

            <div class="event-additional-programme">
                <h3>Altstadttour in Kempen</h3>

                <p>
                    Für Begleitpersonen, Gäste und interessierte
                    Teilnehmerinnen ist eine gemeinsame Tour durch die
                    historische Kempener Altstadt vorgesehen.
                </p>

                <p class="event-additional-programme__condition">
                    Bei Bedarf beziehungsweise ausreichendem Interesse.
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

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="fire_training"
                    >
                    <span class="programme-option__text">
                        Feuerlöschübung am Freitag
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
                        IFR-Meteorologie mit Frank Lumnitzer
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
                        Hands-on-Training im eigenen Flugzeug
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
                        value="ras_career_event"
                    >
                    <span class="programme-option__text">
                        Interesse am RAS-Karriereevent
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="kempen_old_town_tour">

                    <span class="programme-option__text">
                        Altstadttour in Kempen für Begleitpersonen und Gäste
                        <small>
                            Bei Bedarf beziehungsweise ausreichendem Interesse
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