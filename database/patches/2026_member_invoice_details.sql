-- Interne Rechnungs- und Kontaktdaten für die Mitgliederverwaltung.
-- Einmalig in phpMyAdmin für die produktive MMIG46-Datenbank ausführen.
-- Die Felder werden in der öffentlichen Mitgliederliste nicht abgefragt.

ALTER TABLE members
    ADD COLUMN invoice_name VARCHAR(255) NULL AFTER website,
    ADD COLUMN street VARCHAR(255) NULL AFTER invoice_name,
    ADD COLUMN postal_code VARCHAR(20) NULL AFTER street,
    ADD COLUMN city VARCHAR(150) NULL AFTER postal_code,
    ADD COLUMN country VARCHAR(100) NULL DEFAULT 'Deutschland' AFTER city,
    ADD COLUMN phone VARCHAR(100) NULL AFTER country,
    ADD COLUMN internal_notes TEXT NULL AFTER phone;
