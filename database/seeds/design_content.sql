SET NAMES utf8mb4;

UPDATE news_items
SET
  category = 'Verein',
  image_path = '/assets/img/news-meeting.jpg',
  comment_count = 0
WHERE slug = 'neue-website-in-vorbereitung';

UPDATE news_items
SET
  category = 'Reisen',
  image_path = '/assets/img/news-woerthersee.jpg',
  comment_count = 0
WHERE slug = 'fly-in-woerthersee-2026';

UPDATE travel_items
SET
  image_path = '/assets/img/travel-woerthersee.jpg',
  cta_label = 'Details ansehen'
WHERE slug = 'fly-in-woerthersee-2026';

UPDATE travel_items
SET
  image_path = '/assets/img/travel-woerthersee.jpg',
  cta_label = 'Rückblick ansehen'
WHERE slug = 'fly-in-woerthersee-2025';