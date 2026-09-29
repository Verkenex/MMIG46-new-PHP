-- Einmalig auf der Live-Datenbank ausführen, damit der bestehende Newsbeitrag
-- die abgeschlossene Veranstaltung statt einer Anmeldung ankündigt.
-- Bild, Kommentare und übrige manuelle Änderungen bleiben erhalten.
UPDATE news_items
SET
    teaser = 'Das MMIG46-Trainingswochenende am 25. und 26. September 2026 in EDLN war ein Erfolg. Ein Rückblick mit Bildern und Zusammenfassung folgt in Kürze.',
    body = '## Trainingswochenende 2026 in EDLN

Das MMIG46-Trainingswochenende am 25. und 26. September 2026 am Flughafen Mönchengladbach ist erfolgreich zu Ende gegangen. Vielen Dank an alle Teilnehmenden und Mitwirkenden.

Ein ausführlicher Rückblick mit Bildern und Zusammenfassung folgt in Kürze. Bis dahin bleibt das damalige Programm auf der [Veranstaltungsseite](/trainingswochenende-2026?lang=de) dokumentiert.',
    published_at = '2026-09-29 19:00:00'
WHERE lang = 'de'
  AND slug = 'trainingswochenende-2026'
  AND teaser LIKE 'Use it or lose it:%';

UPDATE news_items
SET
    teaser = 'The MMIG46 training weekend at EDLN on 25–26 September 2026 was a success. A review with photos and a summary will follow soon.',
    body = '## 2026 Training Weekend at EDLN

The MMIG46 training weekend at Mönchengladbach Airport on 25–26 September 2026 was a success. Thank you to everyone who took part and helped make it happen.

A full review with photos and a summary will follow soon. The original programme remains available on the [event page](/trainingswochenende-2026?lang=en).',
    published_at = '2026-09-29 19:00:00'
WHERE lang = 'en'
  AND slug = 'trainingswochenende-2026'
  AND teaser LIKE 'Use it or lose it:%';
