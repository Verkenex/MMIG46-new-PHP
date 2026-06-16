

  SET NAMES utf8mb4;

INSERT INTO site_settings (setting_key, setting_value)
VALUES
  ('site_name', 'MMIG46 e.V.'),
  ('site_claim', 'Malibu Mirage Interessengemeinschaft PA46 Europa'),
  ('site_description', 'Vereinigung von Besitzern, Haltern und Piloten der Piper PA46 in Europa.'),
  ('contact_email', 'info@mmig46.org'),
  ('copyright_name', 'MMIG46 e.V.')
ON DUPLICATE KEY UPDATE
  setting_value = VALUES(setting_value);

DELETE FROM news_items
WHERE slug IN (
  'neue-website-in-vorbereitung',
  'fly-in-woerthersee-2026',
  'fly-in-woerthersee-2025',
  'fly-in-venedig-2024',
  'fly-in-verona-2023'
);

INSERT INTO news_items
(title, slug, category, image_path, comment_count, teaser, body, published_at, is_published)
VALUES
(
  'Fly-In Wörthersee 2026 – The place to be!',
  'fly-in-woerthersee-2026',
  'Reisen',
  '/assets/img/travel-woerthersee.jpg',
  0,
  'Das nächste große MMIG46 Fly-In führt 2026 an den Wörthersee.',
  'Auf der bisherigen MMIG46-Website ist das Fly-In Wörthersee 2026 bereits als aktueller Schwerpunkt mit Ankündigung, Einladung und Programm geführt. Für den Launch der neuen Website sollten hier die freigegebenen PDF-Dateien oder Detailtexte zu Ankündigung, Einladung und Programm ergänzt werden.',
  '2026-06-01 09:00:00',
  1
),
(
  'Fly-In Wörthersee 2025',
  'fly-in-woerthersee-2025',
  'Reisen',
  '/assets/img/travel-woerthersee.jpg',
  0,
  'Rückblick und Unterlagen zum MMIG46 Fly-In Wörthersee 2025.',
  'Auf der bisherigen Website sind für das Fly-In Wörthersee 2025 Ankündigung, Programm, Einladung und Rückblick verlinkt. Diese vier Dokumente sollten vor Launch übernommen oder als Download/Artikeltext eingebunden werden.',
  '2025-06-01 09:00:00',
  1
),
(
  'Fly-In Venedig 2024',
  'fly-in-venedig-2024',
  'Reisen',
  '/assets/img/travel-venedig.jpg',
  0,
  'MMIG46 Fly-In Venedig vom 6. bis 9. Juni 2024.',
  'Das Fly-In Venedig 2024 ist auf der bisherigen Website mit Datum sowie Ankündigung und Einladung geführt. Für den Launch sollte mindestens die Kurzbeschreibung mit Datum und die Einladung übernommen werden.',
  '2024-06-06 09:00:00',
  1
),
(
  'Fly-In Verona 2023',
  'fly-in-verona-2023',
  'Reisen',
  '/assets/img/travel-verona.jpg',
  0,
  'Archiv zum MMIG46 Fly-In Verona 2023.',
  'Auf der bisherigen Website sind zum Fly-In Verona 2023 Ankündigung, Einladung, Programm und Rückblick verlinkt. Diese Inhalte sind sinnvoll als jüngeres Archiv zu übernehmen.',
  '2023-06-01 09:00:00',
  1
);

DELETE FROM travel_items
WHERE slug IN (
  'fly-in-woerthersee-2026',
  'fly-in-woerthersee-2025',
  'fly-in-venedig-2024',
  'fly-in-verona-2023',
  'fly-in-fischland-2022',
  'fly-in-elba-2022',
  'fly-in-mougins-cote-dazur-2022',
  'jubilaeum-20-jahre-mmig46-sylt-2019',
  'gourmet-fly-in-bodensee-2021',
  'fly-in-montenegro-2019'
);

