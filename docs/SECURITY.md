# Sicherheit

## Umgesetzt

- Prepared Statements via PDO
- CSRF-Token fuer POST-Formulare
- Browser-Session-Cookie mit `HttpOnly`, `SameSite=Lax`, `Secure` bei HTTPS
- Brute-Force-Begrenzung: maximal 8 Loginversuche pro IP innerhalb 15 Minuten
- Rollen: `admin`, `moderator`, `member`, `guest`
- Forum: Schreiben nur fuer eingeloggte Mitglieder/Rollen
- Kontakt-Captcha ohne externe Dienste
- Keine externen Frontend-Requests
- Security-Header in `public/.htaccess`

## Vor Livegang zwingend

- Demo-Accounts entfernen oder Passwoerter aendern
- `.env` mit echten Daten pflegen und nicht committen
- PHP 8.1+ verwenden
- DB-Passwort und Mail-Passwort nicht im Repository speichern
- Adminzugang nur an vertrauenswuerdige Personen geben

## Noch bewusst schlank gehalten

- Passwort-Reset ist strukturell vorbereitet, aber UI/Flow ist noch nicht voll implementiert.
- E-Mail-Verifikation ist ueber `email_verified_at` abgebildet; manuell angelegte Accounts koennen direkt verifiziert werden.
- Kein vollstaendiges Audit-Logging.
- Kein Granular-Rechtemodell pro Inhalt.
