<?php use MMIG46\Core\Security; use MMIG46\Core\I18n; ?>
<section class="section"><div class="container content-card"><h1><?= $lang==='en'?'Set password':'Passwort festlegen' ?></h1>
<form method="post" action="<?= Security::e(I18n::url('/passwort-setzen',$lang)) ?>"><?= Security::csrfField() ?><input type="hidden" name="token" value="<?= Security::e($token) ?>">
<label><?= $lang==='en'?'New password (at least 12 characters)':'Neues Passwort (mindestens 12 Zeichen)' ?><input type="password" name="password" minlength="12" required autocomplete="new-password"></label>
<label><?= $lang==='en'?'Repeat password':'Passwort wiederholen' ?><input type="password" name="password_confirmation" minlength="12" required autocomplete="new-password"></label><button type="submit"><?= $lang==='en'?'Save password':'Passwort speichern' ?></button></form></div></section>
