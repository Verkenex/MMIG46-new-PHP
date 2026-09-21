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
    'Other',
];
?>

<section class="event-hero">
    <div class="container event-hero__inner">
        <p class="event-kicker">
            MMIG46 TRAINING WEEKEND
        </p>

        <h1>Use it or lose it.</h1>

        <p class="event-hero__date">
            25–26 September 2026 · Mönchengladbach Airport EDLN
        </p>

        <p class="event-hero__lead">
            Two days of IFR refresher training, practical exercises,
            avionics sessions, a fire-brigade demonstration, proficiency
            checks and personal exchange in the modern RAS seminar
            facilities.
        </p>

        <div class="event-alert">
            <strong>First come, first served:</strong>
            Capacity for individual programme items, instructors and
            proficiency checks is limited.
        </div>

        <div
            class="event-price-box"
            aria-label="Participation fees"
        >
            <div class="event-price-box__heading">
                Participation fees
            </div>

            <div class="event-price-box__prices">
                <div class="event-price">
                    <span class="event-price__label">
                        MMIG46 members
                    </span>

                    <strong>EUR 450</strong>
                </div>

                <div class="event-price">
                    <span class="event-price__label">
                        Non-members
                    </span>

                    <strong>EUR 650</strong>
                </div>
            </div>

            <p class="event-price-box__note">
                Prior registration is mandatory. Participation is only
                possible after registration and subsequent confirmation
                by the organiser.
            </p>
        </div>

        <a
            class="button button--primary"
            href="#registration"
        >
            Request programme items now
        </a>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="event-facts">
            <article class="event-fact">
                <span class="event-fact__label">
                    Location
                </span>

                <strong>RAS seminar facilities at EDLN</strong>

                <p>
                    Modern seminar and training facilities at
                    Mönchengladbach Airport.
                </p>

                <p class="event-fact__thanks">
                    We would like to thank RAS, and especially
                    Mr Frank Prochaska, for their support and for
                    providing the seminar facilities.
                </p>
            </article>

            <article class="event-fact">
                <span class="event-fact__label">
                    For participants
                </span>

                <strong>Landing fee reduced by 50%</strong>

                <p>
                    No aircraft parking fee will be charged during
                    the training weekend.
                </p>
            </article>

            <article class="event-fact">
                <span class="event-fact__label">
                    Participation
                </span>

                <strong>Prior registration required</strong>

                <p>
                    Participation and individual programme items are
                    only available following prior registration and
                    confirmation.
                </p>
            </article>
        </div>
    </div>
</section>

