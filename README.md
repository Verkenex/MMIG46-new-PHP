# MMIG46 PHP/MariaDB Modernized

Produktionsnahe Neuimplementierung der MMIG46-Website fuer all-inkl/KAS mit PHP, MariaDB, Forum, Memberlist, Kontaktformular, Login, Rollenverwaltung, Beitragsverwaltung und modernem Mobile-First-Frontend.

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
database/seeds/      Einmalige Beispiel- und Inhaltsdaten
docs/                Betrieb, Sicherheit, Deployment, Nutzer- und Beitragsverwaltung
.env.example         Vorlage fuer Zugangsdaten
```

## Designprinzip

Das Frontend ist bewusst nicht mehr Next.js/React-basiert. Die Kernlogik laeuft serverseitig ueber PHP und MariaDB. JavaScript wird nur fuer Mobile-Menue und Cookie-Hinweis eingesetzt.

## Funktionen

- Startseite, Aktuelles/News, Reisen, Verein, Kontakt, Impressum, Datenschutz, AGB
- Klickbare News-Uebersicht mit Artikeldetailseiten
- Digitales und druckbares Mitgliedsantragsformular
- Forum: oeffentlich lesbar, Schreiben nur fuer `admin`, `moderator`, `member`
- Memberlist: oeffentliche Liste plus Adminpflege
- Einheitlicher Login unter `/login`; Admins erhalten nach dem Login erweiterte Verwaltungsrechte
- Kein separater Admin-Login in der Navigation
- Kontaktformular mit Captcha und SQL-Protokollierung
- CSRF-Schutz fuer POST-Formulare
- Login-Bruteforce-Schutz
- Browser-Session-Cookies
- Markdown-Ausgabe fuer Forenbeitraege und News-Inhalte

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
mysql -u USER -p DATENBANK < database/seeds/final_content.sql
```

## Demo-Login

Die Seed-Datei enthaelt absichtlich nur minimale Beispieldaten. Das Demo-Passwort steht in `database/seeds/demo.sql` und muss nach dem Livegang ersetzt werden.

## Wichtig vor Livegang

1. `.env` aus `.env.example` erstellen.
2. `APP_KEY`, `DB_PASS`, `MAIL_PASSWORD` setzen.
3. Demo-User loeschen oder Passwort aendern.
4. KAS-Zielverzeichnis idealerweise auf `/public` zeigen lassen.
5. SSL aktiv lassen und PHP-Version auf mindestens 8.1 setzen.
6. Rechtstexte, Verein-Content und News-Inhalte aus der aktuellen MMIG46-Website in `database/seeds/final_content.sql` pruefen.
7. Nutzer- und Beitragsverwaltung gemaess `docs/USER_AND_CONTENT_MANAGEMENT.md` pruefen.
8. Betrieb und Deployment gemaess `docs/OPERATIONS.md` und `docs/INSTALLATION_ALL_INKL_KAS.md` pruefen.

## Dokumentation

- Installation all-inkl/KAS: `docs/INSTALLATION_ALL_INKL_KAS.md`
- Betrieb und Releases: `docs/OPERATIONS.md`
- Nutzer- und Beitragsverwaltung: `docs/USER_AND_CONTENT_MANAGEMENT.md`
- Sicherheit: `docs/SECURITY.md`
