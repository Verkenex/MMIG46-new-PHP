# MMIG46 e.V. – Website

Produktive Vereinswebsite der **Malibu/Meridian Interest Group 46 e.V.** für Betreiber, Piloten und Interessierte der Piper-PA-46-Baureihe.

Die Anwendung ist eine serverseitig gerenderte PHP-/MariaDB-Website mit deutsch- und englischsprachigem Frontend, Nachrichten- und Reiseinhalten, Mitgliederbereich, Forum, Verwaltungsbereich, Kontakt- und Anmeldeformularen sowie einem übernommenen Malibu-Mirage-Facharchiv.

## Status

Die Website befindet sich im produktiven Einsatz.

Die Anwendung wurde für den Betrieb bei **ALL-INKL / KAS** entwickelt. Das öffentliche Webroot ist `public/`. Alternativ kann die Domain auf das Projektwurzelverzeichnis zeigen; die dortige `.htaccess` leitet Anfragen intern an `public/` weiter und schützt nicht öffentliche Projektdateien.

## Technischer Stack

* PHP 8.1 oder neuer
* MariaDB / MySQL
* Apache mit `mod_rewrite`
* Composer
* PHPMailer für SMTP-Mailversand
* Parsedown für Markdown-Inhalte
* Eigenes MVC-orientiertes PHP-System
* Serverseitig gerenderte PHP-Views
* HTML, CSS und Vanilla JavaScript
* PSR-4-Autoloading mit dem Namespace `MMIG46\`

Die Composer-Anforderungen stehen in:

```text
composer.json
```

Installierte PHP-Pakete:

```text
phpmailer/phpmailer
erusev/parsedown
```

## Hauptfunktionen

### Öffentlicher Bereich

* deutsch- und englischsprachige Website
* Startseite
* Aktuelles- und Newsübersicht
* dynamische Newsdetailseiten
* Reise- und Fly-in-Übersicht
* dynamische Reisedetailseiten
* statischer Rückblick zum Fly-in Wörthersee 2026
* Vereinsseite
* Satzung
* Informationen zur Piper Malibu, Mirage, Meridian und weiteren PA-46-Modellen
* Kontaktformular
* Mitgliedsantrag
* Trainingswochenende 2026 mit Online-Anmeldung
* Impressum
* Datenschutz
* Allgemeine Geschäftsbedingungen
* deutsch- und englischsprachige Suche

### Malibu-Mirage-Archiv

Das Repository enthält ein übernommenes Facharchiv mit historischen und technischen Inhalten zur Malibu-/Mirage-Baureihe.

Relevante Bereiche:

```text
storage/malibu-archive/
public/assets/malibu-mirage/
tools/migrate-malibu-archive.php
```

Der öffentliche Einstieg erfolgt über:

```text
/malibu-mirage
```

Archivdetailseiten werden über Slugs aufgerufen:

```text
/malibu-mirage/{slug}
```

### Forum und Mitgliederbereich

* Forum öffentlich lesbar
* Erstellung neuer Themen nur für berechtigte eingeloggte Nutzer
* Antworten nur für berechtigte eingeloggte Nutzer
* geschützte Mitgliederliste
* einheitlicher Login unter `/login`
* rollenbasierte Zugriffssteuerung
* Rollen für Administratoren, Moderatoren und Mitglieder
* Markdown-Unterstützung für Forums- und Inhaltsbeiträge
* Login-Schutz gegen Brute-Force-Versuche

### Verwaltungsbereich

Der Verwaltungsbereich ist erreichbar unter:

```text
/verwaltung
```

Administratoren melden sich über den normalen Login unter `/login` an. Es gibt keinen separaten Admin-Login.

Der Verwaltungsbereich unterstützt unter anderem:

* Anlegen und Verwalten von Nutzern
* Pflege der Mitgliederliste
* Anlegen von Newsbeiträgen
* Anlegen von Reiseeinträgen
* rollenabhängige Verwaltungsrechte

### Formulare und Mailversand

Vorhandene Formulare:

* Kontaktformular
* Mitgliedsantrag
* Anmeldung zum Trainingswochenende 2026

Der Mailversand erfolgt über SMTP und PHPMailer. Die Zugangsdaten und Empfänger werden ausschließlich über die lokale `.env`-Datei konfiguriert.

## Wichtige öffentliche Routen

Die vollständige Routendefinition befindet sich in:

```text
config/routes.php
```

Zentrale Routen:

```text
/                                  Startseite
/news                              Newsübersicht
/news/{slug}                       Newsdetail
/aktuelles                         deutsche Aliasroute für News
/suche                             deutsche Suche
/search                            englische Suche
/reisen                            Reiseübersicht
/reisen/{slug}                     Reisedetail
/reisen/fly-in-woerthersee-2026    statischer Wörthersee-Rückblick
/malibu-mirage                     Malibu-/Mirage-Bereich
/malibu-mirage/{slug}              Malibu-Archivdetail
/verein                            Verein
/satzung                           Satzung
/kontakt                           Kontaktformular
/mitgliedsantrag                   Mitgliedsantrag
/trainingswochenende-2026          Veranstaltungsseite
/forum                             Forum
/mitglieder                        Mitgliederliste
/memberlist                        Aliasroute der Mitgliederliste
/login                             Login
/verwaltung                        Verwaltungsbereich
/impressum                         Impressum
/datenschutz                       Datenschutz
/agb                               Allgemeine Geschäftsbedingungen
/robots.txt                        dynamisch erzeugte robots.txt
/sitemap.xml                       dynamisch erzeugte XML-Sitemap
```

Die Anmeldung zum Trainingswochenende wird gesendet an:

```text
POST /trainingswochenende-2026/anmeldung
```

## Projektstruktur

```text
MMIG46-new-PHP/
├── app/
│   ├── Controllers/
│   │   ├── AdminController.php
│   │   ├── AuthController.php
│   │   ├── ForumController.php
│   │   ├── MemberController.php
│   │   ├── PageController.php
│   │   └── SeoController.php
│   │
│   ├── Core/
│   │   ├── DB.php
│   │   ├── Database.php
│   │   ├── Env.php
│   │   ├── I18n.php
│   │   ├── Router.php
│   │   ├── Security.php
│   │   ├── Seo.php
│   │   ├── Session.php
│   │   └── View.php
│   │
│   ├── Models/
│   │   ├── ContentPage.php
│   │   ├── ForumPost.php
│   │   ├── ForumTopic.php
│   │   ├── Member.php
│   │   ├── NewsItem.php
│   │   ├── Search.php
│   │   ├── SiteSetting.php
│   │   ├── Travelitem.php
│   │   └── User.php
│   │
│   ├── Services/
│   │   ├── Mailer.php
│   │   └── Markdown.php
│   │
│   ├── Views/
│   │   ├── admin/
│   │   ├── auth/
│   │   ├── errors/
│   │   ├── forum/
│   │   ├── layouts/
│   │   ├── memberlist/
│   │   └── pages/
│   │
│   └── bootstrap.php
│
├── config/
│   └── routes.php
│
├── database/
│   ├── patches/
│   │   ├── archive/
│   │   └── 2026_woerthersee_static_cleanup.sql
│   ├── README.md
│   ├── forum.sql
│   ├── schema.sql
│   ├── seed_admin.sql
│   ├── seed_demo.sql
│   ├── seed_forum.sql
│   └── seed_live.sql
│
├── docs/
│   ├── INSTALLATION_ALL_INKL_KAS.md
│   ├── OPERATIONS.md
│   ├── SECURITY.md
│   └── USER_AND_CONTENT_MANAGEMENT.md
│
├── public/
│   ├── assets/
│   │   ├── css/
│   │   ├── img/
│   │   ├── js/
│   │   ├── malibu-mirage/
│   │   └── reisen/
│   ├── .htaccess
│   └── index.php
│
├── storage/
│   ├── logs/
│   ├── malibu-archive/
│   └── uploads/
│
├── tools/
│   ├── migrate-malibu-archive.php
│   └── reset_local_db.sh
│
├── .env.example
├── .gitignore
├── .htaccess
├── composer.json
├── composer.lock
└── README.md
```

Hinweis: Git speichert keine leeren Verzeichnisse. Einzelne Unterordner können deshalb über Platzhalterdateien im Repository gehalten werden.

## Verantwortlichkeiten der wichtigsten Verzeichnisse

### `app/Controllers/`

Verarbeitet HTTP-Anfragen, validiert Eingaben und verbindet Routen, Modelle, Services und Views.

### `app/Core/`

Enthält die technische Basis der Anwendung:

* Datenbankverbindung
* Umgebungsvariablen
* Router
* Sessions
* Sicherheitsfunktionen
* Internationalisierung
* View-Rendering
* SEO-Hilfsfunktionen

### `app/Models/`

Enthält Datenbankzugriffe und fachliche Datenmodelle für:

* Nutzer
* Mitglieder
* News
* Reisen
* Forum
* Suche
* Inhaltsseiten
* Website-Einstellungen

### `app/Services/`

Enthält wiederverwendbare Dienste für:

* SMTP-Mailversand
* Markdown-Verarbeitung

### `app/Views/`

Enthält die serverseitig gerenderten PHP-Templates. Die öffentlichen Seiten liegen überwiegend unter:

```text
app/Views/pages/
```

Das gemeinsame Seitenlayout liegt unter:

```text
app/Views/layouts/
```

### `public/`

Einziges öffentlich vorgesehenes Webroot.

Enthält:

* Frontcontroller `index.php`
* Rewrite-Konfiguration
* Stylesheets
* JavaScript
* Bilder
* Dokumente und statische Assets

### `storage/`

Nicht öffentlich vorgesehene Anwendungsdaten:

* Logs
* Uploads
* importierte Malibu-Archivdaten

### `database/`

Enthält das aktuelle Schema, Live- und Demo-Seeds, Forumdaten sowie nachträgliche Datenbank-Patches.

### `tools/`

Enthält lokale Wartungs- und Migrationstools. Diese Dateien sind nicht als öffentliche Web-Endpunkte vorgesehen.

## Lokale Installation

### 1. Repository öffnen

```bash
cd MMIG46-new-PHP
```

### 2. Umgebungsdatei erstellen

```bash
cp .env.example .env
```

Danach die Werte in `.env` an die lokale Umgebung anpassen.

Beispiel:

```dotenv
APP_ENV=local
APP_URL=http://localhost:8000
APP_KEY=change-this-to-a-long-random-value

DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=mmig46_local
DB_USER=root
DB_PASS=
DB_CHARSET=utf8mb4

MAIL_DRIVER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM=no-reply@example.com
MAIL_FROM_NAME="MMIG46"
CONTACT_TO=info@example.com

SESSION_NAME=mmig46_session
```

Die in `.env.example` enthaltenen lokalen Datenbankwerte sind lediglich Beispielwerte und müssen zur eigenen MySQL- oder MariaDB-Installation passen.

### 3. Composer-Abhängigkeiten installieren

```bash
composer install
```

### 4. Datenbank anlegen

Beispiel:

```bash
mysql -u root -p -e "CREATE DATABASE mmig46_local CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 5. Datenbank importieren

Für eine lokale Testinstallation:

```bash
mysql -u root -p mmig46_local < database/schema.sql
mysql -u root -p mmig46_local < database/seed_demo.sql
```

Je nach gewünschtem Testumfang können anschließend zusätzliche Forumdaten importiert werden:

```bash
mysql -u root -p mmig46_local < database/seed_forum.sql
```

Alternativ steht für lokale Umgebungen das Hilfsskript zur Verfügung:

```bash
bash tools/reset_local_db.sh
```

Vor der Verwendung muss geprüft werden, ob die im Skript verwendeten lokalen Datenbankdaten zur eigenen Umgebung passen.

