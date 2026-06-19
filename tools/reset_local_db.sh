#!/bin/sh
set -e

DB_NAME="mmig46_local"
DB_USER="root"
DB_PASS="root"
DB_HOST="localhost"
DB_PORT="8889"
DB_SOCKET="/Applications/MAMP/tmp/mysql/mysql.sock"

MYSQL="mysql --host=$DB_HOST --port=$DB_PORT --socket=$DB_SOCKET -u $DB_USER -p$DB_PASS"

echo "Dropping and recreating database: $DB_NAME"
$MYSQL -e "DROP DATABASE IF EXISTS $DB_NAME; CREATE DATABASE $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

echo "Importing database/schema.sql"
$MYSQL "$DB_NAME" < database/schema.sql

echo "Importing database/seed_admin.sql"
$MYSQL "$DB_NAME" < database/seed_admin.sql

echo "Importing database/seed_live.sql"
$MYSQL "$DB_NAME" < database/seed_live.sql

echo "Importing database/forum.sql"
$MYSQL "$DB_NAME" < database/forum.sql

echo "Done."
$MYSQL "$DB_NAME" -e "SHOW TABLES; SELECT id, name, email, role FROM users; SELECT id, title, slug FROM forum_topics;"
