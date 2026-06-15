<section class="page-hero compact">
    <div class="container">
        <p class="eyebrow">MMIG46 e.V.</p>
        <h1>Mitgliedsantrag</h1>
        <p>Digital ausfüllen, absenden oder direkt ausdrucken.</p>
        <button type="button" class="button button-secondary no-print" onclick="window.print()">Formular drucken</button>
    </div>
</section>

<section class="section">
    <div class="container form-shell">
        <form method="post" action="/mitgliedsantrag" class="application-form">
            <?= \MMIG46\Core\Security::csrfField() ?>

            <fieldset>
                <legend>Membership Status</legend>
                <label><input type="radio" name="membership_type" value="Corporate Supplier MMIG46" required> Corporate Supplier MMIG46 (EUR 2.500 annual fee)</label>
                <label><input type="radio" name="membership_type" value="Owner / Pilot"> Owner / Pilot (EUR 250 annual fee)</label>
                <label><input type="radio" name="membership_type" value="Associate Pilot"> Associate Pilot (EUR 250 annual fee)</label>
            </fieldset>

            <fieldset>
                <legend>Invoice</legend>
                <label>Company/Name <input name="invoice_name" required></label>
                <label>Street <input name="street"></label>
                <label>Postal Code, City/Country <input name="postal_city_country"></label>
            </fieldset>

            <fieldset>
                <legend>Member Information</legend>
                <label>Last Name <input name="last_name" required></label>
                <label>First Name <input name="first_name" required></label>
                <label>Birthday <input name="birthday" placeholder="YY/MM/DD"></label>
                <label>Occupation/Business <input name="occupation"></label>
                <label>Co-Pilot/Spouse <input name="copilot_spouse"></label>
            </fieldset>

            <fieldset>
                <legend>Flying Information</legend>
                <label>Total Time <input name="total_time"></label>
                <label>In Type <input name="time_in_type"></label>
                <label>License and Ratings <input name="license_ratings"></label>
                <label>Flying since <input name="flying_since"></label>
                <label>Aviation History/Types flown <textarea name="aviation_history"></textarea></label>
            </fieldset>

            <fieldset>
                <legend>Aircraft Information</legend>
                <label>Registered Owner <input name="registered_owner"></label>
                <label>Call sign <input name="callsign"></label>
                <label>Model
                    <select name="model">
                        <option value="PA46-310">PA46-310</option>
                        <option value="PA46-350">PA46-350</option>
                        <option value="PA46R-350T">PA46R-350T</option>
                        <option value="PA46-500">PA46-500</option>
                        <option value="PA46-JETPROP">PA46-JETPROP</option>
                        <option value="Other">Other</option>
                    </select>
                </label>
                <label>Serial Number <input name="serial_number"></label>
                <label>Year <input name="aircraft_year"></label>
                <label>Notable Modifications <textarea name="modifications"></textarea></label>
                <label>Home based Airport <input name="home_base"></label>
            </fieldset>

            <fieldset>
                <legend>Communication</legend>
                <label>Daytime/Office Phone <input name="office_phone"></label>
                <label>Daytime E-Mail <input type="email" name="office_email"></label>
                <label>Private/Home Phone <input name="home_phone"></label>
                <label>Private E-Mail <input type="email" name="private_email" required></label>
                <label>Mobile <input name="mobile"></label>
            </fieldset>

            <fieldset>
                <legend>Einwilligung / Declaration of consent</legend>
                <p>
                    Ich bestätige, die Satzung des Vereins MMIG46 e.V. gelesen zu haben und akzeptiere diese verbindlich.
                    I confirm that I have read the constitution of MMIG46 and agree to the terms and conditions.
                </p>
                <p>
                    Ich erkläre mich einverstanden, dass meine persönlichen Daten durch MMIG46 e.V. zur Mitgliederverwaltung
                    und zur Zusendung von Informationen rund um MMIG46 e.V. genutzt werden.
                </p>
                <label class="checkbox">
                    <input type="checkbox" name="consent" value="1" required>
                    Ich stimme der Verarbeitung meiner Daten und den oben genannten Hinweisen zu.
                </label>
            </fieldset>

            <div class="form-actions no-print">
                <button class="button" type="submit">Mitgliedsantrag absenden</button>
                <button class="button button-secondary" type="button" onclick="window.print()">Drucken</button>
            </div>

            <div class="print-signature">
                <p>Ort, Datum: ________________________________</p>
                <p>Unterschrift: _______________________________</p>
            </div>
        </form>
    </div>
</section>