### 6. Lokalen PHP-Server starten

```bash
php -S localhost:8000 -t public
```

Anschließend:

```text
http://localhost:8000
```

## Produktive Installation

### Composer installieren

```bash
composer install --no-dev --optimize-autoloader
```

Falls Composer auf dem Webhosting nicht zur Verfügung steht, muss der lokal erzeugte Ordner `vendor/` mit hochgeladen werden.

### Datenbank importieren

Für eine neue produktive Installation:

```bash
mysql -u USER -p DATENBANK < database/schema.sql
mysql -u USER -p DATENBANK < database/seed_live.sql
mysql -u USER -p DATENBANK < database/seed_admin.sql
```

`database/seed_demo.sql` darf nicht in die produktive Datenbank importiert werden.

Ob `database/seed_forum.sql` zusätzlich importiert werden soll, hängt davon ab, ob die darin enthaltenen Forumdaten benötigt werden. Vor einem Import ist der Inhalt der Datei zu prüfen.

### Datenbank-Patches

Nachträgliche Änderungen befinden sich unter:

```text
database/patches/
```

Patches dürfen nur angewendet werden, wenn sie für den jeweiligen Datenbankstand erforderlich sind.

Vor jedem Patch:

```bash
mysqldump -u USER -p DATENBANK > backup-vor-patch.sql
```

