<?php

use MMIG46\Core\I18n;
use MMIG46\Core\Security;

?>

<section class="verein-hero">
    <div class="container">
        <div class="verein-layout">
            <div class="verein-main">
                <p class="eyebrow">MMIG46 e.V.</p>

                <h1>Malibu Mirage Interest Group PA46 Europe</h1>

                <p class="lead">
                    MMIG46 is the European interest group for owners,
                    operators and pilots of the Piper PA-46 family.
                    The association connects people who operate,
                    maintain and fly these aircraft in real-world
                    European conditions.
                </p>

                <div class="verein-card-stack">
                    <article class="verein-info-card">
                        <h2>Founded for PA-46 owners and pilots</h2>

                        <p>
                            MMIG46 was founded in 1999 to provide
                            owners, operators and pilots of the
                            Piper PA-46 in Europe with their own
                            platform for exchange, experience,
                            safety and joint aviation activities.
                        </p>
                    </article>

                    <article class="verein-info-card">
                        <h2>More than an aircraft type club</h2>

                        <p>
                            The focus is on practical operating
                            experience, technical exchange,
                            maintenance topics, safety training,
                            travel planning and personal contact
                            within the PA-46 community.
                        </p>
                    </article>
                </div>
            </div>

            <aside
                class="verein-side"
                aria-label="Quick links"
            >
                <a
                    class="verein-action-card"
                    href="<?= Security::e(
                        I18n::url('/mitgliedsantrag', 'en')
                    ) ?>"
                >
                    <span>
                        <strong>Become a member</strong>

                        <small>
                            Submit your membership application
                        </small>
                    </span>

                    <span aria-hidden="true">→</span>
                </a>

                <a
                    class="verein-action-card"
                    href="<?= Security::e(
                        I18n::url('/kontakt', 'en')
                    ) ?>"
                >
                    <span>
                        <strong>Contact MMIG46</strong>

                        <small>
                            Send a message to the association
                        </small>
                    </span>

                    <span aria-hidden="true">→</span>
                </a>

                <a
                    class="verein-action-card"
                    href="<?= Security::e(
                        I18n::url('/forum', 'en')
                    ) ?>"
                >
                    <span>
                        <strong>Forum</strong>

                        <small>
                            Exchange with the community
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
                <p class="eyebrow">Purpose</p>

                <h2>Exchange and shared experience</h2>

                <p>
                    The association’s purpose is to promote exchange
                    between PA-46 owners, operators and pilots.
                    Members benefit from practical experience that
                    cannot be found in brochures or manuals alone.
                </p>

                <p>
                    Topics include aircraft operation, route planning,
                    maintenance experience, avionics, engine
                    management, pressurisation, de-icing, training
                    and safe long-distance IFR operations.
                </p>
            </article>

            <article class="card">
                <p class="eyebrow">Community</p>

                <h2>Flying together</h2>

                <p>
                    MMIG46 organises fly-ins, trips and meetings where
                    members can meet in person, exchange experience
                    and strengthen the European PA-46 network.
                </p>

                <p>
                    The best way to bring the PA-46 community together
                    is to fly together: safely, professionally and
                    with a strong focus on shared operational
                    knowledge.
                </p>
            </article>

            <article class="card">
                <p class="eyebrow">Membership</p>

                <h2>Why become a member?</h2>

                <p>
                    Membership is aimed at owners, operators, pilots
                    and people with a serious interest in the
                    Piper PA-46 family. Active and passive support
                    both help the association grow.
                </p>

                <ul class="clean-list">
                    <li>
                        Exchange of practical PA-46 operating
                        experience
                    </li>

                    <li>
                        Technical notes and maintenance experience
                    </li>

                    <li>
                        Annual fly-ins and joint travel activities
                    </li>

                    <li>
                        Safety training and courses
                    </li>

                    <li>
                        Member forum and European PA-46 network
                    </li>
                </ul>

                <a
                    class="button button--primary"
                    href="<?= Security::e(
                        I18n::url('/mitgliedsantrag', 'en')
                    ) ?>"
                >
                    Open membership application
                </a>
            </article>
        </div>
    </div>
