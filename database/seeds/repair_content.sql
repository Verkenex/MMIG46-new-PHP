SET NAMES utf8mb4;

INSERT INTO site_settings (setting_key, setting_value) VALUES
('site_name', 'MMIG46 e.V.'),
('site_claim', 'Malibu Mirage Interessengemeinschaft 46'),
('site_description', 'Vereinigung von Besitzern, Haltern und Piloten der Piper PA46.'),
('contact_email', 'info@mmig46.org'),
('copyright_name', 'MMIG46 e.V.')
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value);

INSERT INTO content_pages
(slug, title, teaser, body, meta_title, meta_description, is_published)
VALUES
(
  'verein',
  'Verein',
  'Die MMIG46 e.V. vernetzt Besitzer, Halter und Piloten der Piper PA46.',
  'Die MMIG46 e.V. ist eine Interessengemeinschaft rund um die Piper PA46.

Im Mittelpunkt stehen Erfahrungsaustausch, gemeinsame Reiseaktivitäten, technische Themen, Sicherheit, Kontakte innerhalb der Community und die Pflege des Netzwerks zwischen Besitzern, Haltern und Piloten.

Bitte ergänzen:
- aktueller Vorstand
- Satzung
- Mitgliedsantrag
- offizielle Vereinsanschrift
- Ansprechpartner
- Beitragsordnung',
  'MMIG46 e.V. - Verein',
  'Informationen zur MMIG46 e.V.',
  1
),
(
  'impressum',
  'Impressum',
  'Anbieterkennzeichnung gemaess Paragraph 5 DDG.',
  'MMIG46 e.V.

Bitte vor Livegang vollstaendig und juristisch pruefen:

- vollstaendiger Vereinsname
- ladungsfaehige Anschrift
- vertretungsberechtigter Vorstand
- Vereinsregister
- Registernummer
- Registergericht
- Kontakt-E-Mail
- Telefonnummer, falls gewuenscht
- Verantwortlich fuer den Inhalt

Hinweis: Diese Seite ist ein technischer Platzhalter und ersetzt keine rechtliche Pruefung.',
  'Impressum - MMIG46 e.V.',
  'Impressum der MMIG46 e.V.',
  1
),
(
  'datenschutz',
  'Datenschutz',
  'Informationen zur Verarbeitung personenbezogener Daten.',
  'Diese Website verarbeitet personenbezogene Daten insbesondere im Rahmen von Session-Cookies, Login, Forum, Kontaktformular und Mitgliederverwaltung.

Bitte vor Livegang konkret ergaenzen:
- Verantwortlicher
- Hostinganbieter
- Server-Logs
- Kontaktformular
- E-Mail-Versand ueber SMTP
- Session-Cookies
- Rechte der betroffenen Personen
- Speicherdauer
- Rechtsgrundlagen
- Beschwerderecht bei der Aufsichtsbehoerde

Hinweis: Diese Seite ist ein technischer Platzhalter und ersetzt keine rechtliche Pruefung.',
  'Datenschutz - MMIG46 e.V.',
  'Datenschutzhinweise der MMIG46 e.V.',
  1
),
(
  'agb',
  'AGB',
  'Nutzungsbedingungen fuer Website, Forum und Mitgliederbereich.',
  'Diese Seite sollte nur veroeffentlicht werden, wenn tatsaechlich allgemeine Geschaefts- oder Nutzungsbedingungen benoetigt werden.

Empfohlene Inhalte:
- Nutzung des Forums
- zulaessige Inhalte
- Moderation
- Haftung fuer Nutzerbeitraege
- Zugangsbeschraenkungen
- Ausschluss missbraeuchlicher Nutzung

Hinweis: Rechtlich pruefen lassen.',
  'AGB - MMIG46 e.V.',
  'Nutzungsbedingungen der MMIG46 e.V.',
  1
)
ON DUPLICATE KEY UPDATE
title = VALUES(title),
teaser = VALUES(teaser),
body = VALUES(body),
meta_title = VALUES(meta_title),
meta_description = VALUES(meta_description),
is_published = VALUES(is_published);

INSERT INTO news_items
(title, slug, teaser, body, published_at, is_published)
VALUES
(
  'Neue MMIG46-Website in Vorbereitung',
  'neue-website-in-vorbereitung',
  'Die Website wird technisch modernisiert und auf PHP/MySQL umgestellt.',
  'Die MMIG46-Website wird modernisiert. Ziel ist eine schlanke PHP/MySQL-Loesung mit News, Reisen, Forum, Memberlist, Kontaktformular und Verwaltungsbereich.',
  NOW(),
  1
),
(
  'Fly-In Woerthersee 2026',
  'fly-in-woerthersee-2026',
  'Das Fly-In Woerthersee 2026 ist als kommendes Reiseformat vorgesehen.',
  'Details wie Einladung, Programm und organisatorische Hinweise sollten nach interner Freigabe ergaenzt werden.',
  '2026-06-01 09:00:00',
  1
)
ON DUPLICATE KEY UPDATE
title = VALUES(title),
teaser = VALUES(teaser),
body = VALUES(body),
published_at = VALUES(published_at),
is_published = VALUES(is_published);

INSERT INTO travel_items
(title, slug, location, starts_on, ends_on, status, teaser, body, is_published)
VALUES
(
  'Fly-In Woerthersee 2026',
  'fly-in-woerthersee-2026',
  'Woerthersee',
  NULL,
  NULL,
  'planned',
  'Geplantes Fly-In der MMIG46-Community.',
  'Details zu Termin, Anflug, Programm, Unterkunft und Anmeldung bitte nach Freigabe ergaenzen.',
  1
),
(
  'Fly-In Woerthersee 2025',
  'fly-in-woerthersee-2025',
  'Woerthersee',
  NULL,
  NULL,
  'completed',
  'Vergangenes Fly-In der MMIG46-Community.',
  'Rueckblick, Programm und Bilder koennen hier ergaenzt werden.',
  1
)
ON DUPLICATE KEY UPDATE
title = VALUES(title),
location = VALUES(location),
starts_on = VALUES(starts_on),
ends_on = VALUES(ends_on),
status = VALUES(status),
teaser = VALUES(teaser),
body = VALUES(body),
is_published = VALUES(is_published);