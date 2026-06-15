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