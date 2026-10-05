-- Direkt ausführen; ersetzt auch die Vorankündigung. Der vorherige Completed-Patch ist nicht erforderlich.
-- Bestehende Kommentare und die Identität des Newsbeitrags bleiben erhalten.
INSERT INTO news_items (lang, title, slug, category, teaser, body, image_path, published_at, is_published, comment_count)
VALUES
('de',
    'Rückblick: Trainingswochenende 2026 in EDLN',
    'trainingswochenende-2026',
    'Veranstaltung',
    'Der vollständige Rückblick von Klaus Gerecht zum MMIG46-Trainingswochenende am 25. und 26. September 2026 ist online – mit Bildern aus EDLN.',
    '## Trainingswochenende 2026: Der Rückblick ist online

Klaus Gerecht berichtet über das Trainingswochenende am 25. und 26. September 2026 in EDLN. Der vollständige Originalbericht mit Bildern ist auf der Veranstaltungsseite zu lesen.

[Rückblick mit Bildern lesen](/trainingswochenende-2026?lang=de)',
    '/assets/img/training-weekend/recap-2026/06-feuerwehrfahrzeug.webp',
    '2026-10-05 11:45:00',
    1, 0
),
('en',
    'Review: 2026 Training Weekend at EDLN',
    'trainingswochenende-2026',
    'Event',
    'Klaus Gerecht’s full report on the MMIG46 training weekend at EDLN on 25–26 September 2026 is now online, with photos.',
    '## 2026 Training Weekend: The report is online

Read Klaus Gerecht’s full report, published in its original German wording, and view photos from the training weekend at EDLN on 25–26 September 2026.

[Read the report with photos](/trainingswochenende-2026?lang=en)',
    '/assets/img/training-weekend/recap-2026/06-feuerwehrfahrzeug.webp',
    '2026-10-05 11:45:00',
    1, 0
)
ON DUPLICATE KEY UPDATE
    title = VALUES(title),
    category = VALUES(category),
    teaser = VALUES(teaser),
    body = VALUES(body),
    image_path = VALUES(image_path),
    published_at = VALUES(published_at),
    is_published = VALUES(is_published);