<section class="section section--soft">
    <div class="container event-content">
        <div>
            <p class="section-eyebrow">
                PROGRAMME
            </p>

            <h2>Friday, 25 September</h2>

            <ol class="event-schedule">
                <li>
                    <time>12:00–2:30 p.m.</time>

                    <div>
                        <h3>Arrival and shuttle to RAS</h3>

                        <p>
                            Please inform ground control that you are attending
                            the MMIG46 event and park your aircraft on the main
                            apron (A5 or A6). Then call Frank Prochaska on
                            <a href="tel:+491782550246">+49 178 2550246</a>;
                            the shuttle will take you from the apron to RAS.
                        </p>

                        <p>
                            Drivers should use the main RAS car park: continue
                            past the turn directly in front of the main building,
                            then turn left a short distance further on.
                        </p>
                    </div>
                </li>

                <li>
                    <time>3:00–5:00 p.m.</time>

                    <div>
                        <h3>Airport fire brigade</h3>

                        <p>
                            Individual demonstration by the airport fire brigade
                            with an emergency vehicle, led by Mr Hensen.
                        </p>
                    </div>
                </li>

                <li>
                    <time>From 3:00 p.m.</time>

                    <div>
                        <h3>Simulator, training/check flights and Garmin</h3>

                        <p>
                            Hourly simulator sessions at MG-Flyers according to
                            the schedule. Frank Lumnitzer and Ralph Wendt are
                            available for training flights on Friday afternoon
                            or evening. IFR or SET proficiency checks can also
                            be conducted during these flights; please contact
                            the organisers directly if interested. Fabian
                            Kienzle will demonstrate the latest Garmin devices.
                        </p>
                    </div>
                </li>

                <li>
                    <time>5:00–6:00 p.m.</time>

                    <div>
                        <h3>Seaplane Flying in Germany</h3>

                        <p>
                            Presentation by
                            <strong>Norbert Klippel</strong>.
                        </p>
                    </div>
                </li>

                <li>
                    <time>6:00–7:00 p.m.</time>

                    <div>
                        <h3>Transfer to Landgut Ramshof</h3>

                        <p>
                            Transfer to Landgut Ramshof. The group dinner begins
                            at 7:30 p.m. in the Oval Office.
                        </p>

                        <div class="event-self-pay-notice">
                            <strong>Personal contribution:</strong>
                            Drinks ordered during the group dinner
                            must be paid for individually by the
                            participants.
                        </div>
                    </div>
                </li>
            </ol>
        </div>

        <div>
            <p class="section-eyebrow">
                PROGRAMME
            </p>

            <h2>Saturday, 26 September</h2>

            <ol class="event-schedule">
                <li>
                    <time>8:30–9:00 a.m.</time>

                    <div>
                        <h3>Arrival and daily briefing</h3>

                        <p>Arrival at RAS, coffee and daily briefing.</p>
                    </div>
                </li>

                <li>
                    <time>From 9:00 a.m.</time>

                    <div>
                        <h3>Simulator training</h3>

                        <p>
                            Hourly simulator sessions at MG-Flyers according to
                            the schedule.
                        </p>
                    </div>
                </li>

                <li>
                    <time>9:00–10:30 a.m.</time>

                    <div>
                        <h3>IFR refresher and weather apps</h3>

                        <p>
                            Presentations by <strong>Frank Lumnitzer</strong>
                            covering an IFR refresher and the selection and use
                            of weather apps.
                        </p>
                    </div>
                </li>

                <li>
                    <time>10:30–11:00 a.m.</time>

                    <div>
                        <h3>Garmin avionics and PA46 retrofit solutions</h3>
                        <p>
                            <strong>Fabian Kienzle</strong> presents the latest
                            Garmin avionics and specific retrofit solutions for
                            PA46 aircraft.
                        </p>
                    </div>
                </li>

                <li>
                    <time>From 11:00 a.m.</time>

                    <div>
                        <h3>Personal flight training, checks and consultation</h3>

                        <p>
                            Personal training with Frank Lumnitzer and Ralph
                            Wendt; IFR or SET proficiency checks can also be
                            conducted during these flights. Stefan Bassiri will
                            be available in an advisory capacity. Individual
                            Garmin consultation and training flights can be
                            arranged with Fabian Kienzle, who is also available
                            for joint training flights on Sunday.
                        </p>
                    </div>
                </li>

                <li>
                    <time>11:00 a.m.–1:00 p.m.</time>

                    <div>
                        <h3>Aviation medicine, stress and simulator training</h3>

                        <p>
                            Presentations by <strong>Dr Michael Offermann</strong>:
                        </p>
                        <p><strong>1.</strong> Murphy’s law and the value of simulator training for non-commercial pilots</p>
                        <p><strong>2.</strong> Managing non-system-related stress on board</p>
                        <p><strong>3.</strong> The 30 most important medical issues to discuss with an aviation medical examiner</p>
                        <p><strong>4.</strong> Volunteering as a pilot or co-pilot for Flying Hope</p>
                    </div>
                </li>

                <li>
                    <time>1:00–2:00 p.m. (and longer)</time>

                    <div>
                        <h3>Lunch break and afternoon programme</h3>

                        <p>
                            Snacks, filled rolls, coffee and mineral water,
                            followed by further individual training and the
                            scheduled simulator sessions.
                        </p>
                    </div>
                </li>

                <li>
                    <time>5:30–6:00 p.m.</time>

                    <div>
                        <h3>Feedback and conclusion</h3>

                        <p>
                            Feedback and planning of future events from
                            5:30 p.m.; conclusion and departure at 6:00 p.m.
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
            <p class="section-eyebrow">
                SPEAKERS &amp; EXPERTS
            </p>

            <h2>
                Experience in aviation operations, training and avionics
            </h2>

            <p>
                Specialist presentations and personal consultation by
                experienced experts from general and professional
                aviation.
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
                        height="800"
                    >
                </div>

                <div class="event-speaker__content">
                    <h3>Frank Lumnitzer</h3>

                    <p class="event-speaker__role">
                        Senior Aviation Executive
                    </p>

                    <p>
                        Speaker on IFR refresher training and weather apps,
                        and instructor for individual training and proficiency
                        check flights.
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
                        height="800"
                    >
                </div>

                <div class="event-speaker__content">
                    <h3>Fabian Kienzle</h3>

                    <p class="event-speaker__role">
                        Garmin avionics and PA46 retrofit solutions
                    </p>

                    <p>
                        Personal consultation on Garmin systems,
                        avionics solutions and retrofit options for
                        PA46 aircraft.
                    </p>
                </div>
            </article>

            <article class="event-speaker">
                <div
                    class="event-speaker__image
                           event-speaker__image--placeholder"
                >
                    <span aria-hidden="true">
                        RW
                    </span>
                </div>

                <div class="event-speaker__content">
                    <h3>Ralph Wendt</h3>

                    <p class="event-speaker__role">
                        Flight training and proficiency checks
                    </p>

                    <p>
                        Personal training in participants’ own aircraft and
                        IFR and SET proficiency checks.
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
                        height="800"
                    >
                </div>

                <div class="event-speaker__content">
                    <h3>Norbert Klippel</h3>

                    <p class="event-speaker__role">
                        Speaker on seaplane flying in Germany
                    </p>

                    <p>
                        Presentation on the operational and
                        organisational aspects of seaplane flying.
                    </p>
                </div>
            </article>

            <article class="event-speaker">
                <div
                    class="event-speaker__image
                           event-speaker__image--placeholder"
                >
                    <span aria-hidden="true">MO</span>
                </div>

                <div class="event-speaker__content">
                    <h3>Dr Michael Offermann</h3>

                    <p class="event-speaker__role">
                        Aviation medicine, stress and simulator training
                    </p>

                    <p>
                        Presentations on simulator training, stress management,
                        aviation medicine and Flying Hope.
                    </p>
                </div>
            </article>

            <article class="event-speaker">
                <div
                    class="event-speaker__image
                           event-speaker__image--placeholder"
                >
                    <span aria-hidden="true">SB</span>
                </div>

                <div class="event-speaker__content">
                    <h3>Stefan Bassiri</h3>

                    <p class="event-speaker__role">Consultation</p>

                    <p>
                        Stefan Bassiri will be available to advise participants
                        on Saturday.
                    </p>
                </div>
            </article>
        </div>
    </div>
