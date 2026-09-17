-- Einmalige Vorbereitung fuer den Import des historischen phpBB-Forums.
-- Vor Ausfuehrung: vollstaendiges Datenbank-Backup erstellen.

CREATE TABLE forum_sections (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  parent_id INT UNSIGNED NULL,
  name VARCHAR(180) NOT NULL,
  description TEXT NULL,
  visibility ENUM('public','member','admin') NOT NULL DEFAULT 'public',
  sort_order INT NOT NULL DEFAULT 100,
  legacy_phpbb_forum_id INT UNSIGNED NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_forum_sections_parent FOREIGN KEY (parent_id) REFERENCES forum_sections(id) ON DELETE SET NULL,
  UNIQUE KEY uq_forum_sections_legacy (legacy_phpbb_forum_id),
  INDEX idx_forum_sections_visibility_sort (visibility, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE forum_topics
  DROP FOREIGN KEY fk_forum_topics_user,
  MODIFY user_id INT UNSIGNED NULL,
  ADD section_id INT UNSIGNED NULL AFTER user_id,
  ADD legacy_author_name VARCHAR(255) NULL AFTER section_id,
  ADD legacy_phpbb_topic_id INT UNSIGNED NULL AFTER legacy_author_name,
  ADD CONSTRAINT fk_forum_topics_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  ADD CONSTRAINT fk_forum_topics_section FOREIGN KEY (section_id) REFERENCES forum_sections(id) ON DELETE SET NULL,
  ADD UNIQUE KEY uq_forum_topic_legacy (legacy_phpbb_topic_id),
  ADD INDEX idx_forum_topics_section (section_id);

ALTER TABLE forum_posts
  DROP FOREIGN KEY fk_forum_posts_user,
  MODIFY user_id INT UNSIGNED NULL,
  ADD legacy_author_name VARCHAR(255) NULL AFTER user_id,
  ADD legacy_phpbb_post_id INT UNSIGNED NULL AFTER legacy_author_name,
  ADD CONSTRAINT fk_forum_posts_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  ADD UNIQUE KEY uq_forum_post_legacy (legacy_phpbb_post_id);

CREATE TABLE forum_attachments (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  post_id INT UNSIGNED NOT NULL,
  original_name VARCHAR(255) NOT NULL,
  stored_name VARCHAR(255) NOT NULL,
  mime_type VARCHAR(120) NOT NULL DEFAULT 'application/octet-stream',
  file_size INT UNSIGNED NOT NULL DEFAULT 0,
  download_count INT UNSIGNED NOT NULL DEFAULT 0,
  legacy_phpbb_attach_id INT UNSIGNED NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_forum_attachments_post FOREIGN KEY (post_id) REFERENCES forum_posts(id) ON DELETE CASCADE,
  UNIQUE KEY uq_forum_attachment_legacy (legacy_phpbb_attach_id),
  UNIQUE KEY uq_forum_attachment_stored (stored_name),
  INDEX idx_forum_attachments_post (post_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