INSERT INTO travel_items
(title, slug, image_path, location, starts_on, ends_on, status, teaser, cta_label, body, is_published)
VALUES
(
  'Fly-In Wörthersee 2026 – The place to be!',
  'fly-in-woerthersee-2026',
  '/assets/img/travel-woerthersee.jpg',
  'Wörthersee',
  NULL,
  NULL,
  'planned',
  'Kommendes MMIG46 Fly-In mit Ankündigung, Einladung und Programm.',
  'Details ansehen',
  'Vor Launch ergänzen: finale Ankündigung, Einladung, Programm, Hotel-/Airport-Hinweise, Anmeldeinformationen und Kontaktperson.',
  1
),
(
  'Fly-In Wörthersee 2025',
  'fly-in-woerthersee-2025',
  '/assets/img/travel-woerthersee.jpg',
  'Wörthersee',
  NULL,
  NULL,
  'completed',
  'Vergangenes Fly-In mit Ankündigung, Programm, Einladung und Rückblick.',
  'Rückblick ansehen',
  'Vor Launch ergänzen: Ankündigung, Programm, Einladung, Rückblick und Bildergalerie beziehungsweise PDF-Downloads.',
  1
),
(
  'Fly-In Venedig 2024',
  'fly-in-venedig-2024',
  '/assets/img/travel-venedig.jpg',
  'Venedig',
  '2024-06-06',
  '2024-06-09',
  'completed',
  'Fly-In Venedig von Donnerstag, 6. bis Sonntag, 9. Juni 2024.',
  'Archiv ansehen',
  'Vor Launch ergänzen: Ankündigung und Einladung aus der bisherigen Website.',
  1
),
(
  'Fly-In Verona 2023',
  'fly-in-verona-2023',
  '/assets/img/travel-verona.jpg',
  'Verona',
  NULL,
  NULL,
  'completed',
  'Fly-In Verona 2023 mit Einladung, Programm und Rückblick.',
  'Archiv ansehen',
  'Vor Launch ergänzen: Ankündigung, Einladung, Programm und Rückblick aus der bisherigen Website.',
  1
),
(
  'Fly In Fischland 2022',
  'fly-in-fischland-2022',
  '/assets/img/travel-fischland.jpg',
  'Fischland',
  NULL,
  NULL,
  'completed',
  'MMIG46 Fly-In Fischland 2022.',
  'Archiv ansehen',
  'Vor Launch ergänzen: Einladung und Rückblick aus dem bisherigen Archiv.',
  1
),
(
  'Fly-In Elba 2022',
  'fly-in-elba-2022',
  '/assets/img/travel-elba.jpg',
  'Elba',
  NULL,
  NULL,
  'completed',
  'Fly-In Elba 2022 mit Ankündigung, Einladung, Programm und Rückblick.',
  'Archiv ansehen',
  'Vor Launch ergänzen: Ankündigung, Einladung, Programm und Rückblick.',
  1
),
(
  'MMIG46 Fly-In Mougins, Côte d’Azur 2022',
  'fly-in-mougins-cote-dazur-2022',
  '/assets/img/travel-mougins.jpg',
  'Mougins, Côte d’Azur',
  NULL,
  NULL,
  'completed',
  'Fly-In Mougins/Côte d’Azur 2022.',
  'Archiv ansehen',
  'Vor Launch ergänzen: Hinweis zum Hotel Le Mas Candille sowie Ankündigung, Einladung und Programm.',
  1
),
(
  '20 Jahre MMIG46 – Jubiläumsfeier Kampen/Sylt 2019',
  'jubilaeum-20-jahre-mmig46-sylt-2019',
  '/assets/img/travel-sylt.jpg',
  'Kampen / Sylt',
  '2019-09-27',
  '2019-09-29',
  'completed',
  'Jubiläumsfeier 20 Jahre MMIG46.',
  'Rückblick ansehen',
  'Vor Launch ergänzen: Rückblick zur Jubiläumsfeier in Kampen/Sylt.',
  1
),
(
  'MMIG46 Gourmet Fly-In Bodensee 2021',
  'gourmet-fly-in-bodensee-2021',
  '/assets/img/travel-bodensee.jpg',
  'Bodensee',
  '2021-09-02',
  '2021-09-05',
  'completed',
  'Gourmet Fly-In Bodensee 2021.',
  'Archiv ansehen',
  'Vor Launch ergänzen: Einladung, Programm und Rückblick.',
  1
),
(
  'MMIG46 Fly-In Montenegro 2019',
  'fly-in-montenegro-2019',
  '/assets/img/travel-montenegro.jpg',
  'Montenegro',
  '2019-06-06',
  '2019-06-10',
  'completed',
  'Fly-In Montenegro 2019 zu Pfingsten.',
  'Archiv ansehen',
  'Vor Launch ergänzen: Einladung, Programm und Rückblick.',
  1
);