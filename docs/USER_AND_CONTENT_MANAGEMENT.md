# Nutzer- und Beitragsverwaltung

## Zielgruppe

Diese Anleitung ist fuer Administratoren und technische Betreuer der MMIG46-Website bestimmt. Sie beschreibt, wie Nutzer und Beitraege lokal sowie auf all-inkl/KAS erstellt und verwaltet werden.

## Rollen

Die Anwendung kennt folgende Rollen:

| Rolle | Zweck |
| --- | --- |
| `admin` | Zugriff auf Verwaltung, Nutzerpflege, Beitragsverwaltung und erweiterte Pflegefunktionen |
| `moderator` | Schreiben im Forum, keine technische Verwaltung |
| `member` | Schreiben im Forum |
| `guest` | Reservierte Rolle ohne erweiterte Rechte |

Der Login erfolgt immer ueber:

```text
/login
```

Admins verwenden denselben Login wie normale Nutzer. Nach erfolgreichem Login erhalten Admins automatisch Zugriff auf die internen Verwaltungsfunktionen.

## Nutzer lokal ueber die Website erstellen

1. Lokale Umgebung starten:

   ```bash
   php -S localhost:8000 -t public
   ```

2. Im Browser oeffnen:

   ```text
   http://localhost:8000/login
   ```

3. Mit einem Admin-Account anmelden.
4. Ueber das Login-Feld mit Zahnrad in die interne Verwaltung wechseln.
5. Im Abschnitt fuer Nutzer folgende Felder ausfuellen:
   - Name
   - E-Mail-Adresse
   - Passwort
   - Rolle
6. Speichern.
7. Mit dem neuen Account testen, ob Login und Rollenrechte korrekt funktionieren.

## Nutzer lokal per SQL erstellen

Passwort-Hash erzeugen:

```bash
php -r "echo password_hash('NEUES_PASSWORT', PASSWORD_DEFAULT), PHP_EOL;"
```

Danach den Nutzer in MariaDB anlegen:

```sql
INSERT INTO users (name, email, password_hash, role, email_verified_at)
VALUES (
  'Max Muster',
  'max@example.com',
  'HIER_DEN_HASH_EINFUEGEN',
  'admin',
  NOW()
);
```

Wichtig:

- Niemals Klartextpasswoerter in die Datenbank schreiben.
- Immer `password_hash(..., PASSWORD_DEFAULT)` verwenden.
- Fuer produktive Accounts keine Demo-Passwoerter verwenden.

## Nutzer auf all-inkl/KAS erstellen

### Variante A: ueber die Website

1. Produktive Domain oeffnen.
2. `/login` oeffnen.
3. Mit Admin-Account anmelden.
4. Ueber das Login-Feld mit Zahnrad in die interne Verwaltung wechseln.
5. Nutzer anlegen.
6. Login mit dem neuen Account testen.

### Variante B: ueber phpMyAdmin

1. In KAS einloggen.
2. Datenbankverwaltung oeffnen.
3. phpMyAdmin starten.
4. Produktive MMIG46-Datenbank auswaehlen.
5. Tabelle `users` oeffnen.
6. Neuen Datensatz einfuegen.
7. Passwort-Hash vorher mit PHP erzeugen:

   ```bash
   php -r "echo password_hash('NEUES_PASSWORT', PASSWORD_DEFAULT), PHP_EOL;"
   ```

8. Feld `email_verified_at` auf aktuellen Zeitpunkt setzen, z. B. `NOW()`.

Beispiel:

```sql
INSERT INTO users (name, email, password_hash, role, email_verified_at)
VALUES (
  'Admin MMIG46',
  'admin@example.com',
  'HIER_DEN_HASH_EINFUEGEN',
  'admin',
  NOW()
);
```

## Nutzer verwalten

Typische Verwaltungsaktionen:

| Aktion | Umsetzung |
| --- | --- |
| Rolle aendern | Feld `role` in `users` anpassen |
| Passwort zuruecksetzen | neuen Hash erzeugen und `password_hash` ersetzen |
| Nutzer deaktivieren | Rolle auf `guest` setzen oder `email_verified_at` auf `NULL` setzen |
| Nutzer loeschen | nur nach vorherigem Backup und Pruefung abhaengiger Inhalte |

Beispiel Rolle aendern:

```sql
UPDATE users
SET role = 'member'
WHERE email = 'max@example.com';
```

Beispiel Passwort ersetzen:

```sql
UPDATE users
SET password_hash = 'NEUER_HASH'
WHERE email = 'max@example.com';
```

