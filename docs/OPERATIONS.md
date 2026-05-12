# Betrieb

## Normale Bearbeitung

Die meisten statischen Inhalte liegen unter `app/Views/pages/*.php` und koennen direkt im Code angepasst werden.

Dynamisch gepflegt werden:

- Forumbeitraege
- Mitgliederliste
- Kontaktanfragen
- Nutzer/Accounts

## Adminbereich

Pfad: `/verwaltung`

Minimalfunktionen:

- Nutzer manuell anlegen
- Mitglieder manuell eintragen
- Bestehende Nutzer/Mitglieder anzeigen

Absichtlich nicht enthalten:

- Komplexe Rollenmatrix
- Bulk-Importe
- Medienbibliothek
- Vollstaendiges CMS

## Backups

Vor jedem Release:

1. Projektordner sichern.
2. Datenbank exportieren.
3. `.env` separat sichern.
4. ZIP/SQL nicht im oeffentlichen Webroot ablegen.