</section>

<section class="section">
    <div class="container event-content">
        <div>
            <p class="section-eyebrow">
                ACCOMMODATION
            </p>

            <h2>Landgut Ramshof in Willich</h2>

            <p>
                A limited room allocation has been arranged for
                MMIG46 participants. A double room is available for
                <strong>EUR 110 for one night</strong>.
            </p>

            <p>
                Participants must book their rooms directly with
                Landgut Ramshof. Please state the booking reference
                <strong>“MMIG46”</strong> when making the reservation.
            </p>

            <address class="event-contact-card">
                <strong>Landgut Ramshof</strong>

                <span>
                    Ramshof 1<br>
                    47877 Willich-Neersen<br>
                    Germany
                </span>

                <span>
                    Telephone:
                    <a href="tel:+49215695890">
                        +49 2156 95890
                    </a>
                </span>

                <span>
                    Email:
                    <a href="mailto:stay@ramshof.de">
                        stay@ramshof.de
                    </a>
                </span>
            </address>

            <div class="event-self-pay-notice">
                <strong>Personal contribution:</strong>
                Accommodation and drinks ordered during the group
                dinner are not included in the MMIG46 services and
                must be paid for by the participants themselves.
            </div>
        </div>

        <div>
            <p class="section-eyebrow">ACCOMPANYING PROGRAMME</p>

            <h2>Saturday from approximately 10:00 a.m.</h2>

            <div class="event-additional-programme">
                <h3>Programme for accompanying persons</h3>

                <p>
                    Depending on the weather, the programme will include either
                    a guided tour of Kempen’s historic old town or a visit to
                    the Lower Rhine Open-Air Museum in Grefrath. In poor weather,
                    a coffee gathering and sparkling wine will be hosted.
                </p>

                <p class="event-additional-programme__condition">
                    Led by Bärbel Gerecht
                </p>
            </div>
        </div>
    </div>
</section>

<section
    class="section section--accent"
    id="registration"
