SET NAMES utf8mb4;

-- Demo password for both accounts:
-- BitteNachLivegangAendern123

INSERT INTO users (name, email, password_hash, role, email_verified_at)
VALUES
  (
    'Max Mustermann',
    'max.mustermann@example.org',
    '$2y$10$HcfUVHh/XNE3xqcFJH6fX.HwlhZ7g8cBTmS6hlOlhc8o4/bJ5gBam',
    'admin',
    NOW()
  ),
  (
    'MMIG46 Mitglied',
    'mitglied@example.org',
    '$2y$10$HcfUVHh/XNE3xqcFJH6fX.HwlhZ7g8cBTmS6hlOlhc8o4/bJ5gBam',
    'member',
    NOW()
  )
ON DUPLICATE KEY UPDATE
  name = VALUES(name),
  password_hash = VALUES(password_hash),
  role = VALUES(role),
  email_verified_at = VALUES(email_verified_at);

INSERT INTO members (name, email, aircraft, base, role_label, member_type, is_public, sort_order)
VALUES
  (
    'Max Mustermann',
    'max.mustermann@example.org',
    'Piper PA-46 Jetprop',
    'EDDH',
    'Mitglied',
    'Standard',
    1,
    100
  )
ON DUPLICATE KEY UPDATE
  email = VALUES(email),
  aircraft = VALUES(aircraft),
  base = VALUES(base),
  role_label = VALUES(role_label),
  member_type = VALUES(member_type),
  website = VALUES(website),
  is_public = VALUES(is_public),
  sort_order = VALUES(sort_order);

INSERT INTO site_settings (setting_key, setting_value)
VALUES
  ('site_name', 'MMIG46 e.V.'),
  ('site_claim', 'Malibu Mirage Interessengemeinschaft 46'),
  ('site_description', 'Vereinigung von Besitzern, Haltern und Piloten der Piper PA46.'),
  ('contact_email', 'info@mmig46.org'),
  ('copyright_name', 'MMIG46 e.V.')
ON DUPLICATE KEY UPDATE
  setting_value = VALUES(setting_value);

INSERT INTO forum_topics (
  user_id,
  title,
  slug,
  is_pinned,
  is_public,
  updated_at
)
SELECT
  u.id,
  'Willkommen im MMIG46-Forum: Regeln und Hinweise',
  'willkommen-im-mmig46-forum-regeln-und-hinweise',
  1,
  1,
  NOW()
FROM users u
WHERE u.email = 'max.mustermann@example.org'
  AND NOT EXISTS (
    SELECT 1
    FROM forum_topics ft
    WHERE ft.slug = 'willkommen-im-mmig46-forum-regeln-und-hinweise'
  );

INSERT INTO forum_posts (
  topic_id,
  user_id,
  body
)
SELECT
  ft.id,
  u.id,
  'Dieses Forum ist öffentlich lesbar.
Schreiben dürfen nur registrierte Vereinsmitglieder.
Bitte sachlich bleiben, personenbezogene Daten vermeiden und technische Hinweise nachvollziehbar formulieren.'
FROM forum_topics ft
JOIN users u ON u.email = 'max.mustermann@example.org'
WHERE ft.slug = 'willkommen-im-mmig46-forum-regeln-und-hinweise'
  AND NOT EXISTS (
    SELECT 1
    FROM forum_posts fp
    WHERE fp.topic_id = ft.id
  );

INSERT INTO news_items (title, slug, category, image_path, comment_count, teaser, body, published_at, is_published)
VALUES
  (
    'Neue MMIG46-Website in Vorbereitung',
    'neue-website-in-vorbereitung',
    'Verein',
    '/assets/img/news-meeting.jpg',
    0,
    'Die Website wird technisch modernisiert und auf PHP/MariaDB umgestellt.',
    'Die MMIG46-Website wird modernisiert. Ziel ist eine schlanke, klassische PHP/MariaDB-Lösung mit News, Reisen, Forum, Memberlist, Kontaktformular und Verwaltungsbereich.',
    NOW(),
    1
  ),
  (
    'Fly-In Wörthersee 2026',
    'fly-in-woerthersee-2026',
    'Reisen',
    '/assets/img/news-woerthersee.jpg',
    0,
    'Das Fly-In Wörthersee 2026 ist als kommendes Reiseformat vorgesehen.',
    'Details wie Einladung, Programm und organisatorische Hinweise sollten hier nach interner Freigabe ergänzt werden.',
    '2026-06-01 09:00:00',
    1
  )
ON DUPLICATE KEY UPDATE
  title = VALUES(title),
  category = VALUES(category),
  image_path = VALUES(image_path),
  comment_count = VALUES(comment_count),
  teaser = VALUES(teaser),
  body = VALUES(body),
  published_at = VALUES(published_at),
  is_published = VALUES(is_published);

INSERT INTO travel_items (title, slug, image_path, location, starts_on, ends_on, status, teaser, cta_label, body, is_published)
VALUES
  (
    'Fly-In Wörthersee 2026',
    'fly-in-woerthersee-2026',
    '/assets/img/travel-woerthersee.jpg',
    'Wörthersee',
    NULL,
    NULL,
    'completed',
    'Fly-In der MMIG46-Community.',
    'Impressionen und Nachbericht',
    'Programm und Rückblick zum Fly-In Wörthersee 2026.',
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
    'Vergangenes Fly-In der MMIG46-Community.',
    'Rückblick ansehen',
    'Rückblick, Programm und Bilder können hier ergänzt werden.',
    1
  )
ON DUPLICATE KEY UPDATE
  title = VALUES(title),
  image_path = VALUES(image_path),
  location = VALUES(location),
  starts_on = VALUES(starts_on),
  ends_on = VALUES(ends_on),
  status = VALUES(status),
  teaser = VALUES(teaser),
  cta_label = VALUES(cta_label),
  body = VALUES(body),
  is_published = VALUES(is_published);
