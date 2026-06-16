SET NAMES utf8mb4;

DELETE FROM users
WHERE email IN (
  'max.mustermann@example.org',
  'mitglied@example.org'
);

INSERT INTO users (name, email, password_hash, role, email_verified_at)
VALUES (
  'MMIG46 Administrator',
  'info@mmig46.org',
  '$2y$12$lB/76bdO2OHteVcNzPpAXufi6li3TirV5yrdd8UYHrypjAw06CqRW',
  'admin',
  NOW()
)
ON DUPLICATE KEY UPDATE
  name = VALUES(name),
  role = VALUES(role),
  email_verified_at = VALUES(email_verified_at);