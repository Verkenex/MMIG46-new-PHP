# Installation bei all-inkl / KAS

## 1. Empfohlene Domain-Zuordnung

Empfohlen ist, die Domain im KAS direkt auf das Verzeichnis `public` zeigen zu lassen, z. B.:

```text
/www/htdocs/w019cf33/mmig46.de/mmig46-new/public
```

Dann sind `app/`, `config/`, `database/`, `.env` und `vendor/` nicht direkt aus dem Web erreichbar.

Falls das im KAS nicht gewuenscht oder nicht moeglich ist, kann die Domain auf das Projektwurzelverzeichnis zeigen. Die mitgelieferte Root-`.htaccess` leitet intern auf `public/` um und sperrt kritische Dateien.

Die sauberere Variante bleibt:

```text
Domainziel = public
```

Hinweis: Bei all-inkl ist typischerweise `/www/htdocs/...` korrekt.

## 2. Upload per FTP/SFTP

1. ZIP lokal entpacken.
2. `.env.example` zu `.env` kopieren.
3. Zugangsdaten in `.env` eintragen.
4. Lokal ausfuehren:

   ```bash
   composer install --no-dev --optimize-autoloader
   ```

5. Das gesamte Projekt inklusive `vendor/` hochladen.
6. Rechte pruefen:
   - `storage/` beschreibbar
   - `public/` lesbar
   - `.env` nicht oeffentlich abrufbar

## 3. Composer

Composer verwaltet externe PHP-Pakete:

- `phpmailer/phpmailer`: SMTP-Mailversand
- `erusev/parsedown`: Markdown-Ausgabe

Falls SSH/Composer direkt auf dem Hosting nicht verfuegbar ist, Composer lokal ausfuehren und den erzeugten Ordner `vendor/` mit hochladen.

## 4. Datenbank

Empfohlen: eine konsolidierte Datenbank, z. B.:

```text
MMIG46_Datenbank
```

Das ist effizienter als getrennte Datenbanken fuer Forum, Memberlist und Website, weil Login, Rollen, Forum, Mitglieder, News und Kontaktanfragen zusammenhaengen.

Importreihenfolge:

```bash
mysql -u d02fb2e5 -p MMIG46_Datenbank < database/install.sql
mysql -u d02fb2e5 -p MMIG46_Datenbank < database/seeds/demo.sql
mysql -u d02fb2e5 -p MMIG46_Datenbank < database/seeds/final_content.sql
```

Wenn die Datenbank im KAS anders heisst, exakt diesen Namen in `.env` eintragen.

## 5. SMTP / Mail

In `.env` eintragen:

```text
MAIL_DRIVER=smtp
MAIL_HOST=w019cf33.kasserver.com
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
MAIL_USERNAME=dr.gerecht@mmig46.org
MAIL_PASSWORD=...
MAIL_FROM=dr.gerecht@mmig46.org
CONTACT_TO="info@mmig46.org,dr.gerecht@mmig46.org"
```

SMTP ist gegenueber einfachem `mail()` vorzuziehen, weil Zustellbarkeit, Authentifizierung und Fehlerbehandlung besser kontrollierbar sind.

## 6. PHP-Version

PHP 7.4 nicht mehr verwenden.

Fuer diese Codebasis mindestens PHP 8.1 einstellen, besser PHP 8.3 oder neuer. PHP 8.5 ist nur dann zu verwenden, wenn alle Composer-Abhaengigkeiten damit sauber laufen.

## 7. Archiv `/alt`

Alte Website nicht loeschen.

Empfohlen:

```text
/www/htdocs/w019cf33/mmig46.de/alt
```

Alte Dateien dorthin verschieben. Danach im neuen Projekt keine alten SQL-Dumps oder Altdaten ablegen.

## 8. Domains

- `mmig46.org` und `mmig46.de` koennen direkt auf dieselbe `public`-Installation zeigen.
- Fuer `mmig46.com` und `mmig46.eu` empfiehlt sich eine 301-Weiterleitung auf die Hauptdomain, damit keine Duplicate-Content-Probleme entstehen.
- Hauptdomain in `.env` als `APP_URL` setzen.

## 9. Login, Nutzer und Beitraege

Der Login erfolgt immer ueber:

```text
/login
```

Admins melden sich ebenfalls ueber `/login` an. Es gibt keinen separaten sichtbaren Admin-Login. Nach erfolgreichem Login erhalten Admins Zugriff auf die interne Verwaltung.

Die Pflege von Nutzern und Beitraegen ist hier dokumentiert:

```text
docs/USER_AND_CONTENT_MANAGEMENT.md
```

Kurzfassung:

- Nutzer koennen ueber die interne Verwaltung oder ueber phpMyAdmin angelegt werden.
- Passwoerter muessen immer als Hash gespeichert werden.
- Beitraege werden in `news_items` gespeichert.
- Die News-Uebersicht `/news` verlinkt auf `/news/<slug>`.
- Rechtstexte und Inhaltsseiten werden ueber `content_pages` bzw. die Seed-Dateien gepflegt.

## 10. Nach dem Upload pruefen

Pflichtpruefung:

- `/` Startseite
- `/news` News-Uebersicht
- `/news/<slug>` Artikeldetailseite
- `/mitgliedsantrag` Formular, digital ausfuellbar und druckbar
- `/verein` Button zum Mitgliedsantrag
- `/login` einheitlicher Login
- Admin-Login fuehrt zu erweiterten Verwaltungsrechten
- Kein sichtbarer separater Menuepunkt `Verwaltung`
- `/forum` oeffentlich lesbar
- Schreiben im Forum nur fuer berechtigte Rollen
- `/kontakt` Captcha, SQL-Speicherung und Mailversand
- `/memberlist` oeffentliche Liste
- `/impressum`, `/datenschutz`, `/agb` mit aktuellen Daten
- SSL-Weiterleitung
- Keine direkte Abrufbarkeit von `/.env`, `/composer.json`, `/database/install.sql`

## 11. Produktive Nutzeranlage auf KAS

Wenn noch kein produktiver Admin existiert:

1. Lokal Passwort-Hash erzeugen:

   ```bash
   php -r "echo password_hash('NEUES_PASSWORT', PASSWORD_DEFAULT), PHP_EOL;"
   ```

2. In KAS phpMyAdmin oeffnen.
3. Produktive Datenbank auswaehlen.
4. SQL ausfuehren:

   ```sql
   INSERT INTO users (name, email, password_hash, role, email_verified_at)
   VALUES (
     'MMIG46 Admin',
     'admin@example.com',
     'HIER_DEN_HASH_EINFUEGEN',
     'admin',
     NOW()
   );
   ```

5. Danach sofort ueber `/login` testen.
6. Demo-User entfernen oder Passwort ersetzen.
