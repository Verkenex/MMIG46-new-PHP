# Datenbankstruktur der MMIG46-Website

Dieses Verzeichnis enthält das aktuelle Datenbankschema, Daten für verschiedene Installationsarten, Forumdaten und nachträgliche Datenbank-Patches.

## Aktuelle Struktur

```text
database/
├── patches/
│   ├── archive/
│   └── 2026_woerthersee_static_cleanup.sql
├── README.md
├── forum.sql
├── schema.sql
├── seed_admin.sql
├── seed_demo.sql
├── seed_forum.sql
└── seed_live.sql
```

## Bedeutung der Dateien

### `schema.sql`

Enthält das grundlegende Datenbankschema der Anwendung.

Diese Datei muss bei einer vollständigen Neuinstallation zuerst importiert werden.

### `seed_live.sql`

Enthält die für eine produktive Neuinstallation vorgesehenen Live- beziehungsweise Inhaltsdaten.

### `seed_admin.sql`

Enthält die für den initialen administrativen Zugriff vorgesehenen Daten.

Vor dem Import muss die Datei geprüft werden. Nach der Installation müssen alle darin enthaltenen Standardzugänge beziehungsweise Passwörter ersetzt oder individuell gesetzt werden.

### `seed_demo.sql`

Enthält ausschließlich lokale Demo- oder Testdaten.

Diese Datei darf nicht in die produktive Datenbank importiert werden.

### `seed_forum.sql`

Enthält zusätzliche beziehungsweise vorbereitete Forumdaten.

Vor einem Import muss geprüft werden, ob diese Daten im jeweiligen System tatsächlich benötigt werden und ob sie bereits vorhanden sind.

### `forum.sql`

Enthält Forum-bezogene SQL-Strukturen oder Daten aus einem separaten Arbeitsschritt.

Die Datei darf nicht pauschal zusätzlich zu `schema.sql` importiert werden. Vor der Verwendung muss geprüft werden, ob ihre Inhalte bereits im aktuellen Schema enthalten sind.

### `patches/`

Enthält nachträgliche, gezielte Datenbankänderungen.

Patches sind keine vollständigen Installationsdateien und dürfen nur auf dem vorgesehenen Ausgangsstand ausgeführt werden.

### `patches/archive/`

Enthält archivierte, ersetzte oder bereits eingeordnete Patchdateien.

Diese Dateien dürfen nicht automatisch oder pauschal erneut importiert werden.

## Produktive Neuinstallation

Empfohlene Reihenfolge:

```bash
mysql -u USER -p DATENBANK < database/schema.sql
mysql -u USER -p DATENBANK < database/seed_live.sql
mysql -u USER -p DATENBANK < database/seed_admin.sql
```

Nicht produktiv importieren:

```text
database/seed_demo.sql
```

`seed_forum.sql` nur importieren, wenn die darin enthaltenen Forumdaten ausdrücklich benötigt werden:

```bash
mysql -u USER -p DATENBANK < database/seed_forum.sql
```

## Lokale Testinstallation

Empfohlene Reihenfolge:

```bash
mysql -u USER -p DATENBANK < database/schema.sql
mysql -u USER -p DATENBANK < database/seed_demo.sql
```

Optional:

```bash
mysql -u USER -p DATENBANK < database/seed_forum.sql
```

Für lokale Entwicklungsumgebungen existiert zusätzlich:

```text
tools/reset_local_db.sh
```

Vor der Ausführung müssen die darin verwendeten Datenbankparameter geprüft werden.

## Bestehende produktive Datenbank aktualisieren

Bei einer bestehenden Installation darf `schema.sql` nicht ungeprüft erneut importiert werden.

Stattdessen:

1. Datenbank sichern.
2. Inhalt des benötigten Patches prüfen.
3. Ausgangsstand der Datenbank prüfen.
4. Patch einmalig ausführen.
5. Ergebnis kontrollieren.
6. ausgeführten Patch dokumentieren.

Backup:

```bash
mysqldump -u USER -p DATENBANK > backup-vor-patch.sql
```

Beispiel für einen Patch:

```bash
mysql -u USER -p DATENBANK < database/patches/2026_woerthersee_static_cleanup.sql
```

## Sicherheitsregeln

Folgende Dateien dürfen nicht in dieses Verzeichnis oder in Git eingecheckt werden:

* ungeprüfte Dumps der produktiven Datenbank
* Klartextpasswörter
* SMTP-Zugangsdaten
* personenbezogene Mitgliederexporte
* Kontaktanfragen aus dem Produktivsystem
* Login-Protokolle mit personenbezogenen Daten
* vollständige Backups mit realen Nutzerdaten

Produktive Datenbankzugangsdaten gehören ausschließlich in:

```text
.env
```

Die Datei `.env` darf nicht versioniert werden.

## Wichtiger Hinweis

Die tatsächliche Datenbankstruktur wird durch `schema.sql`, die Modelle unter `app/Models/` und den aktuell ausgeführten Stand der Patches bestimmt.

Bei Widersprüchen zwischen dieser Dokumentation und dem Anwendungscode muss zuerst der reale Code- und Datenbankstand geprüft und anschließend diese README aktualisiert werden.