## Beitraege ueber die Website erstellen

1. `/login` oeffnen.
2. Als Admin anmelden.
3. Ueber das Login-Feld mit Zahnrad in die interne Verwaltung wechseln.
4. Abschnitt fuer News/Beitraege oeffnen.
5. Beitrag ausfuellen:
   - Titel
   - Slug
   - Kategorie
   - Bildpfad
   - Teaser
   - Artikeltext
   - Veroeffentlichungsdatum
   - Status `veroeffentlicht`
6. Speichern.
7. Ergebnis pruefen:

   ```text
   /news
   /news/<slug>
   ```

## Beitraege per SQL erstellen

```sql
INSERT INTO news_items
(title, slug, teaser, body, category, image_path, published_at, is_published)
VALUES
(
  'Beispielartikel',
  'beispielartikel',
  'Kurzer Teaser fuer die Uebersicht.',
  'Vollstaendiger Artikeltext in Markdown.',
  'Aktuelles',
  '/assets/img/news/beispiel.jpg',
  NOW(),
  1
)
ON DUPLICATE KEY UPDATE
  title = VALUES(title),
  teaser = VALUES(teaser),
  body = VALUES(body),
  category = VALUES(category),
  image_path = VALUES(image_path),
  published_at = VALUES(published_at),
  is_published = VALUES(is_published);
```

## Beitraege aendern

Ein bestehender Beitrag wird ueber denselben `slug` aktualisiert. Der Slug ist eindeutig.

Beispiel:

```sql
UPDATE news_items
SET
  title = 'Aktualisierter Titel',
  teaser = 'Aktualisierter Teaser',
  body = 'Aktualisierter Artikeltext',
  is_published = 1
WHERE slug = 'beispielartikel';
```

## Beitraege offline nehmen

```sql
UPDATE news_items
SET is_published = 0
WHERE slug = 'beispielartikel';
```

Offline genommene Beitraege sollen in der Uebersicht und auf der Detailseite nicht sichtbar sein.

## Slug-Regeln fuer Beitraege

Ein Slug soll:

- klein geschrieben sein
- keine Umlaute enthalten
- Leerzeichen durch Bindestriche ersetzen
- keine Sonderzeichen enthalten
- dauerhaft stabil bleiben

Gut:

```text
fly-in-woerthersee-2026
```

Schlecht:

```text
Fly In Woerthersee 2026!!!
```

## Bilder fuer Beitraege

Empfohlener Ablageort:

```text
public/assets/img/news/
```

In der Datenbank wird der oeffentliche Pfad gespeichert:

```text
/assets/img/news/dateiname.jpg
```

Vor dem Livegang pruefen:

- Bild existiert im Repository oder auf dem Server.
- Pfad beginnt mit `/assets/...`.
- Bild ist fuer Webgroessen optimiert.
- Alt-Text ergibt sich mindestens aus dem Beitragstitel.

## Rechtstexte und Inhaltsseiten verwalten

Die Seiten `verein`, `impressum`, `datenschutz` und `agb` sollen ueber `content_pages` gepflegt werden.

Betroffene Seeds:

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

Bei produktiven Aenderungen muss entweder ein gezieltes SQL-Update ausgefuehrt oder der Seed mit `ON DUPLICATE KEY UPDATE` gebaut werden. Ein bereits importierter Seed aktualisiert die Datenbank nicht automatisch, wenn er nicht erneut importiert wird.

## Mitgliedsantrag verwalten

Der Mitgliedsantrag ist eine eigene Seite:

```text
/mitgliedsantrag
```

Der Button auf `/verein` soll auf diese Route zeigen.

Pruefpunkte:

- Formular ist digital ausfuellbar.
- Formular ist druckbar.
- Pflichtfelder werden validiert.
- CSRF-Schutz ist aktiv.
- Versand oder Speicherung funktioniert.
- Keine Daten werden ungewollt oeffentlich ausgegeben.

## Mindesttest nach jeder Aenderung

Nach Aenderungen an Nutzern, Rollen oder Beitraegen pruefen:

1. Login mit Admin-Account.
2. Login mit normalem Member-Account.
3. `/news` zeigt nur veroeffentlichte Beitraege.
4. `/news/<slug>` zeigt den Detailartikel.
5. Offline-Beitraege sind nicht sichtbar.
6. Admin kann einen Beitrag anlegen oder aktualisieren.
7. Normaler Nutzer kann keine Verwaltungsfunktionen oeffnen.
8. Navigation zeigt keinen separaten Punkt `Verwaltung`.
