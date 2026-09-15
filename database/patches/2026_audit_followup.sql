-- Einmalige Folgemigration: wiederholbare Anträge und persistente Event-Anmeldungen.
-- Vor dem Import vollständiges Datenbank-Backup erstellen.

SET @duplicate_index_exists := (
    SELECT COUNT(*) FROM information_schema.statistics
    WHERE table_schema = DATABASE()
      AND table_name = 'membership_applications'
      AND index_name = 'uq_membership_applications_duplicate'
);
SET @drop_duplicate_index := IF(
    @duplicate_index_exists > 0,
    'ALTER TABLE membership_applications DROP INDEX uq_membership_applications_duplicate',
    'SELECT 1'
);
PREPARE audit_stmt FROM @drop_duplicate_index;
EXECUTE audit_stmt;
DEALLOCATE PREPARE audit_stmt;

SET @duplicate_lookup_exists := (
    SELECT COUNT(*) FROM information_schema.statistics
    WHERE table_schema = DATABASE()
      AND table_name = 'membership_applications'
      AND index_name = 'idx_membership_applications_duplicate'
);
SET @add_duplicate_index := IF(
    @duplicate_lookup_exists = 0,
    'ALTER TABLE membership_applications ADD INDEX idx_membership_applications_duplicate (duplicate_hash)',
    'SELECT 1'
);
PREPARE audit_stmt FROM @add_duplicate_index;
EXECUTE audit_stmt;
DEALLOCATE PREPARE audit_stmt;

CREATE TABLE IF NOT EXISTS training_registrations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    idempotency_hash CHAR(64) NOT NULL,
    language CHAR(2) NOT NULL DEFAULT 'de',
    name VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL,
    callsign VARCHAR(20) NOT NULL,
    aircraft_model VARCHAR(100) NULL,
    participants TINYINT UNSIGNED NOT NULL,
    elements_json TEXT NOT NULL,
    notes TEXT NULL,
    privacy_consent TINYINT(1) NOT NULL DEFAULT 0,
    ip_address VARCHAR(64) NULL,
    organizer_mail_status ENUM('pending','sent','failed') NOT NULL DEFAULT 'pending',
    organizer_sent_at DATETIME NULL,
    copy_mail_status ENUM('pending','sent','failed') NOT NULL DEFAULT 'pending',
    copy_sent_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_training_registration_idempotency (idempotency_hash),
    INDEX idx_training_registration_created (created_at),
    INDEX idx_training_registration_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
