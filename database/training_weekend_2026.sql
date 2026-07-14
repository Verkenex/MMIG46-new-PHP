INSERT INTO news_items (
    title_de,
    title_en,
    slug,
    category,
    teaser_de,
    teaser_en,
    body_de,
    body_en,
    image_path,
    published_at,
    is_published,
    comment_count
)
VALUES (
    'Trainingswochenende 2026 in EDLN',
    '2026 Training Weekend at EDLN',
    'trainingswochenende-2026',
    'Veranstaltung',
    'Use it or lose it: Am 25. und 26. September veranstaltet die MMIG46 ein Trainingswochenende mit IFR-Refresher, Feuerlöschübungen, Avionik, Simulatortraining und Checkflügen.',
    'Use it or lose it: On 25 and 26 September, MMIG46 will host a training weekend featuring IFR refresher training, fire-safety exercises, avionics, simulator training and proficiency checks.',
    '## Use it or lose it

Am 25. und 26. September 2026 findet im RAS-Seminarraum am Flughafen Mönchengladbach ein umfangreiches Trainingswochenende statt.

Für MMIG46-Mitglieder ist die Landegebühr in EDLN während der Veranstaltung halbiert. Eine Abstellgebühr wird nicht erhoben.

Die Kapazitäten sind begrenzt. Es gilt: **First come, first served.**

[Programm ansehen und anmelden](/trainingswochenende-2026)',
    '## Use it or lose it

An extensive training weekend will take place in the RAS seminar facilities at Mönchengladbach Airport on 25 and 26 September 2026.

Landing fees at EDLN will be reduced by 50 percent for MMIG46 members during the event. No parking fee will be charged.

Capacity is limited. **First come, first served.**

[View the programme and register](/trainingswochenende-2026?lang=en)',
    NULL,
    '2026-07-14 12:00:00',
    1,
    0
)
ON DUPLICATE KEY UPDATE
    title_de = VALUES(title_de),
    title_en = VALUES(title_en),
    teaser_de = VALUES(teaser_de),
    teaser_en = VALUES(teaser_en),
    body_de = VALUES(body_de),
    body_en = VALUES(body_en),
    published_at = VALUES(published_at),
    is_published = 1;