INSERT INTO site_settings (setting_key, setting_value) VALUES
('site_name', 'MMIG46 e.V.'),
('site_claim', 'Malibu Mirage Interessengemeinschaft 46'),
('site_description', 'Vereinigung von Besitzern, Haltern und Piloten der Piper PA46.'),
('contact_email', 'info@mmig46.org'),
('copyright_name', 'MMIG46 e.V.');

INSERT INTO content_pages
(slug, title, teaser, body, meta_title, meta_description, is_published)
VALUES
(
  'verein',
  'Verein',
  'Die MMIG46 e.V. vernetzt Besitzer, Halter und Piloten der Piper PA46.',
  'Die MMIG46 e.V. ist eine Interessengemeinschaft rund um die Piper PA46. Im Mittelpunkt stehen Erfahrungsaustausch, gemeinsame Reiseaktivitäten, technische Themen, Sicherheit, Kontakte innerhalb der Community und die Pflege des Netzwerks zwischen Besitzern, Haltern und Piloten.

Die Website dient als zentrale Plattform für Informationen, Reisen, News, Forum und Mitgliederverwaltung.

Bitte ergänzen:
- aktueller Vorstand
- Satzung
- Mitgliedsantrag
- offizielle Vereinsanschrift
- Ansprechpartner
- Beitragsordnung',
  'MMIG46 e.V. – Verein',
  'Informationen zur MMIG46 e.V., der Interessengemeinschaft rund um die Piper PA46.',
  1
),
(
  'impressum',
  'Impressum',
  'Anbieterkennzeichnung gemäß § 5 DDG.',
  'MMIG46 e.V.

Bitte vor Livegang vollständig und juristisch prüfen:

- vollständiger Vereinsname
- ladungsfähige Anschrift
- vertretungsberechtigter Vorstand
- Vereinsregister
- Registernummer
- Registergericht
- Kontakt-E-Mail
- Telefonnummer, falls gewünscht
- Verantwortlich für den Inhalt

Hinweis: Diese Seite ist ein technischer Platzhalter und ersetzt keine rechtliche Prüfung.',
  'Impressum – MMIG46 e.V.',
  'Impressum der MMIG46 e.V.',
  1
),
(
  'datenschutz',
  'Datenschutz',
  'Informationen zur Verarbeitung personenbezogener Daten.',
  'Diese Website verarbeitet personenbezogene Daten insbesondere im Rahmen von Session-Cookies, Login, Forum, Kontaktformular und Mitgliederverwaltung.

Bitte vor Livegang konkret ergänzen:
- Verantwortlicher
- Hostinganbieter
- Server-Logs
- Kontaktformular
- E-Mail-Versand über SMTP
- Session-Cookies
- Rechte der betroffenen Personen
- Speicherdauer
- Rechtsgrundlagen
- Beschwerderecht bei der Aufsichtsbehörde

Hinweis: Diese Seite ist ein technischer Platzhalter und ersetzt keine rechtliche Prüfung.',
  'Datenschutz – MMIG46 e.V.',
  'Datenschutzhinweise der MMIG46 e.V.',
  1
),
(
  'agb',
  'AGB',
  'Nutzungsbedingungen für Website, Forum und Mitgliederbereich.',
  'Diese Seite sollte nur veröffentlicht werden, wenn tatsächlich allgemeine Geschäfts- oder Nutzungsbedingungen benötigt werden.

Empfohlene Inhalte:
- Nutzung des Forums
- zulässige Inhalte
- Moderation
- Haftung für Nutzerbeiträge
- Zugangsbeschränkungen
- Ausschluss missbräuchlicher Nutzung

Hinweis: Rechtlich prüfen lassen.',
  'AGB – MMIG46 e.V.',
  'Nutzungsbedingungen der MMIG46 e.V.',
  1
);

INSERT INTO news_items
(title, slug, teaser, body, published_at, is_published)
VALUES
(
  'Neue MMIG46-Website in Vorbereitung',
  'neue-website-in-vorbereitung',
  'Die Website wird technisch modernisiert und auf PHP/MariaDB umgestellt.',
  'Die MMIG46-Website wird modernisiert. Ziel ist eine schlanke, klassische PHP/MariaDB-Lösung mit News, Reisen, Forum, Memberlist, Kontaktformular und Verwaltungsbereich.',
  NOW(),
  1
),
(
  'Fly-In Wörthersee 2026',
  'fly-in-woerthersee-2026',
  'Das Fly-In Wörthersee 2026 ist als kommendes Reiseformat vorgesehen.',
  'Auf der bestehenden MMIG46-Website wird das Fly-In Wörthersee 2026 als aktuelles bzw. kommendes Thema geführt. Details wie Einladung, Programm und organisatorische Hinweise sollten hier nach interner Freigabe ergänzt werden.',
  '2026-06-01 09:00:00',
  1
);

INSERT INTO travel_items
(title, slug, location, starts_on, ends_on, status, teaser, body, is_published)
VALUES
(
  'Fly-In Wörthersee 2026',
  'fly-in-woerthersee-2026',
  'Wörthersee',
  NULL,
  NULL,
  'planned',
  'Geplantes Fly-In der MMIG46-Community.',
  'Details zu Termin, Anflug, Programm, Unterkunft und Anmeldung bitte nach Freigabe ergänzen.',
  1
),
(
  'Fly-In Wörthersee 2025',
  'fly-in-woerthersee-2025',
  'Wörthersee',
  NULL,
  NULL,
  'completed',
  'Vergangenes Fly-In der MMIG46-Community.',
  'Rückblick, Programm und Bilder können hier ergänzt werden.',
  1
);