Danach beispielsweise:

```bash
mysql -u USER -p DATENBANK < database/patches/2026_woerthersee_static_cleanup.sql
```

Patches unter:

```text
database/patches/archive/
```

sind archivierte oder bereits eingeordnete Migrationen und dürfen nicht pauschal erneut ausgeführt werden.

## ALL-INKL-/KAS-Deployment

Bevorzugtes Domainziel:

```text
/PFAD/ZUM/PROJEKT/public
```

Damit bleiben folgende Bereiche außerhalb des öffentlich erreichbaren Webroots:

```text
app/
config/
database/
docs/
storage/
tools/
vendor/
.env
```

Falls die Domain auf das Projektwurzelverzeichnis zeigt, übernimmt die Root-Datei:

```text
.htaccess
```

die interne Weiterleitung an `public/`.

Für den produktiven Betrieb müssen mindestens folgende Punkte erfüllt sein:

* PHP 8.1 oder neuer
* HTTPS aktiviert
* `mod_rewrite` aktiv
* `.env` vorhanden und nicht öffentlich abrufbar
* `vendor/` vorhanden
* `storage/` für den PHP-Prozess beschreibbar
* korrekte Datenbankzugangsdaten
* korrekte SMTP-Zugangsdaten
* produktive `APP_URL`
* ausreichend langer zufälliger `APP_KEY`

Weitere Hinweise:

```text
docs/INSTALLATION_ALL_INKL_KAS.md
docs/OPERATIONS.md
docs/SECURITY.md
```

## Umgebungsvariablen

Die Vorlage befindet sich unter:

```text
.env.example
```

Wichtige Variablen:

| Variable          | Funktion                                           |
| ----------------- | -------------------------------------------------- |
| `APP_ENV`         | Umgebung, beispielsweise `local` oder `production` |
| `APP_URL`         | kanonische Basis-URL                               |
| `APP_KEY`         | anwendungsinterner geheimer Schlüssel              |
| `DB_HOST`         | Datenbankserver                                    |
| `DB_PORT`         | Datenbankport                                      |
| `DB_NAME`         | Datenbankname                                      |
| `DB_USER`         | Datenbankbenutzer                                  |
| `DB_PASS`         | Datenbankpasswort                                  |
| `DB_CHARSET`      | Datenbankzeichensatz                               |
| `MAIL_DRIVER`     | Mailtreiber                                        |
| `MAIL_HOST`       | SMTP-Server                                        |
| `MAIL_PORT`       | SMTP-Port                                          |
| `MAIL_ENCRYPTION` | SMTP-Verschlüsselung                               |
| `MAIL_USERNAME`   | SMTP-Benutzer                                      |
| `MAIL_PASSWORD`   | SMTP-Passwort                                      |
| `MAIL_FROM`       | Absenderadresse                                    |
| `MAIL_FROM_NAME`  | Absendername                                       |
| `CONTACT_TO`      | Empfänger für Kontaktanfragen                      |
| `SESSION_NAME`    | Name des Session-Cookies                           |

Reale Zugangsdaten dürfen niemals in Git eingecheckt werden.

## Sicherheitsfunktionen

Die Anwendung enthält unter anderem:

* CSRF-Schutz für POST-Anfragen
* serverseitige Eingabevalidierung
* Prepared Statements beziehungsweise gebundene SQL-Parameter
* Passwort-Hashes
* rollenbasierte Zugriffskontrolle
* geschützte Verwaltungsrouten
* Login-Brute-Force-Schutz
* Session-Cookies
* geschützte Konfigurations- und Quelldateien
* Trennung von öffentlichem Webroot und Anwendungscode
* dynamische `robots.txt`
* dynamische XML-Sitemap

