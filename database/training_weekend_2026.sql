INSERT INTO news_items (
    lang,
    title,
    slug,
    category,
    teaser,
    body,
    image_path,
    published_at,
    is_published,
    comment_count
)
VALUES
(
    'de',
    'Trainingswochenende 2026 in EDLN',
    'trainingswochenende-2026',
    'Veranstaltung',
    'Use it or lose it: Am 25. und 26. September veranstaltet die MMIG46 ein Trainingswochenende mit IFR-Refresher, Feuerlöschübungen, Avionik, Simulatortraining und Checkflügen. Eine vorherige Registrierung ist erforderlich.',
    '## Use it or lose it

Am 25. und 26. September 2026 findet in den RAS-Seminarräumen am Flughafen Mönchengladbach ein umfangreiches Trainingswochenende statt.

Für alle Teilnehmer wird die Landegebühr in EDLN während der Veranstaltung um 50 Prozent reduziert. Eine Abstellgebühr wird nicht erhoben.

Die Teilnahmegebühr beträgt **450 Euro für MMIG46-Mitglieder** und **650 Euro für Nichtmitglieder**.

Eine vorherige Registrierung ist zwingend erforderlich. Die Teilnahme sowie einzelne Programmpunkte und Checkflüge sind erst nach Bestätigung durch den Veranstalter verbindlich reserviert.

Die Kapazitäten sind begrenzt. Es gilt: **First come, first served.**

[Programm ansehen und anmelden](/trainingswochenende-2026?lang=de)',
    '/assets/img/news-training-weekend-2026.jpg',
    '2026-07-14 12:00:00',
    1,
    0
),
(
    'en',
    '2026 Training Weekend at EDLN',
    'trainingswochenende-2026',
    'Event',
    'Use it or lose it: On 25 and 26 September, MMIG46 will host a training weekend featuring IFR refresher training, fire-safety exercises, avionics, simulator training and proficiency checks. Prior registration is required.',
    '## Use it or lose it

An extensive training weekend will take place in the RAS seminar facilities at Mönchengladbach Airport on 25 and 26 September 2026.

Landing fees at EDLN will be reduced by 50 percent for all participants during the event. No aircraft parking fee will be charged.

The participation fee is **EUR 450 for MMIG46 members** and **EUR 650 for non-members**.

Prior registration is mandatory. Participation, individual programme items and proficiency checks are only reserved after confirmation by the organiser.

Capacity is limited. **First come, first served.**

[View the programme and register](/trainingswochenende-2026?lang=en)',
    '/assets/img/news-training-weekend-2026.jpg',
    '2026-07-14 12:00:00',
    1,
    0
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