>
    <div class="container event-registration">
        <div>
            <p class="section-eyebrow">
                REGISTRATION
            </p>

            <h2>Request your preferred programme items</h2>

            <p>
                Prior registration is mandatory for all participants.
                Please select the programme items you would like to
                attend. Submission of this form constitutes a binding
                request, but does not yet guarantee availability.
                Dr Gerecht will coordinate the available places and
                contact you by email.
            </p>

            <div class="event-registration-prices">
                <strong>Participation fees:</strong>
                EUR 450 for MMIG46 members ·
                EUR 650 for non-members
            </div>

            <p>
                Capacity is limited:
                <strong>first come, first served.</strong>
            </p>
        </div>

        <form
            method="post"
            action="/trainingswochenende-2026/anmeldung"
            class="event-form"
        >
            <input
                type="hidden"
                name="_csrf"
                value="<?= Security::e(Security::csrf()) ?>"
            >

            <input
                type="hidden"
                name="language"
                value="en"
            >

            <input type="hidden" name="idempotency_token" value="<?= Security::e((string) ($idempotencyToken ?? '')) ?>">

            <input
                type="checkbox"
                name="registration_check"
                value="1"
                tabindex="-1"
                autocomplete="off"
                class="form-honeypot"
                aria-hidden="true"
            >

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

                    <input
                        type="text"
                        name="name"
                        required
                        maxlength="150"
                        autocomplete="name"
                    >
                </label>

                <label>
                    Email address *

                    <input
                        type="email"
                        name="email"
                        required
                        maxlength="190"
                        autocomplete="email"
                    >
                </label>

                <label>
                    Aircraft registration *

                    <input
                        type="text"
                        name="callsign"
                        required
                        maxlength="20"
                        placeholder="e.g. D-EXYZ"
                        autocomplete="off"
                    >
                </label>

                <label>
                    Aircraft type

                    <select name="aircraft_model">
                        <option value="">
                            Please select
                        </option>

                        <?php foreach ($aircraftModels as $model): ?>
                            <option
                                value="<?= Security::e($model) ?>"
                            >
                                <?= Security::e($model) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label>
                    Number of participants

                    <input
                        type="number"
                        name="participants"
                        min="1"
                        max="4"
                        value="1"
                    >
                </label>
            </div>

            <fieldset class="programme-options">
                <legend>Requested programme items *</legend>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="fire_training"
                    >

                    <span class="programme-option__text">
                        Airport fire-brigade demonstration on Friday
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="water_flying_lecture"
                    >

                    <span class="programme-option__text">
                        Presentation “Seaplane Flying in Germany”
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="dinner"
                    >

                    <span class="programme-option__text">
                        Group dinner at Landgut Ramshof
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="ifr_refresher"
                    >

                    <span class="programme-option__text">
                        IFR refresher
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="ifr_meteorology"
                    >

                    <span class="programme-option__text">
                        Weather apps and their use with Frank Lumnitzer
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="avionics_lecture"
                    >

                    <span class="programme-option__text">
                        Avionics and PA46 retrofit solutions
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="hands_on_training"
                    >

                    <span class="programme-option__text">
                        Personal training/practice flight in your own aircraft
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="simulator_training"
                    >

                    <span class="programme-option__text">
                        Training on an ALSIM simulator at MG-Flyers
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="ifr_check_flight"
                    >

                    <span class="programme-option__text">
                        IFR proficiency check flight
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="set_check_flight"
                    >

                    <span class="programme-option__text">
                        SET proficiency check flight
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="garmin_consultation"
                    >

                    <span class="programme-option__text">
                        Personal Garmin consultation by Fabian Kienzle
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="offermann_lectures"
                    >

                    <span class="programme-option__text">
                        Presentations by Dr Michael Offermann
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="kempen_old_town_tour"
                    >

                    <span class="programme-option__text">
                        Accompanying programme on Saturday

                        <small>
                            Depending on the weather: Kempen old town,
                            Grefrath Open-Air Museum, or coffee and sparkling wine
                        </small>
                    </span>
                </label>
            </fieldset>

            <label class="event-notes-field">
                <span>Comments</span>

                <textarea
                    name="notes"
                    rows="5"
                    maxlength="2000"
                    placeholder="Special training requests, proficiency checks, number of pilots, etc."
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
                    I agree that my information may be processed for
                    the organisation of the training weekend and
                    forwarded to the responsible organiser.

                    <span class="consent-label__privacy">
                        Further information is available in the
                        <a href="/datenschutz?lang=en">
                            privacy policy
                        </a>.
                    </span>
                </span>
            </label>

            <button
                type="submit"
                class="button button--primary"
            >
                Submit binding request
            </button>
        </form>
    </div>
</section>
