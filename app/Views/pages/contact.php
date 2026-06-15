<?php

use MMIG46\Core\Security;

$captchaQuestion = $captchaQuestion ?? '';
?>

<section class="contact-page">
    <div class="container contact-layout">
        <div class="contact-main">
            <header class="contact-header">
                <p class="eyebrow">Kontakt</p>
                <h1>Fragen, Hinweise oder Interesse an der MMIG46?</h1>
                <p>
                    Nutzen Sie das Formular für Anfragen zum Verein, zu Reisen,
                    technischen Themen oder zur Mitgliedschaft.
                </p>
            </header>

            <form class="contact-form" method="post" action="/kontakt">
                <?= Security::csrfField() ?>

                <div class="contact-form__grid">
                    <label>
                        Name
                        <input name="name" required autocomplete="name">
                    </label>

                    <label>
                        E-Mail
                        <input name="email" type="email" required autocomplete="email">
                    </label>

                    <label class="span-2">
                        Nachricht
                        <textarea name="message" rows="7" required></textarea>
                    </label>

                    <label class="captcha-field">
                        Captcha: <?= Security::e($captchaQuestion) ?> =
                        <input name="captcha" type="number" required inputmode="numeric">
                    </label>
                </div>

                <div class="contact-form__actions">
                    <button class="button button--primary" type="submit">Senden</button>
                    <p>Ihre Anfrage wird gespeichert und per E-Mail weitergeleitet.</p>
                </div>
            </form>
        </div>

        <aside class="contact-aside">
            <h2>Kontaktbereiche</h2>

            <ul>
                <li>Mitgliedschaft und Vereinsfragen</li>
                <li>Fly-Ins, Reisen und Veranstaltungen</li>
                <li>Forum, Login und Mitgliederbereich</li>
                <li>Technische Hinweise zur PA46</li>
            </ul>
        </aside>
    </div>
</section>