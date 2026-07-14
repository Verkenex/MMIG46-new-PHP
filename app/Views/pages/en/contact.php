<?php

use MMIG46\Core\I18n;
use MMIG46\Core\Security;

$captchaQuestion = $captchaQuestion ?? '';

?>

<section class="contact-page">
    <div class="container contact-layout">
        <div class="contact-main">
            <header class="contact-header">
                <p class="eyebrow">Contact</p>

                <h1>Questions, information or interest in MMIG46?</h1>

                <p>
                    Use this form for enquiries about the club, fly-ins,
                    technical topics or membership.
                </p>
            </header>

            <form
                class="contact-form"
                method="post"
                action="<?= Security::e(I18n::url('/kontakt')) ?>"
            >
                <?= Security::csrfField() ?>

                <div class="contact-form__grid">
                    <label>
                        Name

                        <input
                            name="name"
                            required
                            autocomplete="name"
                        >
                    </label>

                    <label>
                        Email

                        <input
                            name="email"
                            type="email"
                            required
                            autocomplete="email"
                        >
                    </label>

                    <label class="span-2">
                        Message

                        <textarea
                            name="message"
                            rows="7"
                            required
                        ></textarea>
                    </label>

                    <label class="captcha-field">
                        Security question:
                        <?= Security::e($captchaQuestion) ?> =

                        <input
                            name="captcha"
                            type="number"
                            required
                            inputmode="numeric"
                        >
                    </label>
                </div>

                <div class="contact-form__actions">
                    <button
                        class="button button--primary"
                        type="submit"
                    >
                        Send message
                    </button>

                    <p>
                        Your enquiry will be stored and forwarded by email.
                    </p>
                </div>
            </form>
        </div>

        <aside class="contact-aside">
            <h2>Contact topics</h2>

            <ul>
                <li>Membership and club enquiries</li>
                <li>Fly-ins, trips and events</li>
                <li>Forum, login and member area</li>
                <li>Technical information about the PA46</li>
            </ul>
        </aside>
    </div>
</section>