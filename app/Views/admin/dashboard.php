<?php

use MMIG46\Core\I18n;
use MMIG46\Core\Security;

$lang = I18n::current();
$isEn = $lang === 'en';

$copy = [
    'de' => [
        // Kopfbereich
        'eyebrow' => 'Verwaltung',
        'title' => 'Administration der MMIG46-Plattform',
        'intro' => 'Nutzerkonten, Mitgliederliste, Beiträge und Reisen zentral pflegen.',
        'view_website' => 'Website ansehen',
        'review_news' => 'News prüfen',
        'review_travels' => 'Reisen prüfen',

        // Allgemeine Begriffe
        'name' => 'Name',
        'email' => 'E-Mail',
        'password' => 'Passwort',
        'role' => 'Rolle',
        'aircraft' => 'Flugzeug',
        'base' => 'Heimatflugplatz',
        'membership' => 'Mitgliedschaft',
        'website' => 'Website',
        'invoice_name' => 'Rechnungsempfänger',
        'street' => 'Straße und Hausnummer',
        'postal_code' => 'PLZ',
        'city' => 'Ort',
        'country' => 'Land',
        'phone' => 'Telefon',
        'internal_notes' => 'Interne Notizen',
        'edit' => 'Bearbeiten',
        'save_changes' => 'Änderungen speichern',
        'sort_order' => 'Sortierung',
        'language' => 'Sprache',
        'german' => 'Deutsch',
        'english' => 'Englisch',
        'slug' => 'Slug',
        'title_field' => 'Titel',
        'category' => 'Kategorie',
        'image_path' => 'Bildpfad',
        'teaser' => 'Teaser',
        'content' => 'Inhalt',
        'date' => 'Datum',
        'status' => 'Status',
        'public' => 'Öffentlich',
        'yes' => 'Ja',
        'no' => 'Nein',
        'online' => 'online',
        'offline' => 'offline',

        // Account
        'account_title' => 'Account anlegen',
        'account_intro' => 'Neuen Nutzer mit Rolle erstellen.',
        'account_save' => 'Account speichern',

        // Mitglied
        'member_title' => 'Mitglied eintragen',
        'member_intro' => 'Öffentliches Mitgliedsprofil pflegen.',
        'member_role_placeholder' => 'Pilot, Eigentümer, Vorstand',
        'membership_placeholder' => 'Mitglied, Vorstand, Ehrenmitglied',
        'show_publicly' => 'Öffentlich anzeigen',
        'member_save' => 'Mitglied speichern',

        // News
        'news_title' => 'Beiträge verwalten',
        'news_intro' => 'News anlegen oder über einen bestehenden Slug aktualisieren.',
        'article_text' => 'Artikeltext / Markdown',
        'publication_date' => 'Veröffentlichungsdatum',
        'published' => 'Veröffentlicht',
        'news_save' => 'Beitrag speichern',
        'existing_news' => 'Bestehende Beiträge',

        // Reisen
        'travel_title' => 'Reise bearbeiten',
        'travel_intro' => 'Reisen per Slug neu anlegen oder aktualisieren.',
        'location' => 'Ort',
        'start_date' => 'Startdatum',
        'end_date' => 'Enddatum',
        'cta_label' => 'CTA-Beschriftung',
        'legacy_pdf_url' => 'Legacy-PDF-URL',
        'legacy_pdf_path' => 'Legacy-PDF-Pfad',
        'travel_save' => 'Reise speichern',
        'planned' => 'Geplant',
        'completed' => 'Abgeschlossen',
        'archived' => 'Archiviert',

        // Tabellen
        'users_title' => 'Nutzer',
        'users_intro' => 'Bestehende Logins und Rollen.',
        'members_title' => 'Mitglieder',
        'members_intro' => 'Öffentliche und interne Mitgliederprofile.',
    ],

    'en' => [
        // Header
        'eyebrow' => 'Administration',
        'title' => 'MMIG46 Platform Administration',
        'intro' => 'Manage user accounts, the member directory, articles and trips.',
        'view_website' => 'View website',
        'review_news' => 'Review news',
        'review_travels' => 'Review trips',

        // General terms
        'name' => 'Name',
        'email' => 'Email address',
        'password' => 'Password',
        'role' => 'Role',
        'aircraft' => 'Aircraft',
        'base' => 'Home base',
        'membership' => 'Membership type',
        'website' => 'Website',
        'invoice_name' => 'Invoice recipient',
        'street' => 'Street and number',
        'postal_code' => 'Postal code',
        'city' => 'City',
        'country' => 'Country',
        'phone' => 'Phone',
        'internal_notes' => 'Internal notes',
        'edit' => 'Edit',
        'save_changes' => 'Save changes',
        'sort_order' => 'Sort order',
        'language' => 'Language',
        'german' => 'German',
        'english' => 'English',
        'slug' => 'Slug',
        'title_field' => 'Title',
        'category' => 'Category',
        'image_path' => 'Image path',
        'teaser' => 'Teaser',
        'content' => 'Content',
        'date' => 'Date',
        'status' => 'Status',
        'public' => 'Public',
        'yes' => 'Yes',
        'no' => 'No',
        'online' => 'online',
        'offline' => 'offline',

        // Account
        'account_title' => 'Create account',
        'account_intro' => 'Create a new user and assign a role.',
        'account_save' => 'Save account',

        // Member
        'member_title' => 'Add member',
        'member_intro' => 'Create or maintain a public member profile.',
        'member_role_placeholder' => 'Pilot, owner, board member',
        'membership_placeholder' => 'Member, board member, honorary member',
        'show_publicly' => 'Display publicly',
        'member_save' => 'Save member',

        // News
        'news_title' => 'Manage articles',
        'news_intro' => 'Create news articles or update an existing article by slug.',
        'article_text' => 'Article text / Markdown',
        'publication_date' => 'Publication date',
        'published' => 'Published',
        'news_save' => 'Save article',
        'existing_news' => 'Existing articles',

        // Trips
        'travel_title' => 'Edit trip',
        'travel_intro' => 'Create a new trip or update an existing trip by slug.',
        'location' => 'Location',
        'start_date' => 'Start date',
        'end_date' => 'End date',
        'cta_label' => 'CTA label',
        'legacy_pdf_url' => 'Legacy PDF URL',
        'legacy_pdf_path' => 'Legacy PDF path',
        'travel_save' => 'Save trip',
        'planned' => 'Planned',
        'completed' => 'Completed',
        'archived' => 'Archived',

        // Tables
        'users_title' => 'Users',
        'users_intro' => 'Existing login accounts and roles.',
        'members_title' => 'Members',
        'members_intro' => 'Public and internal member profiles.',
    ],
];

