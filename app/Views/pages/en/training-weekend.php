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
            avionics sessions, fire-safety training, proficiency
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
                        <h3>Arrival and shuttle</h3>

                        <p>
                            Shuttle from the main apron (A5 and A6) to
                            the RAS seminar facilities.
                        </p>
                    </div>
                </li>

                <li>
                    <time>3:00–5:00 p.m.</time>

                    <div>
                        <h3>Airport fire brigade, simulator and avionics</h3>

                        <p>
                            Individual airport fire brigade demonstration.
                            The assigned hourly simulator sessions also begin,
                            accompanied by a presentation of current Garmin equipment.
                        </p>
                    </div>
                </li>

                <li>
                    <time>5:00–6:00 p.m.</time>

                    <div>
                        <h3>Seaplane Flying in Germany</h3>
                        <p>Specialist presentation on seaplane operations.</p>
                    </div>
                </li>

                <li>
                    <time>6:00–7:00 p.m.</time>

                    <div>
                        <h3>Transfer to Landgut Ramshof</h3>

                        <p>Transfer from the airport to Landgut Ramshof.</p>
                    </div>
                </li>

                <li>
                    <time>7:30 p.m.</time>

                    <div>
                        <h3>Group dinner</h3>
                        <p>Dinner in the Ramshof’s “Oval Office”.</p>

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
                        <p>Coffee at RAS followed by a joint briefing.</p>
                    </div>
                </li>

                <li>
                    <time>9:00–10:30 a.m.</time>

                    <div>
                        <h3>Specialist presentations and simulator</h3>

                        <p>
                            Presentations on flight operations; assigned hourly
                            simulator sessions run in parallel.
                        </p>
                    </div>
                </li>

                <li>
                    <time>10:30–11:00 a.m.</time>

                    <div>
                        <h3>Garmin avionics and PA46 retrofits</h3>
                        <p>
                            Presentation on current avionics and retrofit options.
                        </p>
                    </div>
                </li>

                <li>
                    <time>From 11:00 a.m.</time>

                    <div>
                        <h3>Personal flight training and Garmin consultation</h3>

                        <p>
                            Individual training with instructors plus Garmin
                            consultation and training flights by prior arrangement.
                        </p>
                    </div>
                </li>

                <li>
                    <time>11:00 a.m.–1:00 p.m.</time>

                    <div>
                        <h3>Murphy’s Law, health and Flying Hope</h3>

                        <p>
                            Presentations on safety, health and Flying Hope’s
                            charitable flight operations.
                        </p>
                    </div>
                </li>

                <li>
                    <time>1:00–2:00 p.m.</time>

                    <div>
                        <h3>Lunch break</h3>

                        <p>Snacks, sandwiches, coffee and mineral water; longer if required.</p>
                    </div>
                </li>

                <li>
                    <time>Afternoon</time>
                    <div>
                        <h3>Training and simulator sessions</h3>
                        <p>Continuation of individual training and assigned simulator sessions.</p>
                    </div>
                </li>

                <li>
                    <time>5:30–6:00 p.m.</time>
                    <div>
                        <h3>Feedback and conclusion</h3>
                        <p>Feedback, planning of future events and departure from 6:00 p.m.</p>
                    </div>
                </li>
            </ol>
        </div>
    </div>
</section>

<section class="section">
    <div class="container event-content">
        <div>
            <p class="section-eyebrow">ARRIVAL BY AIRCRAFT</p>
            <h2>Apron positions A5 and A6</h2>
            <p>
                The reserved parking positions are located below the tower.
                After landing, please advise ground control that you wish to
                taxi to these positions.
            </p>
            <p>
                Pilots without a customer account at Mönchengladbach Airport
                should send the aircraft type, registration, name and postal
                billing address directly to the responsible airport contact.
                The postal address is not collected by this registration form.
            </p>
        </div>

        <div>
            <p class="section-eyebrow">SIMULATOR</p>
            <h2>Current slot allocation</h2>
            <p>
                The Friday slots at 3:00, 4:00 and 5:00 p.m. and the Saturday
                slots at 9:00, 10:00 and 11:00 a.m., noon, and 2:00, 3:00,
                4:00 and 5:00 p.m. are currently assigned.
            </p>
            <p>
                Requests may still be submitted as an expression of interest
                or for the waiting list. Slot swaps are coordinated directly
                with the organisers.
            </p>
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
                        Speaker on IFR meteorology and operational
                        topics in professional aviation.
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
                    <h3>Dr Ralf Wendt</h3>

                    <p class="event-speaker__role">
                        Speaker and aviation expert
                    </p>

                    <p>
                        Dr Ralf Wendt complements the training
                        weekend’s team of speakers and aviation
                        experts.
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
                Rooms are still available at the Ramshof according to the
                latest information. A double room is available for
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
            <p class="section-eyebrow">
                ADDITIONAL PROGRAMME
            </p>

            <h2>RAS career event</h2>

            <p>
                RAS will also hold a career event at EDLN during the
                same weekend to attract new apprentices and trainees.
                The event is expected to include an opportunity to
                visit hangars and operational areas.
            </p>

            <p>
                The exact integration into the MMIG46 programme will
                depend on the final schedule of the RAS event.
            </p>

            <div class="event-additional-programme">
                <h3>Weather-dependent accompanying programme</h3>

                <p>
                    The options are a guided walk through Kempen’s historic
                    old town or a visit to the Grefrath open-air museum. An
                    indoor alternative is planned in poor weather.
                </p>

                <p class="event-additional-programme__condition">
                    Please state definitively during registration who will
                    take part in the accompanying programme.
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
                    Aircraft registration (if arriving by aircraft)

                    <input
                        type="text"
                        name="callsign"
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
                    Number of participants including companions

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
                        Fire-extinguishing exercise on Friday
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
                        IFR meteorology with Frank Lumnitzer
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
                        Hands-on training in your own aircraft
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
                        <small>
                            The published slots are currently assigned; select
                            this as an interest or waiting-list request
                        </small>
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
                        value="ras_career_event"
                    >

                    <span class="programme-option__text">
                        Interest in the RAS career event or hangar visit
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="garmin_training_flight"
                    >

                    <span class="programme-option__text">
                        Garmin consultation with a joint flight in your own aircraft
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="kempen_old_town_tour"
                    >

                    <span class="programme-option__text">
                        Guided tour of Kempen’s historic old town for
                        accompanying persons and guests

                        <small>
                            Subject to demand and sufficient interest
                        </small>
                    </span>
                </label>

                <label class="programme-option">
                    <input
                        type="checkbox"
                        name="elements[]"
                        value="grefrath_open_air_museum"
                    >

                    <span class="programme-option__text">
                        Grefrath open-air museum for accompanying persons and guests
                        <small>Weather-dependent alternative to the old-town tour</small>
                    </span>
                </label>
            </fieldset>

            <label class="event-notes-field">
                <span>Comments</span>

                <textarea
                    name="notes"
                    rows="5"
                    maxlength="2000"
                    placeholder="Special training requests, proficiency checks, accompanying person, estimated arrival time, etc."
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
