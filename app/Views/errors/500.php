<?php $errorLang = \MMIG46\Core\I18n::current(); ?>
<section class="page"><h1>500</h1><p><?= MMIG46\Core\Security::e($message ?? ($errorLang === 'en' ? 'Internal error' : 'Interner Fehler')) ?></p></section>
