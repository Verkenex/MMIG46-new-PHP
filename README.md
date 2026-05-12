# MMIG46 PHP/MariaDB Modernized

Produktionsnahe Neuimplementierung der MMIG46-Website fuer all-inkl/KAS mit PHP, MariaDB, Forum, Memberlist, Kontaktformular, Adminbereich und modernem Mobile-First-Frontend.

## Zielstack

- PHP 8.1 oder hoeher, empfohlen: PHP 8.3/8.4, sobald im KAS verfuegbar
- MariaDB 10.11.x
- Apache mit `.htaccess` und `mod_rewrite`
- Composer fuer PHPMailer und Parsedown
- SMTP ueber `w019cf33.kasserver.com:465` mit SSL

## Struktur

```text
app/                 PHP-App: Controller, Core, Models, Services, Views
config/routes.php    Routen
public/              Webroot: index.php, CSS, JS, .htaccess
database/install.sql Schema
database/seeds/      Einmalige Beispieldaten
docs/                Betrieb, Sicherheit, Deployment
.env.example         Vorlage fuer Zugangsdaten
```

## Designprinzip

Das Frontend ist bewusst nicht mehr Next.js/React-basiert. Die Kernlogik laeuft serverseitig ueber PHP und MariaDB. JavaScript wird nur fuer Mobile-Menue und Cookie-Hinweis eingesetzt.

## Funktionen

- Startseite, News, Reisen, Verein, Kontakt, Impressum, Datenschutz, AGB
- Forum: oeffentlich lesbar, Schreiben nur fuer `admin`, `moderator`, `member`
- Memberlist: oeffentliche Liste plus Adminpflege
- Adminbereich unter `/verwaltung`
- Kontaktformular mit Captcha und SQL-Protokollierung
- CSRF-Schutz fuer POST-Formulare
- Login-Bruteforce-Schutz
- Browser-Session-Cookies
- Markdown-Ausgabe fuer Forenbeitraege

## Schnelle lokale Installation

```bash
cp .env.example .env
composer install
php -S localhost:8000 -t public
```

Datenbank lokal anlegen und danach importieren:

```bash
mysql -u USER -p DATENBANK < database/install.sql
mysql -u USER -p DATENBANK < database/seeds/demo.sql
```

## Demo-Login

Die Seed-Datei enthaelt absichtlich nur minimale Beispieldaten. Das Demo-Passwort steht in `database/seeds/demo.sql` und muss nach dem Livegang ersetzt werden.

## Wichtig vor Livegang

1. `.env` aus `.env.example` erstellen.
2. `APP_KEY`, `DB_PASS`, `MAIL_PASSWORD` setzen.
3. Demo-User loeschen oder Passwort aendern.
4. KAS-Zielverzeichnis idealerweise auf `/public` zeigen lassen.
5. SSL aktiv lassen und PHP-Version auf mindestens 8.1 setzen.

Ausfuehrliche Anleitung: `docs/INSTALLATION_ALL_INKL_KAS.md`.
