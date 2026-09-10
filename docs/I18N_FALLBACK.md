# Sprach-Fallback

Öffentliche Seiten verwenden den expliziten Query-Parameter `lang=de` oder `lang=en`.
Canonical- und hreflang-URLs enthalten diesen Parameter. Navigation und Formulare
reichen die gewählte Sprache weiter.

Fehlt zu einem englischen statischen oder datenbankgestützten Inhalt die englische
Fassung, wird mit HTTP 302 auf die deutsche Variante (`lang=de`) umgeleitet. Dadurch
werden deutsche Inhalte nie in einer englischen Seitenhülle ausgegeben. Sobald eine
englische Fassung gepflegt ist, kann sie ohne Änderung bestehender Pfade erscheinen.
