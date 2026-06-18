<?php

use MMIG46\Core\Security;

$title = 'The Club';
?>

<section class="page-hero">
    <div class="container">
        <p class="eyebrow">MMIG46 e.V.</p>
        <h1>The Club</h1>
        <p>
            MMIG46 is the European interest and experience group for owners,
            pilots and friends of the Piper PA-46 family.
        </p>
    </div>
</section>

<section class="section">
    <div class="container prose">
        <h2>Purpose</h2>
        <p>
            MMIG46 promotes exchange between owners, pilots, technicians and
            aviation enthusiasts. The focus is on safe operation, technical
            experience, travel planning, recurrent learning and personal contact
            within the European PA-46 community.
        </p>

        <h2>Activities</h2>
        <p>
            Regular activities include fly-ins, technical presentations,
            operational briefings, safety discussions and exchange on
            maintenance, avionics, performance and European IFR travel.
        </p>

        <h2>Membership</h2>
        <p>
            Membership is open to owners, pilots and friends of the PA-46 family
            as well as people interested in the safe and informed operation of
            these aircraft.
        </p>

        <p>
            <a class="button" href="<?= Security::e(\MMIG46\Core\I18n::url('/mitgliedsantrag')) ?>">
                Membership application
            </a>
        </p>
    </div>
</section>