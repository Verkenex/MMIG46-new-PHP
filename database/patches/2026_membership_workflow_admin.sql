-- Einmalige Migration: sicherer Antrag-/Freigabeablauf und Benutzerzuordnung.
-- Vor der Ausführung vollständiges Datenbank-Backup erstellen.

ALTER TABLE members
  ADD COLUMN user_id INT UNSIGNED NULL AFTER id,
  ADD COLUMN application_id INT UNSIGNED NULL AFTER user_id,
  ADD COLUMN status ENUM('pending','active','rejected') NOT NULL DEFAULT 'active' AFTER application_id,
  ADD COLUMN public_consent_at DATETIME NULL AFTER is_public,
  ADD COLUMN updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP AFTER created_at,
  ADD UNIQUE KEY uq_members_user_id (user_id),
  ADD UNIQUE KEY uq_members_application_id (application_id),
  ADD INDEX idx_members_status (status),
  ADD CONSTRAINT fk_members_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  ADD CONSTRAINT fk_members_application FOREIGN KEY (application_id) REFERENCES membership_applications(id) ON DELETE SET NULL;

-- Bestehende, bereits ausdrücklich öffentlich geführte Datensätze bleiben sichtbar.
-- Für neue Datensätze ist eine gesonderte Admin-Bestätigung zwingend.
UPDATE members SET public_consent_at = COALESCE(created_at, NOW()) WHERE is_public = 1;

ALTER TABLE membership_applications
  ADD COLUMN language CHAR(2) NOT NULL DEFAULT 'de' AFTER id,
  ADD COLUMN idempotency_hash CHAR(64) NULL AFTER language,
  ADD COLUMN duplicate_hash CHAR(64) NULL AFTER idempotency_hash,
  ADD COLUMN status ENUM('pending','manual_review','approved','rejected','cancelled') NOT NULL DEFAULT 'pending' AFTER duplicate_hash,
  ADD COLUMN conflict_reason VARCHAR(255) NULL AFTER status,
  ADD COLUMN board_confirmed_at DATETIME NULL,
  ADD COLUMN board_confirmed_by INT UNSIGNED NULL,
  ADD COLUMN payment_confirmed_at DATETIME NULL,
  ADD COLUMN payment_confirmed_by INT UNSIGNED NULL,
  ADD COLUMN decided_at DATETIME NULL,
  ADD COLUMN decided_by INT UNSIGNED NULL,
  ADD COLUMN updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP AFTER created_at,
  ADD INDEX idx_membership_applications_status (status, created_at),
  ADD CONSTRAINT fk_applications_board_admin FOREIGN KEY (board_confirmed_by) REFERENCES users(id) ON DELETE SET NULL,
  ADD CONSTRAINT fk_applications_payment_admin FOREIGN KEY (payment_confirmed_by) REFERENCES users(id) ON DELETE SET NULL,
  ADD CONSTRAINT fk_applications_deciding_admin FOREIGN KEY (decided_by) REFERENCES users(id) ON DELETE SET NULL;

-- Bestehende Anträge erhalten stabile, untereinander eindeutige Legacy-Schlüssel.
UPDATE membership_applications
SET idempotency_hash = SHA2(CONCAT('legacy-idempotency-', id), 256),
    duplicate_hash = SHA2(CONCAT('legacy-duplicate-', id), 256)
WHERE idempotency_hash IS NULL OR duplicate_hash IS NULL;

ALTER TABLE membership_applications
  MODIFY idempotency_hash CHAR(64) NOT NULL,
  MODIFY duplicate_hash CHAR(64) NOT NULL,
  ADD UNIQUE KEY uq_membership_applications_idempotency (idempotency_hash),
  ADD UNIQUE KEY uq_membership_applications_duplicate (duplicate_hash);

CREATE TABLE mail_outbox (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  message_type VARCHAR(50) NOT NULL,
  recipient VARCHAR(190) NOT NULL,
  subject VARCHAR(255) NOT NULL,
  payload_json LONGTEXT NOT NULL,
  related_type VARCHAR(50) NULL,
  related_id INT UNSIGNED NULL,
  dedupe_key VARCHAR(190) NOT NULL,
  status ENUM('pending','sending','sent','failed') NOT NULL DEFAULT 'pending',
  attempts SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  last_error VARCHAR(1000) NULL,
  available_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  sent_at DATETIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_mail_outbox_dedupe (dedupe_key),
  INDEX idx_mail_outbox_delivery (status, available_at),
  INDEX idx_mail_outbox_related (related_type, related_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