Sicherheitsrelevante Änderungen müssen mit folgender Dokumentation abgeglichen werden:

```text
docs/SECURITY.md
```

## Inhalte und Datenhaltung

Dynamische Inhalte werden unter anderem in MariaDB gespeichert:

* Nutzer
* Mitglieder
* News
* Reisen
* Forenthemen
* Forenbeiträge
* Kontaktanfragen
* Website-Einstellungen
* Login-Versuche
* gegebenenfalls verwaltete Inhaltsseiten

Ein Teil der Kernseiten wird dagegen direkt als PHP-View gepflegt. Deshalb darf nicht davon ausgegangen werden, dass sämtliche Website-Inhalte ausschließlich aus der Tabelle `content_pages` stammen.

Vor Änderungen ist jeweils zu prüfen, ob der konkrete Inhalt aus:

```text
app/Views/
database/
storage/malibu-archive/
```

oder aus einer Datenbanktabelle stammt.

## Inhaltspflege

### Statische Seiten

Überwiegend unter:

```text
app/Views/pages/
```

### Gemeinsames Layout und Navigation

Unter:

```text
app/Views/layouts/
```

### Routen

Unter:

```text
config/routes.php
```

### Stylesheets

Unter:

```text
public/assets/css/
```

### JavaScript

Unter:

```text
public/assets/js/
```

### Bilder und weitere öffentliche Dateien

Unter:

```text
public/assets/img/
public/assets/malibu-mirage/
public/assets/reisen/
```

### Dynamische News- und Reiseinhalte

Über die entsprechenden Datenbanktabellen beziehungsweise den Verwaltungsbereich unter:

```text
/verwaltung
```

## Deployment- und Änderungsworkflow

Vor Änderungen an der Live-Seite:

1. Repository aktualisieren.
2. Datenbankbackup erstellen.
3. Dateien lokal ändern.
4. PHP-Syntax prüfen.
5. Anwendung lokal testen.
6. Änderungen committen.
7. geänderte Dateien auf den Server übertragen.
8. notwendige Datenbank-Patches gezielt ausführen.
9. Cache und Browseransicht prüfen.
10. Kontakt-, Login- und Formularfunktionen testen.

PHP-Syntaxprüfung aller PHP-Dateien:

```bash
find app config public tools -name "*.php" -print0 | xargs -0 -n1 php -l
```

## Nach einem Deployment prüfen

Mindestens folgende Seiten und Funktionen testen:

```text
/
/news
/reisen
/malibu-mirage
/verein
/satzung
/kontakt
/mitgliedsantrag
/trainingswochenende-2026
/forum
/login
/verwaltung
/suche
/search
/robots.txt
/sitemap.xml
```

Zusätzlich prüfen:

* deutscher und englischer Sprachmodus
* mobile Navigation
* Newsdetailseiten
* Reisedetailseiten
* Malibu-Archivdetailseiten
* Kontaktversand
* Bestätigungsmails
* Mitgliedsantrag
* Anmeldung zum Trainingswochenende
* Login und Logout
* Mitgliederliste
* Forumsberechtigungen
* Verwaltungsbereich
* Bilder und PDF-Dateien
* kanonische URLs und Weiterleitungen

## Dokumentation

```text
docs/INSTALLATION_ALL_INKL_KAS.md
docs/OPERATIONS.md
docs/SECURITY.md
docs/USER_AND_CONTENT_MANAGEMENT.md
database/README.md
```

Bei Widersprüchen zwischen Dokumentation und Anwendungscode gilt der tatsächlich auf dem Branch `main` vorhandene Code als maßgeblich. Die Dokumentation muss anschließend an den Code angeglichen werden.

## Repository-Regeln

Nicht committen:

```text
.env
reale Passwörter
SMTP-Zugangsdaten
Datenbankzugangsdaten
ungeprüfte Produktions-Dumps
personenbezogene Exportdateien
Logdateien mit personenbezogenen Informationen
```

Änderungen an Datenbank, Routen oder Deploymentstruktur müssen gleichzeitig in dieser README und gegebenenfalls in den Dateien unter `docs/` dokumentiert werden.
