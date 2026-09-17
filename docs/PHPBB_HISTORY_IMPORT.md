# Historisches phpBB-Forum importieren

Der Import übernimmt ausschließlich freigegebene Themen und Beiträge aus den
öffentlichen Gäste- sowie den mitgliedergeschützten Mitgliederforen. Das
Administratorenforum, private Nachrichten, Entwürfe, Benutzerkonten,
Passwort-Hashes, E-Mail-Adressen, IP-Adressen und Profilfelder werden nicht
übernommen. Historische Autoren erscheinen nur als unverknüpfte Anzeigenamen.
E-Mail-Adressen, die innerhalb alter Beitragstexte stehen, werden bei der
Konvertierung ebenfalls automatisch entfernt. Inhalte der früheren
Mitgliederforen sind ausschließlich für angemeldete Mitglieder abrufbar.

## Reihenfolge

1. Produktive Datenbank und `storage/` vollständig sichern.
2. `database/patches/2026_phpbb_history_import.sql` genau einmal importieren.
3. Den bereitgestellten phpBB-Dump und den entpackten phpBB-Ordner `files/`
   ausschließlich lokal mit `tools/convert-phpbb-history.py` konvertieren.
4. Den erzeugten Inhalt des Ausgabeordners nach
   `storage/forum-attachments/` übertragen.
5. Die erzeugte private SQL-Datei einmal in die produktive Datenbank
   importieren.
6. Als Gast und als Mitglied stichprobenartig Kategorien, Themen, Umlaute und
   Anhänge kontrollieren.

Beispiel:

```bash
python3 tools/convert-phpbb-history.py \
  --dump /sicherer/pfad/d02fb2e1.sql \
  --files /sicherer/pfad/files \
  --output-sql /sicherer/pfad/mmig46-history-private.sql \
  --output-files /sicherer/pfad/forum-attachments
```

Die erzeugte SQL-Datei, der Report und die Anhänge enthalten reale Inhalte und
dürfen nicht in Git eingecheckt werden.
