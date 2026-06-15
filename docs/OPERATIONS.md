# Betrieb

## Grundprinzip

Die Website laeuft als serverseitige PHP/MariaDB-Anwendung. Inhalte werden nicht mehr an mehreren voneinander getrennten Stellen gepflegt, sondern ueber die vorhandenen Datenbanktabellen und Adminfunktionen verwaltet.

Fuehrende Datenquellen:

- `content_pages`: statische Inhaltsseiten wie Verein, Impressum, Datenschutz und AGB
- `news_items`: Aktuelles/News und Artikeldetailseiten
- `users`: Login-Nutzer und Rollen
- `members`: oeffentliche Memberlist
- `forum_threads` und `forum_posts`: Forum
- `contact_messages`: Kontaktanfragen

## Login und Verwaltung

Der Einstieg erfolgt immer ueber `/login`.

Es gibt keinen separaten sichtbaren Admin-Login. Admins melden sich normal ueber `/login` an und erhalten danach automatisch Zugriff auf die internen Verwaltungsfunktionen.

Die technische Route `/verwaltung` kann intern bestehen bleiben, darf aber in der sichtbaren Navigation nicht als eigener Menuepunkt erscheinen. Sichtbar soll nur ein Login-Feld bzw. Login-Button mit Zahnrad sein.

## Normale Bearbeitung

Dynamisch gepflegt werden:

- News/Artikel
- Forumbeitraege
- Mitgliederliste
- Kontaktanfragen
- Nutzer/Accounts

Statische Inhaltsseiten wie Verein, Impressum, Datenschutz und AGB sollen primaer ueber `content_pages` bzw. die Seed-Dateien in `database/seeds/` gepflegt werden. PHP-View-Dateien unter `app/Views/pages/` sind nur dann direkt zu aendern, wenn es sich um echte Layout- oder Formularseiten handelt.

## News und Aktuelles

News werden in der Tabelle `news_items` gespeichert.

Erwartete Felder:

- `title`: sichtbarer Titel
- `slug`: URL-Teil, eindeutig, z. B. `fly-in-woerthersee-2026`
- `teaser`: Kurztext fuer Uebersichtsseiten
- `body`: vollstaendiger Artikeltext, Markdown erlaubt
- `category`: Kategorie oder Rubrik
- `image_path`: optionaler Bildpfad
- `published_at`: Veroeffentlichungszeitpunkt
- `is_published`: `1` fuer sichtbar, `0` fuer offline

Die Uebersicht `/news` muss auf die jeweiligen Detailseiten verlinken. Das erwartete URL-Schema ist:

```text
/news/<slug>
```

Beispiel:

```text
/news/fly-in-woerthersee-2026
```

## Mitgliedsantrag

Der Mitgliedsantrag wird als eigene Seite bereitgestellt:

```text
/mitgliedsantrag
```

Anforderungen:

- digital ausfuellbar
- per Browser-Druckfunktion ausdruckbar
- ueber den Button auf der Seite `/verein` erreichbar
- Pflichtfelder serverseitig validieren
- CSRF-Schutz verwenden
- keine sensiblen Daten ungeschuetzt in oeffentlichen Dateien ablegen

## Rechtstexte und Vereinsdaten

Impressum, Datenschutz, AGB und Verein-Content sollen mit den Daten der aktuellen MMIG46-Website abgeglichen werden.

Primaer zu aendernde Dateien:

```text
database/seeds/final_content.sql
database/seeds/design_content.sql
```

Betroffene Slugs:

```text
verein
impressum
datenschutz
agb
```

Nach einer Inhaltsaenderung muss lokal und auf KAS geprueft werden, ob die Datenbank tatsaechlich aktualisiert wurde. Bereits importierte Seeds ueberschreiben bestehende Inhalte nicht automatisch, sofern kein `ON DUPLICATE KEY UPDATE` oder manueller SQL-Import genutzt wird.

## Backups

Vor jedem Release:

1. Projektordner sichern.
2. Datenbank exportieren.
3. `.env` separat sichern.
4. Keine ZIP-, SQL- oder Backup-Dateien im oeffentlichen Webroot ablegen.

Empfohlene Backup-Dateinamen:

```text
backup-mmig46-files-YYYY-MM-DD.zip
backup-mmig46-db-YYYY-MM-DD.sql
```

## Release-Pruefung

Vor dem Livegang pruefen:

- `/` Startseite
- `/news` News-Uebersicht
- `/news/<slug>` Artikeldetailseite
- `/mitgliedsantrag` digitales und druckbares Formular
- `/verein` Button zum Mitgliedsantrag
- `/login` einheitlicher Login
- Admin-Login fuehrt zu erweiterten Verwaltungsrechten
- Kein sichtbarer Menuepunkt `Verwaltung`
- `/forum` oeffentlich lesbar
- Schreiben im Forum nur mit passender Rolle
- `/kontakt` Captcha, SQL-Speicherung und Mailversand
- `/memberlist` oeffentliche Liste
- `/impressum`, `/datenschutz`, `/agb` mit aktuellen Daten
- SSL-Weiterleitung
- Keine direkte Abrufbarkeit von `/.env`, `/composer.json`, `/database/install.sql`
