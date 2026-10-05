# Trainingswochenende 2026 – vollständige Übernahme auf den Server

Diese Liste umfasst die Vorankündigung aus PR #13 und den finalen Rückblick. Alle Dateien aus dem endgültigen Stand von `main` verwenden.

1. Zuerst den neuen Bilderordner und die neue gemeinsame Ansicht hochladen.
2. Anschließend die acht vorhandenen PHP-/CSS-/JS-Dateien ersetzen.
3. In phpMyAdmin auf der richtigen MMIG-Datenbank einmalig `database/patches/2026_training_weekend_recap.sql` ausführen. Dies aktualisiert den vorhandenen Newsbeitrag oder legt ihn bei Bedarf an, inklusive Bild. Bestehende Kommentare bleiben erhalten.
4. Die Veranstaltungsseite mit `?lang=de` und `?lang=en` öffnen, Galerie prüfen und die Startseite/News kontrollieren.

Der ältere Patch `2026_training_weekend_completed.sql` ist nicht erforderlich. Der Seed `database/training_weekend_2026.sql` sowie Tests und diese Anleitung müssen nicht hochgeladen werden. Datenbankdateien nicht öffentlich hochladen. Die Original-JPGs müssen ebenfalls nicht hochgeladen werden.

## PHP, CSS und JavaScript

- `app/Controllers/PageController.php` **ersetzen**
- `app/Core/Seo.php` **ersetzen**
- `app/Views/layouts/main.php` **ersetzen**
- `app/Views/pages/home.php` **ersetzen**
- `app/Views/pages/training-weekend.php` **ersetzen**
- `app/Views/pages/en/training-weekend.php` **ersetzen**
- `app/Views/partials/training-weekend-report.php` **neu**
- `public/assets/css/app.css` **ersetzen**
- `public/assets/js/app.js` **ersetzen**

## Bilder

Den kompletten neuen Ordner `public/assets/img/training-weekend/recap-2026/` mit allen 40 Dateien hochladen. Die `-640.webp`-Dateien sind die kleinen Bildschirmvarianten.

- `public/assets/img/training-weekend/recap-2026/01-poloshirts-640.webp`
- `public/assets/img/training-weekend/recap-2026/01-poloshirts.webp`
- `public/assets/img/training-weekend/recap-2026/02-ras-640.webp`
- `public/assets/img/training-weekend/recap-2026/02-ras.webp`
- `public/assets/img/training-weekend/recap-2026/03-ankunft-640.webp`
- `public/assets/img/training-weekend/recap-2026/03-ankunft.webp`
- `public/assets/img/training-weekend/recap-2026/04-simulator-640.webp`
- `public/assets/img/training-weekend/recap-2026/04-simulator.webp`
- `public/assets/img/training-weekend/recap-2026/05-cockpit-640.webp`
- `public/assets/img/training-weekend/recap-2026/05-cockpit.webp`
- `public/assets/img/training-weekend/recap-2026/06-feuerwehrfahrzeug-640.webp`
- `public/assets/img/training-weekend/recap-2026/06-feuerwehrfahrzeug.webp`
- `public/assets/img/training-weekend/recap-2026/07-feuerwehrdemonstration-640.webp`
- `public/assets/img/training-weekend/recap-2026/07-feuerwehrdemonstration.webp`
- `public/assets/img/training-weekend/recap-2026/08-feuerwehr-640.webp`
- `public/assets/img/training-weekend/recap-2026/08-feuerwehr.webp`
- `public/assets/img/training-weekend/recap-2026/09-vorfeld-640.webp`
- `public/assets/img/training-weekend/recap-2026/09-vorfeld.webp`
- `public/assets/img/training-weekend/recap-2026/10-vortrag-640.webp`
- `public/assets/img/training-weekend/recap-2026/10-vortrag.webp`
- `public/assets/img/training-weekend/recap-2026/11-ramshof-640.webp`
- `public/assets/img/training-weekend/recap-2026/11-ramshof.webp`
- `public/assets/img/training-weekend/recap-2026/12-gesellschaftsabend-640.webp`
- `public/assets/img/training-weekend/recap-2026/12-gesellschaftsabend.webp`
- `public/assets/img/training-weekend/recap-2026/13-abendessen-640.webp`
- `public/assets/img/training-weekend/recap-2026/13-abendessen.webp`
- `public/assets/img/training-weekend/recap-2026/14-oval-office-640.webp`
- `public/assets/img/training-weekend/recap-2026/14-oval-office.webp`
- `public/assets/img/training-weekend/recap-2026/15-seminarraum-640.webp`
- `public/assets/img/training-weekend/recap-2026/15-seminarraum.webp`
- `public/assets/img/training-weekend/recap-2026/16-ifr-vortrag-640.webp`
- `public/assets/img/training-weekend/recap-2026/16-ifr-vortrag.webp`
- `public/assets/img/training-weekend/recap-2026/17-avionik-vortrag-640.webp`
- `public/assets/img/training-weekend/recap-2026/17-avionik-vortrag.webp`
- `public/assets/img/training-weekend/recap-2026/18-avionik-640.webp`
- `public/assets/img/training-weekend/recap-2026/18-avionik.webp`
- `public/assets/img/training-weekend/recap-2026/19-gespraeche-640.webp`
- `public/assets/img/training-weekend/recap-2026/19-gespraeche.webp`
- `public/assets/img/training-weekend/recap-2026/20-austausch-640.webp`
- `public/assets/img/training-weekend/recap-2026/20-austausch.webp`
