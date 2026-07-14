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
            check flights is limited.
        </div>

        <a class="button button--primary" href="#registration">
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
            </article>

            <article class="event-fact">
                <span class="event-fact__label">
                    Benefits for members
                </span>

                <strong>Landing fee reduced by 50%</strong>

                <p>
                    No aircraft parking fee will be charged during
                    the training weekend.
                </p>
            </article>

            <article class="event-fact">
                <span class="event-fact__label">
                    Catering
                </span>

                <strong>Provided by MMIG46</strong>

                <p>
                    MMIG46 will provide snacks, coffee, beverages
                    and the group dinner.
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
                    <time>From 4:00 p.m.</time>

                    <div>
                        <h3>Fire-extinguishing exercises</h3>

                        <p>
                            Practical fire-extinguishing exercises
                            with the airport fire brigade in small
                            groups.
                        </p>
                    </div>
                </li>

                <li>
                    <time>6:15 p.m.</time>

                    <div>
                        <h3>Seaplane Flying in Germany</h3>

                        <p>
                            Presentation by Norbert Klippe.
                        </p>
                    </div>
                </li>

                <li>
                    <time>7:30 p.m.</time>

                    <div>
                        <h3>Transfer to Landgut Ramshof</h3>

                        <p>
                            Transfer to the hotel followed by a group
                            dinner. Drinks consumed during dinner
                            must be paid for individually.
                        </p>
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
                    <time>From 9:00 a.m.</time>

                    <div>
                        <h3>Presentations and IFR refresher</h3>

                        <p>
                            IFR refresher training, IFR meteorology,
                            current developments in avionics and
                            special retrofit solutions for PA46
                            aircraft, particularly Garmin systems.
                        </p>
                    </div>
                </li>

                <li>
                    <time>Afterwards</time>

                    <div>
                        <h3>Hands-on training</h3>

                        <p>
                            Practical training in participants’ own
                            aircraft with experienced instructors or
                            exercises in the latest flight simulator.
                        </p>
                    </div>
                </li>

                <li>
                    <time>Subject to availability</time>

                    <div>
                        <h3>Proficiency checks and consultation</h3>

                        <p>
                            IFR or SET proficiency check flights may
                            be arranged. Individual advice on Garmin
                            avionics will also be available.
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

            <div class="notice notice--warning">
                Accommodation and drinks consumed during the group
                dinner are not covered by MMIG46 and must be paid for
                by the participants themselves.
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
                Please select the programme items you would like to
                attend. Submission of this form constitutes a binding
                request, but does not yet guarantee availability.
                Dr Gerecht will coordinate the available places and
                contact you by email.
            </p>

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

            <input
                type="text"
                name="website"
                value=""
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
                        IFR meteorology
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
                        Flight simulator training
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
                        Individual Garmin avionics consultation
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
            </fieldset>



            <label class="event-notes-field">
                <span>Comments</span>

                <textarea
                    name="notes"
                    rows="5"
                    maxlength="2000"
                    placeholder="Special training requests, check flights, number of pilots, etc."
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
                    I agree that my information may be processed for the
                    organisation of the training weekend and forwarded to
                    the responsible organiser.

                    <span class="consent-label__privacy">
                        Further information is available in the
                        <a href="/datenschutz?lang=en">privacy policy</a>.
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