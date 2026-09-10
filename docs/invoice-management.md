# Rechnungsverwaltung – Installation und Betrieb

Die Rechnungsverwaltung ist ausschließlich unter `/verwaltung/rechnungen`
erreichbar. Entwürfe sind veränderbar; bei der Finalisierung werden Nummer,
Aussteller, Empfänger, Positionen, Steuerdaten und Zahlungsdaten als
Momentaufnahme festgeschrieben. Das finale PDF und ein SHA-256-Hash werden im
nicht öffentlichen Verzeichnis `storage/invoices/` gespeichert.

## Installation

1. Vollständiges Datei- und Datenbankbackup erstellen.
2. Den Stand mit `2026_membership_workflow_admin.sql` sicherstellen.
3. `database/patches/2026_invoice_management.sql` in phpMyAdmin **genau einmal**
   importieren. Ein zweiter Import ist nicht vorgesehen.
4. Die geänderten Dateien mit Cyberduck hochladen; `.env` und vorhandene
   Dateien in `storage/invoices/` niemals überschreiben.
5. Auf dem Zielsystem im Projektverzeichnis
   `composer install --no-dev --optimize-autoloader` ausführen. Falls dort kein
   Composer verfügbar ist, `vendor/` lokal mit PHP 8.1+ und dem Lockfile bauen
   und vollständig hochladen.
6. Schreibrechte für den PHP-Prozess auf `storage/invoices/` einrichten. Das
   Verzeichnis darf nicht öffentlich ausgeliefert werden; die enthaltene
   `.htaccess` ist eine zusätzliche Apache-Sperre.
7. Im Adminbereich die echten Aussteller-, Steuer- und Bankdaten hinterlegen.
   Fehlende Pflichtangaben blockieren die Finalisierung.

## Sicherer Rücksetzplan

Vor einer produktiven Nutzung kann auf den vorherigen Code-Stand zurückgestellt
und können die drei neuen Tabellen `invoice_items`, `invoices` und
`invoice_number_sequences` in dieser Reihenfolge entfernt werden. Sobald eine
Rechnung finalisiert wurde, dürfen Datenbanktabellen und PDFs nicht ohne
gesonderte revisionssichere Archivierung gelöscht werden. In jedem Fall zuerst
das vor der Migration angelegte Backup wiederherstellen.

## Betriebshinweise

- Nummern entstehen erst in der erfolgreichen Finalisierungstransaktion.
- Finale Rechnungen werden nicht bearbeitet oder gelöscht. Korrekturen erfolgen
  per dokumentierter Stornierung und neuer Rechnung.
- Versandversuche laufen über `mail_outbox`; Fehler und Wiederholungen sind im
  Rechnungsdetail sichtbar.
- PDF-Downloads erfolgen nur über authentifizierte Admin-Routen und erst nach
  erfolgreicher SHA-256-Prüfung.
