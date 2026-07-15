<?php

use MMIG46\Core\I18n;
use MMIG46\Core\Security;

$membershipTypes = [
    'corporate_supplier' => 'Corporate Supplier MMIG46 – EUR 2,500 annual fee',
    'owner_pilot' => 'Owner / Pilot – EUR 250 annual fee',
    'associate_pilot' => 'Associate Pilot – EUR 250 annual fee',
];

$aircraftModels = [
    'PA46-310',
    'PA46-350',
    'PA46R-350T',
    'PA46-JetPROP',
    'PA46-M500',
    'PA46-M600',
    'PA46-M700',
    $isEn ? 'Other' : 'Andere',
];

?>

<section class="membership-page">
    <div class="container">
        <header class="membership-header">
            <p class="eyebrow">MMIG46 e.V.</p>
            <h1>Membership Application</h1>

            <p>Complete digitally, submit online or print as a one-page form.</p>

            <button class="button button--secondary print-button" type="button" onclick="window.print()">
                Print form
            </button>
        </header>

        <form class="membership-form" method="post" action="<?= Security::e(I18n::url('/mitgliedsantrag', 'en')) ?>">
            <?= Security::csrfField() ?>

            <fieldset class="membership-fieldset membership-status">
                <legend>Membership</legend>

                <div class="membership-options">
                    <?php foreach ($membershipTypes as $value => $label): ?>
                        <label class="membership-option">
                            <input
                                type="radio"
                                name="membership_type"
                                value="<?= Security::e($value) ?>"
                            >
                            <span class="print-check" aria-hidden="true"></span>
                            <span><?= Security::e($label) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </fieldset>

            <fieldset class="membership-fieldset">
                <legend>Billing address</legend>

                <div class="form-grid">
                    <label>
                        Company / Name
                        <input name="invoice_name" autocomplete="organization">
                    </label>

                    <label>
                        Street
                        <input name="street" autocomplete="street-address">
                    </label>

                    <label class="span-2">
                        Postal code, city, country
                        <input name="postal_city_country" autocomplete="address-level2">
                    </label>
                </div>
            </fieldset>

            <fieldset class="membership-fieldset">
                <legend>Member details</legend>

                <div class="form-grid">
                    <label>
                        Last name *
                        <input name="last_name" required autocomplete="family-name">
                    </label>

                    <label>
                        First name *
                        <input name="first_name" required autocomplete="given-name">
                    </label>

                    <label>
                        Date of birth
                        <input name="birthday" inputmode="numeric" placeholder="DD.MM.YYYY" autocomplete="bday">
                    </label>

                    <label>
                        Profession / Occupation
                        <input name="occupation">
                    </label>

                    <label class="span-2">
                        Co-pilot / Partner
                        <input name="copilot_spouse">
                    </label>
                </div>
            </fieldset>

            <fieldset class="membership-fieldset">
                <legend>Aviation information</legend>

                <div class="form-grid">
                    <label>
                        Total flight time
                        <input name="total_time">
                    </label>

                    <label>
                        Time on type
                        <input name="time_in_type">
                    </label>

                    <label>
                        Licence / Ratings
                        <input name="license_ratings">
                    </label>

                    <label>
                        Actively flying since
                        <input name="flying_since">
                    </label>

                    <label class="span-2">
                        Previous aircraft types / Experience
                        <textarea name="aviation_history" rows="2"></textarea>
                    </label>
                </div>
            </fieldset>

            <fieldset class="membership-fieldset">
                <legend>Aircraft</legend>

                <div class="form-grid">
                    <label>
                        Registered holder / Owner
                        <input name="registered_owner">
                    </label>

                    <label>
                        Registration / Callsign
                        <input name="callsign">
                    </label>

                    <label class="print-line-field">
                        Model
                        <select name="model" class="screen-control">
                            <option value="">Please select</option>
                            <?php foreach ($aircraftModels as $model): ?>
                                <option value="<?= Security::e($model) ?>"><?= Security::e($model) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="print-text-line" aria-hidden="true"></span>
                    </label>

                    <label>
                        Year of manufacture
                        <input name="aircraft_year">
                    </label>

                    <label>
                        Home base
                        <input name="home_base">
                    </label>

                    <label class="span-2">
                        Relevant modifications
                        <textarea name="modifications" rows="2"></textarea>
                    </label>
                </div>
            </fieldset>

            <fieldset class="membership-fieldset">
                <legend>Contact</legend>

                <div class="form-grid">
                    <label>
                        Business phone
                        <input name="office_phone" autocomplete="tel">
                    </label>

                    <label>
                        Business email
                        <input name="office_email" type="email" autocomplete="email">
                    </label>

                    <label>
                        Private phone
                        <input name="home_phone" autocomplete="tel">
                    </label>

                    <label>
                        Private email *
                        <input name="private_email" type="email" required autocomplete="email">
                    </label>

                    <label class="span-2">
                        Mobile
                        <input name="mobile" autocomplete="tel">
                    </label>
                </div>
            </fieldset>

            <fieldset class="membership-fieldset consent-box">
                <legend>Consent</legend>

                <p>
                    I confirm that I have read the articles of association of MMIG46 e.V.
                    and accept them as binding.
                </p>

                <p>
                    I consent to my personal data being processed by MMIG46 e.V. for
                    membership administration and for sending association-related information.
                </p>

                <label class="consent-check">
                    <input type="checkbox" name="consent" required>
                    <span class="print-check" aria-hidden="true"></span>
                    <span>I consent to the processing of my data and to the information stated above.</span>
                </label>
            </fieldset>

            <div class="membership-signature">
                <p>Place, date: __________________________________________</p>
                <p>Signature: ___________________________________________</p>
            </div>

            <div class="membership-actions">
                <button class="button button--primary" type="submit">Submit membership application</button>
                <button class="button button--secondary" type="button" onclick="window.print()">Print</button>
            </div>
        </form>
    </div>
</section>