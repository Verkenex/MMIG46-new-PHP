SET NAMES utf8mb4;

INSERT INTO forum_topics (
  user_id,
  title,
  slug,
  is_pinned,
  is_locked,
  is_public,
  created_at,
  updated_at
)
SELECT
  1,
  'Willkommen im MMIG46-Forum',
  'willkommen-im-mmig46-forum',
  1,
  0,
  1,
  NOW(),
  NOW()
WHERE NOT EXISTS (
  SELECT 1
  FROM forum_topics
  WHERE slug = 'willkommen-im-mmig46-forum'
);

INSERT INTO forum_posts (
  topic_id,
  user_id,
  body,
  is_deleted,
  created_at,
  updated_at
)
SELECT
  t.id,
  1,
  'Dieses Forum ist öffentlich lesbar. Schreibrechte sind für registrierte Vereinsmitglieder vorgesehen.',
  0,
  NOW(),
  NOW()
FROM forum_topics t
WHERE t.slug = 'willkommen-im-mmig46-forum'
  AND NOT EXISTS (
    SELECT 1
    FROM forum_posts p
    WHERE p.topic_id = t.id
  );
