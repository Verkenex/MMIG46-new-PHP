<?php

use MMIG46\Core\I18n;
use MMIG46\Core\Security;

?>

<section class="verein-hero">
    <div class="container">
        <div class="verein-layout">
            <div class="verein-main">
                <p class="eyebrow">MMIG46 e.V.</p>

                <h1>
                    Malibu Mirage Interessengemeinschaft PA46 Europa
                </h1>

                <p class="lead">
                    Die MMIG46 ist die europäische
                    Interessengemeinschaft für Eigentümer, Halter und
                    Piloten der Piper-PA-46-Familie. Der Verein
                    verbindet Menschen, die diese Flugzeuge unter
                    realen europäischen Bedingungen betreiben,
                    warten und fliegen.
                </p>

                <div class="verein-card-stack">
                    <article class="verein-info-card">
                        <h2>
                            Gegründet für Eigentümer und Piloten der PA-46
                        </h2>

                        <p>
                            Die MMIG46 wurde 1999 gegründet, um
                            Eigentümern, Haltern und Piloten der
                            Piper PA-46 in Europa eine eigene Plattform
                            für Austausch, Erfahrung, Sicherheit und
                            gemeinsame fliegerische Aktivitäten zu
                            bieten.
                        </p>
                    </article>

                    <article class="verein-info-card">
                        <h2>
                            Mehr als ein klassischer Flugzeugtypenverein
                        </h2>

                        <p>
                            Im Mittelpunkt stehen praktische
                            Betriebserfahrungen, technischer Austausch,
                            Wartungsthemen, Sicherheitstrainings,
                            Reiseplanung und der persönliche Kontakt
                            innerhalb der europäischen PA-46-Community.
                        </p>
                    </article>
                </div>
            </div>

            <aside
                class="verein-side"
                aria-label="Schnellzugriffe"
            >
                <a
                    class="verein-action-card"
                    href="<?= Security::e(
                        I18n::url('/mitgliedsantrag', 'de')
                    ) ?>"
                >
                    <span>
                        <strong>Mitglied werden</strong>

                        <small>
                            Mitgliedsantrag online einreichen
                        </small>
                    </span>

                    <span aria-hidden="true">→</span>
                </a>

                <a
                    class="verein-action-card"
                    href="<?= Security::e(
                        I18n::url('/kontakt', 'de')
                    ) ?>"
                >
                    <span>
                        <strong>MMIG46 kontaktieren</strong>

                        <small>
                            Nachricht an den Verein senden
                        </small>
                    </span>

                    <span aria-hidden="true">→</span>
                </a>

                <a
                    class="verein-action-card"
                    href="<?= Security::e(
                        I18n::url('/forum', 'de')
                    ) ?>"
                >
                    <span>
                        <strong>Forum</strong>

                        <small>
                            Austausch mit der Community
                        </small>
                    </span>

                    <span aria-hidden="true">→</span>
                </a>
            </aside>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="verein-section-grid">
            <article class="card">
                <p class="eyebrow">Vereinszweck</p>

                <h2>Austausch und gemeinsame Erfahrung</h2>

                <p>
                    Der Verein fördert den Austausch zwischen
                    PA-46-Eigentümern, Haltern und Piloten. Die
                    Mitglieder profitieren von praktischen Erfahrungen,
                    die sich nicht allein aus Prospekten oder
                    Handbüchern gewinnen lassen.
                </p>

                <p>
                    Zu den Themen gehören Betrieb und Flugplanung,
                    Wartungserfahrungen, Avionik, Motormanagement,
                    Druckkabine, Enteisung, Training und sichere
                    IFR-Langstreckenflüge.
                </p>
            </article>

            <article class="card">
                <p class="eyebrow">Gemeinschaft</p>

                <h2>Gemeinsam fliegen</h2>

                <p>
                    Die MMIG46 organisiert Fly-ins, Reisen und Treffen,
                    bei denen sich die Mitglieder persönlich
                    kennenlernen, Erfahrungen austauschen und das
                    europäische PA-46-Netzwerk stärken können.
                </p>

                <p>
                    Der beste Weg, die PA-46-Community
                    zusammenzubringen, ist das gemeinsame Fliegen:
                    sicher, professionell und mit einem klaren Fokus
                    auf geteiltes betriebliches Wissen.
                </p>
            </article>

            <article class="card">
                <p class="eyebrow">Mitgliedschaft</p>

                <h2>Warum Mitglied werden?</h2>

                <p>
                    Die Mitgliedschaft richtet sich an Eigentümer,
                    Halter, Piloten und Menschen mit ernsthaftem
                    Interesse an der Piper-PA-46-Familie. Sowohl aktive
                    als auch passive Unterstützung hilft dem Verein,
                    weiter zu wachsen.
                </p>

                <ul class="clean-list">
                    <li>
                        Austausch praktischer PA-46-Betriebserfahrungen
                    </li>

                    <li>
                        Technische Hinweise und Wartungserfahrungen
                    </li>

                    <li>
                        Jährliche Fly-ins und gemeinsame Reisen
                    </li>

                    <li>
                        Sicherheitstrainings und Lehrgänge
                    </li>

                    <li>
                        Mitgliederforum und europäisches
                        PA-46-Netzwerk
                    </li>
                </ul>

                <a
                    class="button button--primary"
                    href="<?= Security::e(
                        I18n::url('/mitgliedsantrag', 'de')
                    ) ?>"
                >
                    Mitgliedsantrag öffnen
                </a>
            </article>
        </div>
    </div>
