<?php

use MMIG46\Core\Security;

$membershipTypes = [
    'corporate_supplier' => 'Corporate Supplier MMIG46 – 2.500 EUR Jahresbeitrag',
    'owner_pilot' => 'Owner / Pilot – 250 EUR Jahresbeitrag',
    'associate_pilot' => 'Associate Pilot – 250 EUR Jahresbeitrag',
];

$aircraftModels = [
    'PA46-310',
    'PA46-350',
    'PA46-JetPROP',
    'PA46R-350T',
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
            <h1>Mitgliedsantrag</h1>
            <p>Digital ausfüllen, absenden oder als einseitiges Formular drucken.</p>

            <button class="button button--secondary print-button" type="button" onclick="window.print()">
                Formular drucken
            </button>
        </header>

        <form class="membership-form" method="post" action="/mitgliedsantrag">
            <?= Security::csrfField() ?>

            <fieldset class="membership-fieldset membership-status">
                <legend>Mitgliedschaft</legend>

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
                <legend>Rechnungsanschrift</legend>

                <div class="form-grid">
                    <label>
                        Firma / Name *
                        <input name="invoice_name" autocomplete="organization" required>
                    </label>

                    <label>
                        Straße *
                        <input name="street" autocomplete="street-address" required>
                    </label>

                    <label class="span-2">
                        PLZ, Ort, Land *
                        <input name="postal_city_country" autocomplete="address-level2" required>
                    </label>
                </div>
            </fieldset>

            <fieldset class="membership-fieldset">
                <legend>Mitgliedsdaten</legend>

                <div class="form-grid">
                    <label>
                        Nachname *
                        <input name="last_name" required autocomplete="family-name">
                    </label>

                    <label>
                        Vorname *
                        <input name="first_name" required autocomplete="given-name">
                    </label>

                    <label>
                        Geburtstag
                        <input name="birthday" inputmode="numeric" placeholder="TT.MM.JJJJ" autocomplete="bday">
                    </label>

                    <label>
                        Beruf / Tätigkeit
                        <input name="occupation">
                    </label>

                    <label class="span-2">
                        Co-Pilot / Partner
                        <input name="copilot_spouse">
                    </label>
                </div>
            </fieldset>

            <fieldset class="membership-fieldset">
                <legend>Fliegerische Angaben</legend>

                <div class="form-grid">
                    <label>
                        Gesamtflugzeit
                        <input name="total_time">
                    </label>

                    <label>
                        Flugzeit auf Muster
                        <input name="time_in_type">
                    </label>

                    <label>
                        Lizenz / Ratings
                        <input name="license_ratings">
                    </label>

                    <label>
                        Fliegerisch aktiv seit
                        <input name="flying_since">
                    </label>

                    <label class="span-2">
                        Bisherige Muster / Erfahrung
                        <textarea name="aviation_history" rows="2"></textarea>
                    </label>
                </div>
            </fieldset>

            <fieldset class="membership-fieldset">
                <legend>Flugzeug</legend>

                <div class="form-grid">
                    <label>
                        Eingetragener Halter / Eigentümer
                        <input name="registered_owner">
                    </label>

                    <label>
                        Kennzeichen / Callsign
                        <input name="callsign">
                    </label>

                    <label class="print-line-field">
                        Modell
                        <select name="model" class="screen-control">
                            <option value="">Bitte wählen</option>
                            <?php foreach ($aircraftModels as $model): ?>
                                <option value="<?= Security::e($model) ?>"><?= Security::e($model) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="print-text-line" aria-hidden="true"></span>
                    </label>

                    <label>
                        Baujahr
                        <input name="aircraft_year">
                    </label>

                    <label>
                        Homebase
                        <input name="home_base">
                    </label>

                    <label class="span-2">
                        Relevante Modifikationen
                        <textarea name="modifications" rows="2"></textarea>
                    </label>
                </div>
            </fieldset>

            <fieldset class="membership-fieldset">
                <legend>Kontakt</legend>

                <div class="form-grid">
                    <label>
                        Telefon geschäftlich
                        <input name="office_phone" autocomplete="tel">
                    </label>

                    <label>
                        E-Mail geschäftlich
                        <input name="office_email" type="email" autocomplete="email">
                    </label>

                    <label>
                        Telefon privat
                        <input name="home_phone" autocomplete="tel">
                    </label>

                    <label>
                        E-Mail privat *
                        <input name="private_email" type="email" required autocomplete="email">
                    </label>

                    <label class="span-2">
                        Mobil *
                        <input name="mobile" autocomplete="tel" required>
                    </label>
                </div>
            </fieldset>

            <fieldset class="membership-fieldset consent-box">
                <legend>Einwilligung</legend>

                <p>
                    Ich bestätige, die Satzung des MMIG46 e.V. gelesen zu haben und akzeptiere diese verbindlich.
                </p>

                <p>
                    Ich bin damit einverstanden, dass meine personenbezogenen Daten durch den MMIG46 e.V.
                    zur Mitgliederverwaltung und zur Zusendung vereinsbezogener Informationen verarbeitet werden.
                </p>

            <label class="checkbox consent-inline">
                <input type="checkbox" name="consent" value="1" required>
                <span>
                    Ich stimme der Verarbeitung meiner Daten zum Zweck der Bearbeitung dieses Mitgliedsantrags zu.
                </span>
            </label>
            </fieldset>

            <div class="membership-signature">
                <p>Ort, Datum: __________________________________________</p>
                <p>Unterschrift: _________________________________________</p>
            </div>

            <div class="membership-actions">
                <button class="button button--primary" type="submit">Mitgliedsantrag absenden</button>
                <button class="button button--secondary" type="button" onclick="window.print()">Drucken</button>
            </div>
        </form>
    </div>
</section>