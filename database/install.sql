CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','moderator','member','guest') NOT NULL DEFAULT 'member',
  email_verified_at DATETIME NULL,
  reset_token_hash VARCHAR(255) NULL,
  reset_expires_at DATETIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE members (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NULL,
  aircraft VARCHAR(120) NULL,
  base VARCHAR(120) NULL,
  role_label VARCHAR(120) NULL,
  member_type VARCHAR(120) NULL,
  website VARCHAR(255) NULL,
  is_public TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 100,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE forum_posts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    title VARCHAR(180) NOT NULL,
    body MEDIUMTEXT NOT NULL,
    pinned TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_forum_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_posts_created (created_at),
    INDEX idx_posts_pinned (pinned),
    FULLTEXT KEY ft_forum_search (title, body)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE contact_requests (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  email VARCHAR(190) NOT NULL,
  message MEDIUMTEXT NOT NULL,
  ip_address VARCHAR(64) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  handled_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE login_attempts (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NULL,
  ip_address VARCHAR(64) NOT NULL,
  success TINYINT(1) NOT NULL DEFAULT 0,
  attempted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_login_ip_time (ip_address, attempted_at),
  INDEX idx_login_email_time (email, attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE content_pages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lang CHAR(2) NOT NULL DEFAULT 'de',
    slug VARCHAR(80) NOT NULL,
    title VARCHAR(180) NOT NULL,
    teaser TEXT NULL,
    body MEDIUMTEXT NOT NULL,
    meta_title VARCHAR(180) NULL,
    meta_description VARCHAR(255) NULL,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_content_lang_slug (lang, slug),
    INDEX idx_content_lang_published (lang, is_published),
    FULLTEXT KEY ft_content_search (title, teaser, body)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE news_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lang CHAR(2) NOT NULL DEFAULT 'de',
    title VARCHAR(180) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    category VARCHAR(80) NULL,
    image_path VARCHAR(255) NULL,
    comment_count INT UNSIGNED NOT NULL DEFAULT 0,
    teaser TEXT NULL,
    body MEDIUMTEXT NOT NULL,
    published_at DATETIME NOT NULL,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_news_lang_slug (lang, slug),
    INDEX idx_news_lang_published (lang, is_published, published_at),
    FULLTEXT KEY ft_news_search (title, teaser, body)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE travel_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lang CHAR(2) NOT NULL DEFAULT 'de',
    title VARCHAR(180) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    image_path VARCHAR(255) NULL,
    location VARCHAR(180) NULL,
    starts_on DATE NULL,
    ends_on DATE NULL,
    status ENUM('planned','completed','archived') NOT NULL DEFAULT 'planned',
    teaser TEXT NULL,
    cta_label VARCHAR(80) NULL,
    legacy_pdf_url VARCHAR(500) NULL,
    legacy_pdf_path VARCHAR(255) NULL,
    body MEDIUMTEXT NOT NULL,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_travel_lang_slug (lang, slug),
    INDEX idx_travel_lang_published (lang, is_published, starts_on),
    FULLTEXT KEY ft_travel_search (title, teaser, body)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE site_settings (
  setting_key VARCHAR(80) PRIMARY KEY,
  setting_value TEXT NOT NULL,
  updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