</section>

<section
    class="section section--soft club-board-section"
    id="vorstand"
>
    <div class="container">
        <header class="club-board-header">
            <p class="eyebrow">Organisation</p>

            <h2>Der Vorstand der MMIG46</h2>

            <p>
                Der Vorstand führt die laufenden Geschäfte des Vereins
                und koordiniert die organisatorischen, finanziellen und
                rechtlichen Angelegenheiten der MMIG46.
            </p>
        </header>

        <div class="club-board-grid">
            <article class="club-board-card">
                <div class="club-board-card__top">
                    <p class="club-board-card__role">
                        Präsident
                    </p>

                    <h3>Dr. med. Klaus Gerecht</h3>
                </div>

                <div class="club-board-card__body">
                    <p>
                        Präsident der MMIG46 und zentraler
                        Ansprechpartner für die strategische und
                        organisatorische Ausrichtung des Vereins.
                    </p>
                </div>
            </article>

            <article class="club-board-card">
                <div class="club-board-card__top">
                    <p class="club-board-card__role">
                        Schatzmeister
                    </p>

                    <h3>Helmuth F. Sontag</h3>
                </div>

                <div class="club-board-card__body">
                    <p>
                        Verantwortlich für die finanziellen
                        Angelegenheiten und die ordnungsgemäße
                        Verwaltung der Vereinsmittel.
                    </p>
                </div>
            </article>

            <article class="club-board-card">
                <div class="club-board-card__top">
                    <p class="club-board-card__role">
                        Stellvertretende Präsidentin · Legal Advisor
                    </p>

                    <h3>Birgit Hüffer</h3>
                </div>

                <div class="club-board-card__body">
                    <p>
                        Stellvertretende Präsidentin und
                        Ansprechpartnerin des Vorstands für rechtliche
                        und vereinsorganisatorische Fragestellungen.
                    </p>
                </div>
            </article>
        </div>

        <div class="club-board-contact">
            <div>
                <h3>Kontakt zum Vorstand</h3>

                <p>
                    Fragen an den Vorstand können über das zentrale
                    Kontaktformular an die MMIG46 gerichtet werden.
                </p>
            </div>

            <a
                class="button button--primary"
                href="<?= Security::e(
                    I18n::url('/kontakt', 'de')
                ) ?>"
            >
                Vorstand kontaktieren
            </a>
        </div>
    </div>
</section>

<section
    class="section"
    id="satzung"
>
    <div class="container">
        <article class="statute-preview">
            <div class="statute-preview__content">
                <p class="eyebrow">
                    Vereinsdokument
                </p>

                <h2>Die Satzung der MMIG46</h2>

                <p>
                    Die deutsche Originalfassung der Satzung kann
                    vollständig online eingesehen werden.
                </p>

                <p class="statute-preview__note">
                    Der Wortlaut wurde unverändert übernommen.
                    Ausschließlich die grafische Darstellung wurde
                    modernisiert.
                </p>
            </div>

            <div class="statute-preview__action">
                <a
                    class="button"
                    href="<?= Security::e(
                        I18n::url('/satzung', 'de')
                    ) ?>"
                >
                    Satzung ansehen
                </a>
            </div>
        </article>
    </div>
</section>

<section class="section section--compact">
    <div class="container">
        <div class="contact-cta">
            <div
                class="contact-cta__icon"
                aria-hidden="true"
            >
                ✈
            </div>

            <div>
                <h2>Interesse an der MMIG46?</h2>

                <p>
                    Kontaktieren Sie uns, wenn Sie mehr über den Verein,
                    die Mitgliedschaft oder die europäische
                    PA-46-Community erfahren möchten.
                </p>
            </div>

            <a
                class="button button--primary"
                href="<?= Security::e(
                    I18n::url('/kontakt', 'de')
                ) ?>"
            >
                Kontakt aufnehmen
            </a>
        </div>
    </div>
</section>