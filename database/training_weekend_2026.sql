-- Seed für neue Installationen; bestehende Installationen verwenden
-- database/patches/2026_training_weekend_completed.sql.
INSERT INTO news_items (
    lang, title, slug, category, teaser, body, image_path,
    published_at, is_published, comment_count
)
VALUES
(
    'de',
    'Trainingswochenende 2026 in EDLN',
    'trainingswochenende-2026',
    'Veranstaltung',
    'Das MMIG46-Trainingswochenende am 25. und 26. September 2026 in EDLN war ein Erfolg. Ein Rückblick mit Bildern und Zusammenfassung folgt in Kürze.',
    '## Trainingswochenende 2026 in EDLN

Das MMIG46-Trainingswochenende am 25. und 26. September 2026 am Flughafen Mönchengladbach ist erfolgreich zu Ende gegangen. Vielen Dank an alle Teilnehmenden und Mitwirkenden.

Ein ausführlicher Rückblick mit Bildern und Zusammenfassung folgt in Kürze. Bis dahin bleibt das damalige Programm auf der [Veranstaltungsseite](/trainingswochenende-2026?lang=de) dokumentiert.',
    '/assets/img/news-training-weekend-2026.jpg',
    '2026-09-29 19:00:00', 1, 0
),
(
    'en',
    '2026 Training Weekend at EDLN',
    'trainingswochenende-2026',
    'Event',
    'The MMIG46 training weekend at EDLN on 25–26 September 2026 was a success. A review with photos and a summary will follow soon.',
    '## 2026 Training Weekend at EDLN

The MMIG46 training weekend at Mönchengladbach Airport on 25–26 September 2026 was a success. Thank you to everyone who took part and helped make it happen.

A full review with photos and a summary will follow soon. The original programme remains available on the [event page](/trainingswochenende-2026?lang=en).',
    '/assets/img/news-training-weekend-2026.jpg',
    '2026-09-29 19:00:00', 1, 0
)
ON DUPLICATE KEY UPDATE
    title = VALUES(title),
    category = VALUES(category),
    teaser = VALUES(teaser),
    body = VALUES(body),
    image_path = VALUES(image_path),
    published_at = VALUES(published_at),
    is_published = VALUES(is_published),
    comment_count = VALUES(comment_count);