</section>

<section
    class="section section--soft club-board-section"
    id="board"
>
    <div class="container">
        <header class="club-board-header">
            <p class="eyebrow">Organisation</p>

            <h2>The MMIG46 Board</h2>

            <p>
                The Board manages the association’s organisational
                and financial affairs.
            </p>
        </header>

        <div class="club-board-grid">
            <article class="club-board-card">
                <div class="club-board-card__top">
                    <p class="club-board-card__role">
                        President
                    </p>

                    <h3>Dr. med. Klaus Gerecht</h3>
                </div>

                <div class="club-board-card__body">
                    <p>
                        President of MMIG46 and principal contact for
                        the association’s strategic and organisational
                        direction.
                    </p>
                </div>
            </article>

            <article class="club-board-card">
                <div class="club-board-card__top">
                    <p class="club-board-card__role">
                        Board Member
                    </p>

                    <h3>Kurt Levy</h3>
                </div>

                <div class="club-board-card__body">
                    <p>
                        Member of the Board and jointly responsible with
                        the other Board members for the management and
                        representation of the association.
                    </p>
                </div>
            </article>

            <article class="club-board-card">
                <div class="club-board-card__top">
                    <p class="club-board-card__role">
                        Treasurer · Board Member
                    </p>

                    <h3>Helmuth F. Sontag</h3>
                </div>

                <div class="club-board-card__body">
                    <p>
                        Treasurer and member of the Board. Responsible
                        for the association’s financial affairs and the
                        proper administration of its funds.
                    </p>
                </div>
            </article>
        </div>

        <aside class="club-advisor">
            <div class="club-advisor__label">
                <span class="club-advisor__line" aria-hidden="true"></span>

                <p class="eyebrow">
                    Legal Advice
                </p>
            </div>

            <div class="club-advisor__content">
                <div class="club-advisor__heading">
                    <p class="club-advisor__role">
                        Legal Advisor · Founding Member
                    </p>

                    <h3>Birgit Hüffer</h3>
                </div>

                <p class="club-advisor__description">
                    Birgit Hüffer is a founding member of MMIG46 and supports
                    the association as Legal Advisor on legal and
                    association-related matters.
                </p>
            </div>
        </aside>

        <div class="club-board-contact">
            <div>
                <h3>Contact the Board</h3>

                <p>
                    Questions for the Board can be submitted through
                    the central MMIG46 contact form.
                </p>
            </div>

            <a
                class="button button--primary"
                href="<?= Security::e(
                    I18n::url('/kontakt', 'en')
                ) ?>"
            >
                Contact the Board
            </a>
        </div>
    </div>
</section>

<section
    class="section"
    id="statute"
>
    <div class="container">
        <article class="statute-preview">
            <div class="statute-preview__content">
                <p class="eyebrow">
                    Association document
                </p>

                <h2>MMIG46 Articles of Association</h2>

                <p>
                    The original German version of the Articles of
                    Association is available online.
                </p>

                <p class="statute-preview__note">
                    The document is reproduced in its original German
                    wording. Only its visual presentation has been
                    modernised.
                </p>
            </div>

            <div class="statute-preview__action">
                <a
                    class="button"
                    href="<?= Security::e(
                        I18n::url('/satzung', 'en')
                    ) ?>"
                >
                    View Articles of Association
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
                <h2>Interested in MMIG46?</h2>

                <p>
                    Contact us if you would like to learn more about
                    the association, membership or the European
                    PA-46 community.
                </p>
            </div>

            <a
                class="button button--primary"
                href="<?= Security::e(
                    I18n::url('/kontakt', 'en')
                ) ?>"
            >
                Contact us
            </a>
        </div>
    </div>
</section>