SET NAMES utf8mb4;

UPDATE news_items
SET
  category = 'Reisen',
  image_path = '/assets/img/news-woerthersee.jpg',
  comment_count = 0
WHERE slug = 'fly-in-woerthersee-2026';

UPDATE news_items
SET
  category = 'Verein',
  image_path = '/assets/img/hero-pa46.jpg',
  comment_count = 0
WHERE slug = 'neue-website-in-vorbereitung';

UPDATE travel_items
SET
  image_path = '/assets/img/travel-woerthersee.jpg',
  cta_label = 'Details ansehen'
WHERE slug = 'fly-in-woerthersee-2026';

UPDATE travel_items
SET
  image_path = '/assets/img/travel-woerthersee.jpg',
  cta_label = 'Rueckblick ansehen'
WHERE slug = 'fly-in-woerthersee-2025';