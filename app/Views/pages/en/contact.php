<?php

use MMIG46\Core\Security;

?>

<section class="page-hero">
    <div class="container">
        <p class="eyebrow">Contact</p>
        <h1>Contact MMIG46</h1>
        <p>
            Send us your message. We will respond as soon as possible.
        </p>
    </div>
</section>

<section class="section">
    <div class="container narrow">
        <form method="post" action="/kontakt?lang=en" class="card form-card">
            <input type="hidden" name="_csrf" value="<?= Security::csrf() ?>">

            <label>
                Name
                <input type="text" name="name" required>
            </label>

            <label>
                Email
                <input type="email" name="email" required>
            </label>

            <label>
                Message
                <textarea name="message" rows="7" required></textarea>
            </label>

            <label>
                Security question: <?= Security::e($captchaQuestion ?? '') ?>
                <input type="number" name="captcha" required>
            </label>

            <button type="submit" class="btn primary">Send message</button>
        </form>
    </div>
</section>