SET NAMES utf8mb4;

UPDATE content_pages
SET
  teaser = 'Anbieterkennzeichnung gemäß § 5 DDG.',
  body = 'MMIG46 e.V.

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

Hinweis: Diese Seite ist ein technischer Platzhalter und ersetzt keine rechtliche Prüfung.'
WHERE slug = 'impressum';

UPDATE news_items
SET
  title = 'Fly-In Wörthersee 2026',
  teaser = 'Das Fly-In Wörthersee 2026 ist als kommendes Reiseformat vorgesehen.'
WHERE slug = 'fly-in-woerthersee-2026';

UPDATE travel_items
SET
  title = 'Fly-In Wörthersee 2026',
  location = 'Wörthersee',
  teaser = 'Geplantes Fly-In der MMIG46-Community.'
WHERE slug = 'fly-in-woerthersee-2026';

INSERT INTO content_pages
(slug, title, teaser, body, meta_title, meta_description, is_published)
VALUES
(
    'verein',
    'MMIG46 e.V.',
    'Zusammenschluss von PA46 Malibu Mirage Piloten und Eigentümern in Europa.',
    '{
        "eyebrow": "Verein",
        "headline": "MMIG46 e.V.",
        "intro": "Zusammenschluss von PA46 Malibu Mirage Piloten und Eigentümern in Europa.",
        "cards": [
            {
                "title": "Einige Worte über uns",
                "text": "Die MMIG46 fördert den Erfahrungsaustausch, den sicheren Flugbetrieb und die Gemeinschaft rund um die PA46-Familie. Gemeinsame Reisen, technische Diskussionen und persönliche Kontakte stehen im Mittelpunkt."
            },
            {
                "title": "Ziele",
                "text": "Austausch von Erfahrungen, Organisation gemeinsamer Veranstaltungen, technische Hinweise, Mitgliederkommunikation und Pflege eines aktiven europäischen Netzwerks."
            },
            {
                "title": "Gemeinschaft",
                "text": "Neben technischen und organisatorischen Themen steht der persönliche Austausch im Mittelpunkt: gemeinsame Fly-Ins, Mitgliedertreffen, Erfahrungsberichte und direkte Unterstützung innerhalb der Community."
            }
        ],
        "actions": [
            {
                "title": "Vorstand",
                "text": "Kontakt, Aufgaben und Ansprechpartner",
                "url": "/verein#vorstand"
            },
            {
                "title": "Satzung",
                "text": "Vereinszweck, Regeln und Ordnung",
                "url": "/satzung"
            },
            {
                "title": "Mitgliedsantrag",
                "text": "Informationen zur Mitgliedschaft",
                "url": "/mitgliedsantrag"
            },
            {
                "title": "Interner Austausch",
                "text": "Forum und geschützte Inhalte",
                "url": "/forum"
            }
        ]
    }',
    'Verein | MMIG46 e.V.',
    'Informationen zum Verein MMIG46 e.V.',
    1
)
ON DUPLICATE KEY UPDATE
title = VALUES(title),
teaser = VALUES(teaser),
body = VALUES(body),
meta_title = VALUES(meta_title),
meta_description = VALUES(meta_description),
is_published = VALUES(is_published);