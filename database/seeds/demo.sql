-- Demo-Passwort fuer beide Accounts: BitteNachLivegangAendern123
INSERT INTO users (name, email, password_hash, role, email_verified_at) VALUES
('Max Mustermann', 'max.mustermann@example.org', '$2y$10$HcfUVHh/XNE3xqcFJH6fX.HwlhZ7g8cBTmS6hlOlhc8o4/bJ5gBam', 'admin', NOW()),
('MMIG46 Mitglied', 'mitglied@example.org', '$2y$10$HcfUVHh/XNE3xqcFJH6fX.HwlhZ7g8cBTmS6hlOlhc8o4/bJ5gBam', 'member', NOW());

INSERT INTO members (name, email, aircraft, base, role_label, is_public) VALUES
('Max Mustermann', 'max.mustermann@example.org', 'Piper PA-46 Jetprop', 'EDDH', 'Mitglied', 1);

INSERT INTO forum_posts (user_id, title, body, pinned) VALUES
(1, 'Willkommen im MMIG46-Forum: Regeln und Hinweise', 'Dieses Forum ist öffentlich lesbar. Schreiben dürfen nur registrierte Vereinsmitglieder. Bitte sachlich bleiben, personenbezogene Daten vermeiden und technische Hinweise nachvollziehbar formulieren.', 1);