$t = $copy[$isEn ? 'en' : 'de'];
?>

<section class="page admin-shell">

    <div class="admin-hero">
        <div>
            <p class="eyebrow">
                <?= Security::e($t['eyebrow']) ?>
            </p>

            <h1>
                <?= Security::e($t['title']) ?>
            </h1>

            <p>
                <?= Security::e($t['intro']) ?>
            </p>
        </div>

        <div class="admin-hero-actions">
            <a
                class="button ghost"
                href="<?= Security::e(I18n::url('/')) ?>"
            >
                <?= Security::e($t['view_website']) ?>
            </a>

            <a
                class="button ghost"
                href="<?= Security::e(I18n::url('/news')) ?>"
            >
                <?= Security::e($t['review_news']) ?>
            </a>

            <a
                class="button ghost"
                href="<?= Security::e(I18n::url('/reisen')) ?>"
            >
                <?= Security::e($t['review_travels']) ?>
            </a>
            <a class="button ghost" href="<?= Security::e(I18n::url('/verwaltung/rechnungen')) ?>"><?= $isEn ? 'Invoices' : 'Rechnungen' ?></a>
        </div>
    </div>

    <section class="admin-card-grid">

        <!-- Account anlegen -->
        <article class="admin-card">
            <div class="admin-card-header">
                <span class="admin-icon" aria-hidden="true">👤</span>

                <div>
                    <h2><?= Security::e($t['account_title']) ?></h2>
                    <p><?= Security::e($t['account_intro']) ?></p>
                </div>
            </div>

            <form
                method="post"
                action="<?= Security::e(I18n::url('/verwaltung/users')) ?>"
            >
                <?= Security::csrfField() ?>

                <label>
                    <?= Security::e($t['name']) ?>

                    <input
                        type="text"
                        name="name"
                        required
                        maxlength="120"
                    >
                </label>

                <label>
                    <?= Security::e($t['email']) ?>

                    <input
                        type="email"
                        name="email"
                        required
                        maxlength="190"
                        autocomplete="email"
                    >
                </label>

                <label>
                    <?= Security::e($t['password']) ?>

                    <input
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                    >
                </label>

                <label>
                    <?= Security::e($t['role']) ?>

                    <select name="role">
                        <option value="member">member</option>
                        <option value="moderator">moderator</option>
                        <option value="admin">admin</option>
                    </select>
                </label>

                <button class="primary" type="submit">
                    <?= Security::e($t['account_save']) ?>
                </button>
            </form>
        </article>

        <!-- Mitglied eintragen -->
        <article class="admin-card">
            <div class="admin-card-header">
                <span class="admin-icon" aria-hidden="true">✈</span>

                <div>
                    <h2><?= Security::e($t['member_title']) ?></h2>
                    <p><?= Security::e($t['member_intro']) ?></p>
                </div>
            </div>

            <form
                method="post"
                action="<?= Security::e(I18n::url('/verwaltung/members')) ?>"
            >
                <?= Security::csrfField() ?>

                <label>
                    <?= Security::e($t['name']) ?>

                    <input
                        type="text"
                        name="name"
                        required
                        maxlength="120"
                    >
                </label>

                <label>
                    <?= Security::e($t['email']) ?>

                    <input
                        type="email"
                        name="email"
                        maxlength="190"
                    >
                </label>

                <label>
                    <?= Security::e($t['aircraft']) ?>

                    <input
                        type="text"
                        name="aircraft"
                        placeholder="PA46-310P"
                    >
                </label>

                <label>
                    <?= Security::e($t['base']) ?>

                    <input
                        type="text"
                        name="base"
                        placeholder="EDFE"
                    >
                </label>

                <label>
                    <?= Security::e($t['role']) ?>

                    <input
                        type="text"
                        name="role_label"
                        placeholder="<?= Security::e($t['member_role_placeholder']) ?>"
                    >
                </label>

                <label>
                    <?= Security::e($t['membership']) ?>

                    <input
                        type="text"
                        name="member_type"
                        placeholder="<?= Security::e($t['membership_placeholder']) ?>"
                    >
                </label>

                <label>
                    <?= Security::e($t['website']) ?>

                    <input
                        type="url"
                        name="website"
                        placeholder="https://..."
                    >
                </label>

                <label><?= Security::e($t['invoice_name']) ?><input type="text" name="invoice_name" maxlength="255"></label>
                <label><?= Security::e($t['street']) ?><input type="text" name="street" maxlength="255"></label>
                <label><?= Security::e($t['postal_code']) ?><input type="text" name="postal_code" maxlength="20"></label>
                <label><?= Security::e($t['city']) ?><input type="text" name="city" maxlength="150"></label>
                <label><?= Security::e($t['country']) ?><input type="text" name="country" maxlength="100" value="Deutschland"></label>
                <label><?= Security::e($t['phone']) ?><input type="tel" name="phone" maxlength="100"></label>
                <label><?= Security::e($t['internal_notes']) ?><textarea name="internal_notes" rows="3"></textarea></label>

                <label>
                    <?= Security::e($t['sort_order']) ?>

                    <input
                        type="number"
                        name="sort_order"
                        value="100"
                    >
                </label>

                <label class="checkbox-row">
                    <input
                        type="checkbox"
                        name="is_public"
                        value="1"
                    >

                    <span>
                        <?= Security::e($t['show_publicly']) ?>
                    </span>
                </label>
                <label class="checkbox-row"><input type="checkbox" name="public_consent_confirmed" value="1"><span>Gesonderte Einwilligung zur öffentlichen Anzeige liegt nachweisbar vor</span></label>

                <button class="primary" type="submit">
                    <?= Security::e($t['member_save']) ?>
                </button>
            </form>
        </article>

    </section>

    <!-- News -->
    <section class="admin-panel admin-card admin-card-wide">

        <div class="admin-card-header">
            <span class="admin-icon" aria-hidden="true">📰</span>

            <div>
                <h2><?= Security::e($t['news_title']) ?></h2>
                <p><?= Security::e($t['news_intro']) ?></p>
            </div>
        </div>

        <form
            method="post"
            action="<?= Security::e(I18n::url('/verwaltung/news')) ?>"
            class="admin-form"
        >
            <?= Security::csrfField() ?>

            <label>
                <?= Security::e($t['title_field']) ?>

                <input
                    type="text"
                    name="title"
                    required
                >
            </label>

            <label>
                <?= Security::e($t['language']) ?>

                <select name="lang">
                    <option value="de">
                        <?= Security::e($t['german']) ?>
                    </option>

                    <option value="en">
                        <?= Security::e($t['english']) ?>
                    </option>
                </select>
            </label>

            <label>
                <?= Security::e($t['slug']) ?>

                <input
                    type="text"
                    name="slug"
                    required
                    placeholder="fly-in-woerthersee-2026"
                >
            </label>

            <label>
                <?= Security::e($t['category']) ?>

                <input
                    type="text"
                    name="category"
                    placeholder="<?= $isEn
                        ? 'Club, trips, news'
                        : 'Verein, Reisen, Aktuelles' ?>"
                >
            </label>

            <label>
                <?= Security::e($t['image_path']) ?>

                <input
                    type="text"
                    name="image_path"
                    placeholder="/assets/img/news-meeting.jpg"
                >
            </label>

            <label>
                <?= Security::e($t['teaser']) ?>

                <textarea name="teaser"></textarea>
            </label>

            <label>
                <?= Security::e($t['article_text']) ?>

                <textarea
                    name="body"
                    rows="10"
                    required
                ></textarea>
            </label>

            <label>
                <?= Security::e($t['publication_date']) ?>

                <input
                    type="text"
                    name="published_at"
                    placeholder="2026-06-15 12:00:00"
                >
            </label>

            <label class="checkbox-row">
                <input
                    type="checkbox"
                    name="is_published"
                    value="1"
                    checked
                >

                <span>
                    <?= Security::e($t['published']) ?>
                </span>
            </label>

            <button class="primary" type="submit">
                <?= Security::e($t['news_save']) ?>
            </button>
        </form>

        <h3><?= Security::e($t['existing_news']) ?></h3>

        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th><?= Security::e($t['title_field']) ?></th>
                        <th><?= Security::e($t['slug']) ?></th>
                        <th><?= Security::e($t['date']) ?></th>
                        <th><?= Security::e($t['status']) ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach (($news ?? []) as $item): ?>
                        <tr>
                            <td>
                                <?= Security::e((string)($item['title'] ?? '')) ?>
                            </td>

                            <td>
                                <code>
                                    <?= Security::e((string)($item['slug'] ?? '')) ?>
                                </code>
                            </td>

                            <td>
                                <?= Security::e((string)($item['published_at'] ?? '')) ?>
                            </td>

                            <td>
                                <?php $isPublished = !empty($item['is_published']); ?>

                                <span class="status-badge <?= $isPublished
                                    ? 'is-online'
                                    : 'is-offline' ?>"
                                >
                                    <?= Security::e(
                                        $isPublished
                                            ? $t['online']
                                            : $t['offline']
                                    ) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Reisen -->
    <section class="admin-card admin-card-wide">

        <div class="admin-card-header">
            <span class="admin-icon" aria-hidden="true">🧭</span>

            <div>
                <h2><?= Security::e($t['travel_title']) ?></h2>
                <p><?= Security::e($t['travel_intro']) ?></p>
            </div>
        </div>

        <form
            method="post"
            action="<?= Security::e(I18n::url('/verwaltung/travels')) ?>"
        >
            <?= Security::csrfField() ?>

            <label>
                <?= Security::e($t['slug']) ?>

                <input
                    type="text"
                    name="slug"
                    placeholder="fly-in-woerthersee-2026"
                    required
                >
            </label>

            <label>
                <?= Security::e($t['title_field']) ?>

                <input
                    type="text"
                    name="title"
                    required
                >
            </label>

            <label>
                <?= Security::e($t['language']) ?>

                <select name="lang">
                    <option value="de">
                        <?= Security::e($t['german']) ?>
                    </option>

                    <option value="en">
                        <?= Security::e($t['english']) ?>
                    </option>
                </select>
            </label>

            <label>
                <?= Security::e($t['image_path']) ?>

                <input
                    type="text"
                    name="image_path"
                    placeholder="/assets/img/woerthersee.jpg"
                >
            </label>

            <label>
                <?= Security::e($t['location']) ?>

                <input
                    type="text"
                    name="location"
                    placeholder="Wörthersee"
                >
            </label>

            <label>
                <?= Security::e($t['start_date']) ?>

                <input
                    type="date"
                    name="starts_on"
                >
            </label>

            <label>
                <?= Security::e($t['end_date']) ?>

                <input
                    type="date"
                    name="ends_on"
                >
            </label>

            <label>
                <?= Security::e($t['status']) ?>

                <select name="status">
                    <option value="planned">
                        <?= Security::e($t['planned']) ?>
                    </option>

                    <option value="completed">
                        <?= Security::e($t['completed']) ?>
                    </option>

                    <option value="archived">
                        <?= Security::e($t['archived']) ?>
                    </option>
                </select>
            </label>

            <label>
                <?= Security::e($t['teaser']) ?>

                <input
                    type="text"
                    name="teaser"
                >
            </label>

            <label>
                <?= Security::e($t['cta_label']) ?>

                <input
                    type="text"
                    name="cta_label"
                    placeholder="<?= $isEn
                        ? 'View details'
                        : 'Details ansehen' ?>"
                >
            </label>

            <label>
                <?= Security::e($t['legacy_pdf_url']) ?>

                <input
                    type="url"
                    name="legacy_pdf_url"
                    placeholder="https://www.mmig46.de/path/to/document.pdf"
                >
            </label>

            <label>
                <?= Security::e($t['legacy_pdf_path']) ?>

                <input
                    type="text"
                    name="legacy_pdf_path"
                    placeholder="/assets/docs/document.pdf"
                >
            </label>

            <label>
                <?= Security::e($t['content']) ?>

                <textarea
                    name="body"
                    rows="8"
                ></textarea>
            </label>

            <label class="checkbox-row">
                <input
                    type="checkbox"
                    name="is_published"
                    value="1"
                    checked
                >

                <span>
                    <?= Security::e($t['show_publicly']) ?>
                </span>
            </label>

            <button class="primary" type="submit">
                <?= Security::e($t['travel_save']) ?>
            </button>
        </form>
    </section>

    <!-- Mitgliedsanträge: ausschließlich administrativ, bewusst ohne öffentliche Ausgabe. -->
    <section class="admin-card admin-card-wide">
        <div class="admin-card-header"><span class="admin-icon" aria-hidden="true">📥</span><div><h2>Mitgliedsanträge</h2><p>Pending-Datensatz, Konflikte, Freigaben und Versandstatus.</p></div></div>
        <?php foreach (($applications ?? []) as $application): ?>
            <details class="content-card"><summary>#<?= (int)$application['id'] ?> · <?= Security::e((string)$application['first_name'].' '.(string)$application['last_name']) ?> · <?= Security::e((string)$application['status']) ?></summary>
                <p><strong>E-Mail:</strong> <?= Security::e((string)$application['private_email']) ?> · <strong>Mitglied:</strong> #<?= (int)($application['member_id'] ?? 0) ?> (<?= Security::e((string)($application['member_status'] ?? 'fehlt')) ?>)</p>
                <?php if (!empty($application['conflict_reason'])): ?><p class="flash error"><?= Security::e((string)$application['conflict_reason']) ?></p><?php endif; ?>
                <p><strong>Rechnung:</strong> <?= Security::e((string)$application['invoice_name']) ?>, <?= Security::e((string)$application['street']) ?>, <?= Security::e((string)$application['postal_city_country']) ?></p>
                <p><strong>Kontakt:</strong> <?= Security::e((string)$application['mobile']) ?> · <strong>Flugzeug:</strong> <?= Security::e((string)$application['model']) ?> <?= Security::e((string)$application['callsign']) ?></p>
                <p><strong>Vorstand:</strong> <?= Security::e((string)($application['board_confirmed_at'] ?? 'offen')) ?> <?= Security::e((string)($application['board_admin_name'] ?? '')) ?> · <strong>Zahlung:</strong> <?= Security::e((string)($application['payment_confirmed_at'] ?? 'offen')) ?> <?= Security::e((string)($application['payment_admin_name'] ?? '')) ?></p>
                <?php if (in_array($application['status'], ['pending','manual_review'], true)): ?>
                    <form method="post" action="<?= Security::e(I18n::url('/verwaltung/applications/'.(int)$application['id'].'/approve')) ?>" class="admin-form"><?= Security::csrfField() ?>
                        <label class="checkbox-row"><input type="checkbox" name="board_confirmed" value="1" required><span>Aufnahme durch den Vorstand ist erfolgt</span></label>
                        <label class="checkbox-row"><input type="checkbox" name="payment_confirmed" value="1" required><span>Erforderlicher Zahlungseingang ist erfolgt</span></label>
                        <label class="checkbox-row"><input type="checkbox" name="link_existing_user" value="1"><span>Bei identischer E-Mail ausdrücklich mit dem vorhandenen Benutzer verknüpfen (bestehende Mitgliedsverknüpfungen bleiben gesperrt)</span></label>
                        <button class="primary" type="submit">Freigeben und Passwort-Link erzeugen</button>
                    </form>
                    <form method="post" action="<?= Security::e(I18n::url('/verwaltung/applications/'.(int)$application['id'].'/reject')) ?>" class="admin-form"><?= Security::csrfField() ?><select name="decision"><option value="rejected">Ablehnen</option><option value="cancelled">Stornieren</option></select><label>Zur Bestätigung ABLEHNEN eingeben<input name="confirmation" required></label><button type="submit">Antrag abschließen</button></form>
                <?php endif; ?>
                <?php foreach (($applicationOutbox[(int)$application['id']] ?? []) as $message): ?><p>Mail <?= Security::e((string)$message['message_type']) ?> an <?= Security::e((string)$message['recipient']) ?>: <strong><?= Security::e((string)$message['status']) ?></strong> (<?= (int)$message['attempts'] ?> Versuche)
                    <?php if ($message['status'] !== 'sent'): ?><form class="inline" method="post" action="<?= Security::e(I18n::url('/verwaltung/outbox/'.(int)$message['id'].'/retry')) ?>"><?= Security::csrfField() ?><button type="submit">Erneut senden</button></form><?php endif; ?></p><?php endforeach; ?>
            </details>
        <?php endforeach; ?>
    </section>

    <!-- Kontaktanfragen -->
    <section class="admin-card admin-card-wide">
        <div class="admin-card-header"><span class="admin-icon" aria-hidden="true">✉</span><div><h2><?= $isEn ? 'Contact requests' : 'Kontaktanfragen' ?></h2><p><?= $isEn ? 'Stored requests; IP addresses are only stored as pseudonymous fingerprints.' : 'Gespeicherte Anfragen; IP-Adressen werden nur pseudonymisiert abgelegt.' ?></p></div></div>
        <div class="table"><table><thead><tr><th><?= $isEn ? 'Time' : 'Zeit' ?></th><th><?= Security::e($t['name']) ?></th><th><?= Security::e($t['email']) ?></th><th><?= $isEn ? 'Message' : 'Nachricht' ?></th><th><?= Security::e($t['status']) ?></th></tr></thead><tbody>
        <?php foreach (($contactRequests ?? []) as $request): ?><tr>
            <td><?= Security::e((string) $request['created_at']) ?></td><td><?= Security::e((string) $request['name']) ?></td>
            <td><a href="mailto:<?= Security::e((string) $request['email']) ?>"><?= Security::e((string) $request['email']) ?></a></td>
            <td><?= nl2br(Security::e((string) $request['message'])) ?></td><td><?= $request['handled_at'] ? ($isEn ? 'handled' : 'bearbeitet') : ($isEn ? 'open' : 'offen') ?>
            <?php if (!$request['handled_at']): ?><form method="post" action="<?= Security::e(I18n::url('/verwaltung/contact/' . (int) $request['id'] . '/handled')) ?>"><?= Security::csrfField() ?><button type="submit"><?= $isEn ? 'Mark as handled' : 'Als bearbeitet markieren' ?></button></form><?php endif; ?></td>
        </tr><?php endforeach; ?>
        </tbody></table></div>
    </section>

    <section class="admin-card admin-card-wide">
        <div class="admin-card-header"><span class="admin-icon" aria-hidden="true">📅</span><div><h2><?= $isEn ? 'Training weekend registrations' : 'Trainingswochenende-Anmeldungen' ?></h2><p><?= $isEn ? 'Persisted registrations and delivery status.' : 'Dauerhaft gespeicherte Anmeldungen und Versandstatus.' ?></p></div></div>
        <div class="table"><table><thead><tr><th><?= $isEn ? 'Time' : 'Zeit' ?></th><th><?= Security::e($t['name']) ?></th><th><?= Security::e($t['email']) ?></th><th><?= Security::e($t['aircraft']) ?></th><th><?= $isEn ? 'People' : 'Personen' ?></th><th><?= $isEn ? 'Programme items' : 'Programmpunkte' ?></th><th><?= $isEn ? 'Delivery' : 'Versand' ?></th></tr></thead><tbody>
        <?php foreach (($trainingRegistrations ?? []) as $registration): $elements = json_decode((string) $registration['elements_json'], true); ?><tr>
            <td><?= Security::e((string) $registration['created_at']) ?></td><td><?= Security::e((string) $registration['name']) ?></td>
            <td><?= Security::e((string) $registration['email']) ?></td><td><?= Security::e(trim((string) $registration['callsign'] . ' ' . (string) $registration['aircraft_model'])) ?></td>
            <td><?= (int) $registration['participants'] ?></td><td><?= Security::e(implode(', ', is_array($elements) ? $elements : [])) ?><?php if ($registration['notes']): ?><br><?= nl2br(Security::e((string) $registration['notes'])) ?><?php endif; ?></td>
            <td><?= $isEn ? 'Organiser' : 'Organisation' ?>: <?= Security::e((string) $registration['organizer_mail_status']) ?><br><?= $isEn ? 'Copy' : 'Kopie' ?>: <?= Security::e((string) $registration['copy_mail_status']) ?></td>
        </tr><?php endforeach; ?>
        </tbody></table></div>
    </section>

    <!-- Nutzerübersicht -->
    <section class="admin-card admin-card-wide">

        <div class="admin-card-header">
            <span class="admin-icon" aria-hidden="true">🔐</span>

            <div>
                <h2><?= Security::e($t['users_title']) ?></h2>
                <p><?= Security::e($t['users_intro']) ?></p>
            </div>
        </div>

        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th><?= Security::e($t['name']) ?></th>
                        <th><?= Security::e($t['email']) ?></th>
                        <th><?= Security::e($t['role']) ?></th><th>Verwalten</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach (($users ?? []) as $user): ?>
                        <tr>
                            <td>
                                <?= Security::e((string)($user['name'] ?? '')) ?>
                            </td>

                            <td>
                                <?= Security::e((string)($user['email'] ?? '')) ?>
                            </td>

                            <td>
                                <?= Security::e((string)($user['role'] ?? '')) ?>
                            </td>
                            <td><details><summary>Bearbeiten</summary>
                                <form method="post" action="<?= Security::e(I18n::url('/verwaltung/users/'.(int)$user['id'])) ?>" class="admin-form"><?= Security::csrfField() ?><label>Name<input name="name" required value="<?= Security::e((string)$user['name']) ?>"></label><label>E-Mail<input type="email" name="email" required value="<?= Security::e((string)$user['email']) ?>"></label><label>Rolle<select name="role"><?php foreach(['admin','moderator','member','guest'] as $role): ?><option value="<?= $role ?>" <?= $user['role']===$role?'selected':'' ?>><?= $role ?></option><?php endforeach; ?></select></label><button type="submit">Speichern</button></form>
                                <form method="post" action="<?= Security::e(I18n::url('/verwaltung/users/'.(int)$user['id'].'/reset')) ?>"><?= Security::csrfField() ?><button type="submit">Passwort-Reset-Link senden</button></form>
                                <p>Abhängigkeiten vor Löschung: <?= (int)$user['topic_count'] ?> Themen, <?= (int)$user['post_count'] ?> Beiträge, <?= (int)$user['member_count'] ?> Mitgliedsdatensätze.</p>
                                <?php foreach (($userOutbox[(int)$user['id']] ?? []) as $message): ?><p>Reset-Mail: <?= Security::e((string)$message['status']) ?> (<?= (int)$message['attempts'] ?> Versuche)<?php if($message['status']!=='sent'): ?> <form class="inline" method="post" action="<?= Security::e(I18n::url('/verwaltung/outbox/'.(int)$message['id'].'/retry')) ?>"><?= Security::csrfField() ?><button>Erneut senden</button></form><?php endif; ?></p><?php endforeach; ?>
                                <form method="post" action="<?= Security::e(I18n::url('/verwaltung/users/'.(int)$user['id'].'/delete')) ?>"><?= Security::csrfField() ?><label>Zum Löschen BENUTZER LÖSCHEN eingeben<input name="confirmation" required></label><button type="submit">Benutzer löschen</button></form>
                            </details></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Mitgliederübersicht -->
    <section class="admin-card admin-card-wide">

        <div class="admin-card-header">
            <span class="admin-icon" aria-hidden="true">🛩</span>

            <div>
                <h2><?= Security::e($t['members_title']) ?></h2>
                <p><?= Security::e($t['members_intro']) ?></p>
            </div>
        </div>

        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th><?= Security::e($t['name']) ?></th>
                        <th><?= Security::e($t['aircraft']) ?></th>
                        <th><?= Security::e($t['base']) ?></th>
                        <th><?= Security::e($t['role']) ?></th>
                        <th><?= Security::e($t['membership']) ?></th>
                        <th><?= Security::e($t['public']) ?></th>
                        <th><?= Security::e($t['edit']) ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach (($members ?? []) as $member): ?>
                        <tr>
                            <td>
                                <?= Security::e((string)($member['name'] ?? '')) ?>
                            </td>

                            <td>
                                <?= Security::e((string)($member['aircraft'] ?? '')) ?>
                            </td>

                            <td>
                                <?= Security::e((string)($member['base'] ?? '')) ?>
                            </td>

                            <td>
                                <?= Security::e((string)($member['role_label'] ?? '')) ?>
                            </td>

                            <td>
                                <?= Security::e((string)($member['member_type'] ?? '')) ?>
                            </td>

                            <td>
                                <?php $isPublic = !empty($member['is_public']); ?>

                                <span class="status-badge <?= $isPublic
                                    ? 'is-online'
                                    : 'is-offline' ?>"
                                >
                                    <?= Security::e(
                                        $isPublic
                                            ? $t['yes']
                                            : $t['no']
                                    ) ?>
                                </span>
                            </td>

                            <td>
                                <details>
                                    <summary><?= Security::e($t['edit']) ?></summary>
                                    <form method="post" action="<?= Security::e(I18n::url('/verwaltung/members/' . (int) $member['id'])) ?>" class="admin-form">
                                        <?= Security::csrfField() ?>
                                        <label><?= Security::e($t['name']) ?><input type="text" name="name" required maxlength="120" value="<?= Security::e((string) ($member['name'] ?? '')) ?>"></label>
                                        <label><?= Security::e($t['email']) ?><input type="email" name="email" maxlength="190" value="<?= Security::e((string) ($member['email'] ?? '')) ?>"></label>
                                        <label><?= Security::e($t['aircraft']) ?><input type="text" name="aircraft" maxlength="120" value="<?= Security::e((string) ($member['aircraft'] ?? '')) ?>"></label>
                                        <label><?= Security::e($t['base']) ?><input type="text" name="base" maxlength="120" value="<?= Security::e((string) ($member['base'] ?? '')) ?>"></label>
                                        <label><?= Security::e($t['role']) ?><input type="text" name="role_label" maxlength="120" value="<?= Security::e((string) ($member['role_label'] ?? '')) ?>"></label>
                                        <label><?= Security::e($t['membership']) ?><input type="text" name="member_type" maxlength="120" value="<?= Security::e((string) ($member['member_type'] ?? '')) ?>"></label>
                                        <label><?= Security::e($t['website']) ?><input type="url" name="website" maxlength="255" value="<?= Security::e((string) ($member['website'] ?? '')) ?>"></label>
                                        <label><?= Security::e($t['invoice_name']) ?><input type="text" name="invoice_name" maxlength="255" value="<?= Security::e((string) ($member['invoice_name'] ?? '')) ?>"></label>
                                        <label><?= Security::e($t['street']) ?><input type="text" name="street" maxlength="255" value="<?= Security::e((string) ($member['street'] ?? '')) ?>"></label>
                                        <label><?= Security::e($t['postal_code']) ?><input type="text" name="postal_code" maxlength="20" value="<?= Security::e((string) ($member['postal_code'] ?? '')) ?>"></label>
                                        <label><?= Security::e($t['city']) ?><input type="text" name="city" maxlength="150" value="<?= Security::e((string) ($member['city'] ?? '')) ?>"></label>
                                        <label><?= Security::e($t['country']) ?><input type="text" name="country" maxlength="100" value="<?= Security::e((string) ($member['country'] ?? 'Deutschland')) ?>"></label>
                                        <label><?= Security::e($t['phone']) ?><input type="tel" name="phone" maxlength="100" value="<?= Security::e((string) ($member['phone'] ?? '')) ?>"></label>
                                        <label><?= Security::e($t['internal_notes']) ?><textarea name="internal_notes" rows="3"><?= Security::e((string) ($member['internal_notes'] ?? '')) ?></textarea></label>
                                        <label><?= Security::e($t['sort_order']) ?><input type="number" name="sort_order" value="<?= (int) ($member['sort_order'] ?? 100) ?>"></label>
                                        <label class="checkbox-row"><input type="checkbox" name="is_public" value="1" <?= !empty($member['is_public']) ? 'checked' : '' ?>><span><?= Security::e($t['show_publicly']) ?></span></label>
                                        <label class="checkbox-row"><input type="checkbox" name="public_consent_confirmed" value="1" <?= !empty($member['public_consent_at']) ? 'checked' : '' ?>><span>Gesonderte Einwilligung zur öffentlichen Anzeige liegt nachweisbar vor</span></label>
                                        <button class="primary" type="submit"><?= Security::e($t['save_changes']) ?></button>
                                    </form>
                                    <p>Verknüpfungen: Benutzer #<?= (int)($member['user_id'] ?? 0) ?>, Antrag #<?= (int)($member['application_id'] ?? 0) ?>.</p>
                                    <form method="post" action="<?= Security::e(I18n::url('/verwaltung/members/'.(int)$member['id'].'/delete')) ?>"><?= Security::csrfField() ?><label>Zum Löschen MITGLIED LÖSCHEN eingeben<input name="confirmation" required></label><button type="submit">Mitglied löschen</button></form>
                                </details>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

</section>
