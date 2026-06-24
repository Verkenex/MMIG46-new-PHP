CREATE TABLE IF NOT EXISTS users (
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

CREATE TABLE IF NOT EXISTS members (
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

CREATE TABLE IF NOT EXISTS forum_topics (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  title VARCHAR(180) NOT NULL,
  slug VARCHAR(220) NOT NULL,
  is_pinned TINYINT(1) NOT NULL DEFAULT 0,
  is_locked TINYINT(1) NOT NULL DEFAULT 0,
  is_public TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_forum_topics_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  UNIQUE KEY uq_forum_topic_slug (slug),
  INDEX idx_forum_topics_created (created_at),
  INDEX idx_forum_topics_pinned (is_pinned, created_at),
  FULLTEXT KEY ft_forum_topics_search (title)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS forum_posts (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  topic_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  body MEDIUMTEXT NOT NULL,
  is_deleted TINYINT(1) NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_forum_posts_topic FOREIGN KEY (topic_id) REFERENCES forum_topics(id) ON DELETE CASCADE,
  CONSTRAINT fk_forum_posts_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_forum_posts_topic_created (topic_id, created_at),
  FULLTEXT KEY ft_forum_posts_search (body)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_requests (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  email VARCHAR(190) NOT NULL,
  message MEDIUMTEXT NOT NULL,
  ip_address VARCHAR(64) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  handled_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS login_attempts (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(190) NULL,
  ip_address VARCHAR(64) NOT NULL,
  success TINYINT(1) NOT NULL DEFAULT 0,
  attempted_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_login_ip_time (ip_address, attempted_at),
  INDEX idx_login_email_time (email, attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS content_pages (
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

CREATE TABLE IF NOT EXISTS news_items (
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

CREATE TABLE IF NOT EXISTS travel_items (
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

CREATE TABLE IF NOT EXISTS site_settings (
  setting_key VARCHAR(80) PRIMARY KEY,
  setting_value TEXT NOT NULL,
  updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS membership_applications (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    membership_type VARCHAR(100) NULL,

    invoice_name VARCHAR(255) NOT NULL,
    street VARCHAR(255) NOT NULL,
    postal_city_country VARCHAR(255) NOT NULL,

    last_name VARCHAR(150) NOT NULL,
    first_name VARCHAR(150) NOT NULL,
    birthday VARCHAR(50) NULL,
    occupation VARCHAR(255) NULL,
    copilot_spouse VARCHAR(255) NULL,

    total_time VARCHAR(100) NULL,
    time_in_type VARCHAR(100) NULL,
    license_ratings TEXT NULL,
    flying_since VARCHAR(100) NULL,
    aviation_history TEXT NULL,

    registered_owner VARCHAR(255) NULL,
    callsign VARCHAR(100) NULL,
    model VARCHAR(150) NULL,
    serial_number VARCHAR(150) NULL,
    aircraft_year VARCHAR(50) NULL,
    modifications TEXT NULL,
    home_base VARCHAR(255) NULL,

    office_phone VARCHAR(100) NULL,
    office_email VARCHAR(255) NULL,
    home_phone VARCHAR(100) NULL,
    private_email VARCHAR(255) NOT NULL,
    mobile VARCHAR(100) NOT NULL,

    consent TINYINT(1) NOT NULL DEFAULT 0,

    ip_address VARCHAR(64) NULL,
    payload_json LONGTEXT NULL,

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_membership_applications_created_at (created_at),
    INDEX idx_membership_applications_private_email (private_email),
    INDEX idx_membership_applications_last_name (last_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
