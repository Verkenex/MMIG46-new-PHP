# Datenbankstruktur MMIG46

## Live-Installation

1. schema.sql importieren
2. seed_live.sql importieren
3. seed_admin.sql importieren
seed_demo.sql NICHT importieren!

```bash
mysql -u USER -p DATENBANK < database/schema.sql
mysql -u USER -p DATENBANK < database/seed_live.sql
mysql -u USER -p DATENBANK < database/seed_admin.sql