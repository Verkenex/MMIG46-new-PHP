UPDATE travel_items
SET
    title = 'Fly-In Wörthersee 2026',
    image_path = '/assets/img/travel-woerthersee-2026.jpg',
    location = 'Wörthersee / Klagenfurt',
    starts_on = '2026-06-11',
    ends_on = '2026-06-14',
    status = 'completed',
    teaser = 'Das Fly-In Wörthersee 2026 fand von Donnerstag, 11. Juni, bis Sonntag, 14. Juni 2026 statt.',
    cta_label = 'Details ansehen',
    legacy_pdf_url = NULL,
    legacy_pdf_path = NULL,
    body = 'Statischer Detailinhalt: app/Views/pages/reisen/fly-in-woerthersee-2026.php',
    is_published = 1
WHERE lang = 'de'
  AND slug = 'fly-in-woerthersee-2026';

UPDATE travel_items
SET
    title = 'Fly-In Wörthersee 2026',
    image_path = '/assets/img/travel-woerthersee-2026.jpg',
    location = 'Lake Wörthersee / Klagenfurt',
    starts_on = '2026-06-11',
    ends_on = '2026-06-14',
    status = 'completed',
    teaser = 'The Fly-In Wörthersee 2026 took place from Thursday, 11 June to Sunday, 14 June 2026.',
    cta_label = 'View details',
    legacy_pdf_url = NULL,
    legacy_pdf_path = NULL,
    body = 'Static detail content: app/Views/pages/reisen/fly-in-woerthersee-2026.php',
    is_published = 1
WHERE lang = 'en'
  AND slug = 'fly-in-woerthersee-2026';

UPDATE news_items
SET
    image_path = '/assets/img/travel-woerthersee-2026.jpg'
WHERE slug = 'fly-in-woerthersee-2026';