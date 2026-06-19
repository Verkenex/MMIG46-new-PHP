START TRANSACTION;

DELETE FROM news_items;
DELETE FROM travel_items;
DELETE FROM content_pages;

INSERT INTO content_pages
(lang, slug, title, teaser, body, meta_title, meta_description, is_published)
VALUES

('de', 'verein',
'Der Verein',
'Die MMIG46 ist die europäische Interessen- und Erfahrungsgemeinschaft für Halter, Piloten und Freunde der Piper Malibu, Mirage, Meridian, Matrix und JetPROP.',
'# MMIG46 e.V.

Die MMIG46 ist eine europäische Interessen- und Erfahrungsgemeinschaft für Halter, Piloten und Freunde der Piper PA-46-Familie. Der Verein verbindet fliegerische Praxis, technische Erfahrung, Sicherheitsbewusstsein und persönliche Kontakte innerhalb der Malibu-, Mirage-, Matrix-, Meridian- und JetPROP-Community.

## Zweck des Vereins

Die MMIG46 fördert den Austausch zwischen Eigentümern, Piloten, Technikern und Interessierten. Im Mittelpunkt stehen sichere Betriebsverfahren, technische Erfahrungen, Reiseplanung, Weiterbildung und der persönliche Kontakt innerhalb der europäischen PA-46-Gemeinschaft.

## Aktivitäten

Zu den regelmäßigen Aktivitäten gehören Fly-Ins, technische Vorträge, Erfahrungsberichte, Sicherheitsdiskussionen und der Austausch über Wartung, Betrieb, Avionik, Performance und Reiseplanung.

## Mitgliedschaft

Mitglied werden können Halter, Piloten und Freunde der PA-46-Familie sowie Personen, die sich für den sicheren und sachkundigen Betrieb dieser Flugzeuge interessieren. Der Mitgliedsantrag kann online gestellt werden.

## Kontakt

Für Fragen zum Verein, zur Mitgliedschaft oder zu kommenden Veranstaltungen steht das Kontaktformular zur Verfügung.',
'MMIG46 e.V. – Verein',
'Informationen über Zweck, Aktivitäten und Mitgliedschaft der MMIG46 e.V.',
1),

('en', 'verein',
'The Club',
'MMIG46 is the European interest and experience group for owners, pilots and friends of the Piper Malibu, Mirage, Meridian, Matrix and JetPROP.',
'# MMIG46 e.V.

MMIG46 is a European interest and experience group for owners, pilots and friends of the Piper PA-46 family. The association connects practical flying experience, technical knowledge, safety awareness and personal contacts within the Malibu, Mirage, Matrix, Meridian and JetPROP community.

## Purpose

MMIG46 promotes exchange between owners, pilots, technicians and interested aviation enthusiasts. The focus is on safe operating practices, technical experience, travel planning, recurrent learning and personal contact within the European PA-46 community.

## Activities

Regular activities include fly-ins, technical presentations, operational briefings, safety discussions and exchange on maintenance, aircraft operation, avionics, performance and travel planning.

## Membership

Membership is open to owners, pilots and friends of the PA-46 family as well as people interested in the safe and informed operation of these aircraft. Applications can be submitted online.

## Contact

For questions about the club, membership or upcoming events, please use the contact form.',
'MMIG46 e.V. – Club',
'Information about the purpose, activities and membership of MMIG46 e.V.',
1),

('de', 'links',
'Links',
'Wichtige externe Quellen für PA-46-Piloten, Reiseplanung, Wetter, Sicherheit und Verbandsinformationen.',
'# Links

Diese Seite bündelt externe Quellen, die für PA-46-Piloten, Halter und Interessierte nützlich sein können.

## Flugbetrieb und Sicherheit

- EASA
- AOPA Germany
- Eurocontrol
- Deutsche Flugsicherung
- Nationale AIP-Portale der Zielländer

## Wetter und Flugplanung

- DWD Flugwetter
- MeteoSchweiz
- Austro Control
- Autorisierte nationale Wetterdienste
- Flugplanungs- und NOTAM-Portale

## Hersteller, Technik und Community

- Piper Aircraft
- JetPROP
- PA-46-relevante Service- und Wartungsbetriebe
- Avionikhersteller und Service Bulletins

Alle externen Inhalte liegen außerhalb der Verantwortung der MMIG46. Vor operativen Entscheidungen sind stets offizielle, aktuelle und zugelassene Quellen zu verwenden.',
'MMIG46 – Links',
'Externe Quellen für PA-46-Flugbetrieb, Wetter, Sicherheit und Technik.',
1),

('en', 'links',
'Links',
'Useful external sources for PA-46 pilots, owners, flight planning, weather, safety and association information.',
'# Links

This page collects external sources that may be useful for PA-46 pilots, owners and interested aviation enthusiasts.

## Flight operations and safety

- EASA
- AOPA Germany
- Eurocontrol
- German Air Navigation Services
- National AIP portals of destination countries

## Weather and flight planning

- DWD aviation weather
- MeteoSwiss
- Austro Control
- Approved national weather services
- Flight planning and NOTAM portals

## Manufacturer, maintenance and community

- Piper Aircraft
- JetPROP
- PA-46 maintenance and service providers
- Avionics manufacturers and service bulletins

External content is outside the responsibility of MMIG46. Operational decisions must always be based on official, current and approved sources.',
'MMIG46 – Links',
'External sources for PA-46 flight operations, weather, safety and maintenance.',
1),

('de', 'wetter',
'Wetter',
'Hinweise zu Wetter- und Flugplanungsquellen für IFR- und VFR-Flüge mit der PA-46-Familie.',
'# Wetter

Diese Seite verweist auf offizielle Wetter- und Flugplanungsquellen. Sie ersetzt keine Flugvorbereitung und keine autorisierte Wetterberatung.

## Für die Flugvorbereitung relevant

- METAR und TAF
- GAFOR, SIGMET und AIRMET
- Wind- und Temperaturkarten
- Significant Weather Charts
- Radar- und Satellitenbilder
- NOTAMs und AIP-Informationen
- Enroute- und Destination-Alternates

## PA-46-spezifische Hinweise

Bei Flügen mit der PA-46-Familie sind Vereisung, Gewitter, Hochgebirgswetter, Sauerstoffmanagement, Reichweitenplanung und Alternate-Strategie besonders sorgfältig zu prüfen.

Verwenden Sie ausschließlich aktuelle, offizielle und für Ihre Operation zugelassene Quellen.',
'MMIG46 – Wetter',
'Hinweise zu Wetter- und Flugplanungsquellen für PA-46-Piloten.',
1),

('en', 'wetter',
'Weather',
'References to official weather and flight planning sources for IFR and VFR flights with the PA-46 family.',
'# Weather

This page refers to official weather and flight planning sources. It does not replace proper pre-flight preparation or approved aviation weather briefing.

## Relevant for flight preparation

- METAR and TAF
- GAFOR, SIGMET and AIRMET
- Wind and temperature charts
- Significant weather charts
- Radar and satellite imagery
- NOTAM and AIP information
- Enroute and destination alternates

## PA-46-specific considerations

When operating the PA-46 family, icing, thunderstorms, mountain weather, oxygen management, range planning and alternate strategy require particular attention.

Always use current, official and approved sources for operational decisions.',
'MMIG46 – Weather',
'Weather and flight planning references for PA-46 pilots.',
1);

INSERT INTO news_items
(lang, title, slug, category, image_path, comment_count, teaser, body, published_at, is_published)
VALUES

('de',
'Fly-In Wörthersee 2026',
'fly-in-woerthersee-2026',
'Event',
'/assets/img/travels/woerthersee-2026.jpg',
0,
'Das nächste MMIG46 Fly-In führt an den Wörthersee. Informationen zu Programm, Anmeldung und organisatorischen Details werden auf der Reiseseite gebündelt.',
'# Fly-In Wörthersee 2026

Das nächste MMIG46 Fly-In führt an den Wörthersee. Die Veranstaltung bringt Mitglieder, PA-46-Piloten und Freunde der MMIG46 für ein Wochenende mit Fliegen, Austausch und gemeinsamem Programm zusammen.

## Inhalt

Geplant sind Anreise, gemeinsames Abendprogramm, Austausch zu technischen und fliegerischen Themen sowie ein Rahmenprogramm in der Region.

Weitere Details zu Anmeldung, Hotelkontingenten, Flugplatzinformationen und Programm werden auf der Reiseseite gepflegt.',
'2026-01-15 09:00:00',
1),

('en',
'Fly-In Wörthersee 2026',
'fly-in-woerthersee-2026',
'Event',
'/assets/img/travels/woerthersee-2026.jpg',
0,
'The next MMIG46 fly-in will take place at Lake Wörthersee. Programme, registration and organisational details are collected on the travel page.',
'# Fly-In Wörthersee 2026

The next MMIG46 fly-in will take place at Lake Wörthersee. The event brings together members, PA-46 pilots and friends of MMIG46 for a weekend of flying, exchange and shared activities.

## Content

The programme is expected to include arrival, a joint evening event, exchange on technical and operational topics and activities in the region.

Further details on registration, hotel arrangements, airfield information and programme will be maintained on the travel page.',
'2026-01-15 09:00:00',
1),

('de',
'Willkommen auf der neuen MMIG46-Website',
'willkommen-neue-mmig46-website',
'Website',
'/assets/img/news/mmig46-website.jpg',
0,
'Die neue Website bündelt Reisen, News, Forum, Mitgliederbereich und Informationen zur PA-46-Familie in einer modernisierten PHP/MariaDB-Anwendung.',
'# Willkommen auf der neuen MMIG46-Website

Die Website der MMIG46 wurde technisch und redaktionell modernisiert. Ziel ist ein übersichtlicher, schneller und wartbarer Auftritt für Mitglieder, Interessenten und die europäische PA-46-Community.

## Neu strukturiert

Die wichtigsten Bereiche sind jetzt klar gegliedert:

- News und aktuelle Hinweise
- Reisen und Fly-Ins
- Informationen zur Malibu-Mirage- und PA-46-Familie
- Verein und Mitgliedschaft
- Mitgliederliste
- Forum
- Kontakt und Mitgliedsantrag

Die Inhalte werden schrittweise weiter ergänzt und gepflegt.',
'2026-01-10 09:00:00',
1),

('en',
'Welcome to the new MMIG46 website',
'welcome-new-mmig46-website',
'Website',
'/assets/img/news/mmig46-website.jpg',
0,
'The new website brings together travels, news, forum, member information and PA-46 content in a modernised PHP/MariaDB application.',
'# Welcome to the new MMIG46 website

The MMIG46 website has been technically and editorially modernised. The objective is a clear, fast and maintainable web presence for members, interested visitors and the European PA-46 community.

## New structure

The key areas are now clearly organised:

- News and current updates
- Travels and fly-ins
- Information about the Malibu Mirage and PA-46 family
- Club and membership
- Member list
- Forum
- Contact and membership application

Content will continue to be maintained and expanded.',
'2026-01-10 09:00:00',
1),

('de',
'PA-46-Erfahrungsaustausch im Forum',
'pa46-erfahrungsaustausch-forum',
'Community',
'/assets/img/news/forum.jpg',
0,
'Das Forum dient dem Austausch über Technik, Betrieb, Reisen, Training und Erfahrungen rund um die PA-46-Familie.',
'# PA-46-Erfahrungsaustausch im Forum

Das Forum ist der zentrale Ort für den Austausch innerhalb der MMIG46-Community.

## Themen

Diskutiert werden unter anderem:

- Betriebserfahrungen
- Wartung und technische Fragen
- Avionik
- Reiseplanung
- Training und Safety
- Fly-Ins und Veranstaltungen

Öffentliche Beiträge sind lesbar. Das Schreiben im Forum ist angemeldeten Mitgliedern vorbehalten.',
'2026-01-05 09:00:00',
1),

('en',
'PA-46 exchange in the forum',
'pa46-exchange-forum',
'Community',
'/assets/img/news/forum.jpg',
0,
'The forum supports exchange on maintenance, operations, travel, training and experience around the PA-46 family.',
'# PA-46 exchange in the forum

The forum is the central place for exchange within the MMIG46 community.

## Topics

Typical discussions include:

- Operational experience
- Maintenance and technical questions
- Avionics
- Travel planning
- Training and safety
- Fly-ins and events

Public posts can be read by visitors. Posting is reserved for registered members.',
'2026-01-05 09:00:00',
1);

INSERT INTO travel_items
(lang, title, slug, image_path, location, starts_on, ends_on, status, teaser, cta_label, legacy_pdf_url, legacy_pdf_path, body, is_published)
VALUES

('de',
'Fly-In Wörthersee 2026',
'fly-in-woerthersee-2026',
'/assets/img/travels/woerthersee-2026.jpg',
'Wörthersee, Österreich',
'2026-06-12',
'2026-06-14',
'completed',
'Das abgeschlossene MMIG46 Fly-In führte an den Wörthersee. Mitglieder und Freunde der PA-46-Familie trafen sich zu Austausch und gemeinsamem Programm.',
'Impressionen und Nachbericht',
NULL,
'/downloads/travels/woerthersee-2026.pdf',
'# Fly-In Wörthersee 2026

Das MMIG46 Fly-In 2026 führte an den Wörthersee. Die Region verbindet eine attraktive fliegerische Destination mit guter Erreichbarkeit und einem passenden Rahmen für Austausch und Gemeinschaft.

## Ablauf

- Individuelle Anreise
- Begrüßung und gemeinsames Abendessen
- Austausch zu PA-46-Betrieb, Technik und Reiseerfahrungen
- Rahmenprogramm in der Region
- Individuelle Rückreise

## Hinweise

Details zu Flugplatz, Hotel, Anmeldung und finalem Programm werden über die Vereinskommunikation und diese Seite bereitgestellt. Operative Informationen sind vor dem Flug anhand offizieller Quellen zu prüfen.',
1),

('en',
'Fly-In Wörthersee 2026',
'fly-in-woerthersee-2026',
'/assets/img/travels/woerthersee-2026.jpg',
'Lake Wörthersee, Austria',
'2026-06-12',
'2026-06-14',
'completed',
'The completed MMIG46 fly-in took place at Lake Wörthersee. Members and friends of the PA-46 family met for flying, exchange and a shared programme.',
'View details',
NULL,
'/downloads/travels/woerthersee-2026.pdf',
'# Fly-In Wörthersee 2026

The MMIG46 Fly-In 2026 took place at Lake Wörthersee. The region combines an attractive aviation destination with good accessibility and a suitable setting for exchange and community.

## Schedule

- Individual arrivals
- Welcome and joint dinner
- Exchange on PA-46 operations, maintenance and travel experience
- Regional programme
- Individual departures

## Notes

Details on airfield, hotel, registration and final programme will be provided via club communication and this page. Operational information must be checked against official sources before flight.',
1),

('de',
'Fly-In Wörthersee 2025',
'fly-in-woerthersee-2025',
'/assets/img/travels/woerthersee-2025.jpg',
'Wörthersee, Österreich',
'2025-06-13',
'2025-06-15',
'completed',
'Rückblick auf das MMIG46 Fly-In 2025 am Wörthersee.',
'Rückblick ansehen',
NULL,
'/downloads/travels/woerthersee-2025.pdf',
'# Fly-In Wörthersee 2025

Das Fly-In 2025 brachte Mitglieder und Freunde der MMIG46 am Wörthersee zusammen. Im Mittelpunkt standen persönliche Begegnungen, fliegerischer Austausch und Gespräche über den praktischen Betrieb der PA-46-Familie.

## Themen

- Reise- und Betriebserfahrungen
- Technische Fragen aus der Community
- Safety-Aspekte bei IFR-Reisen
- Erfahrungsaustausch zwischen Haltern und Piloten

Der Rückblick bleibt als Archivbeitrag erhalten.',
1),

('en',
'Fly-In Wörthersee 2025',
'fly-in-woerthersee-2025',
'/assets/img/travels/woerthersee-2025.jpg',
'Lake Wörthersee, Austria',
'2025-06-13',
'2025-06-15',
'completed',
'Review of the MMIG46 Fly-In 2025 at Lake Wörthersee.',
'View review',
NULL,
'/downloads/travels/woerthersee-2025.pdf',
'# Fly-In Wörthersee 2025

The 2025 fly-in brought together members and friends of MMIG46 at Lake Wörthersee. The focus was on personal contact, operational exchange and discussions about practical PA-46 operations.

## Topics

- Travel and operational experience
- Technical questions from the community
- Safety aspects of IFR travel
- Exchange between owners and pilots

The review remains available as an archive entry.',
1),

('de',
'Fly-In Venedig 2024',
'fly-in-venedig-2024',
'/assets/img/travels/venice-2024.jpg',
'Venedig, Italien',
'2024-06-07',
'2024-06-09',
'completed',
'Das MMIG46 Fly-In 2024 führte nach Venedig und verband eine besondere Destination mit fliegerischem Austausch.',
'Rückblick ansehen',
NULL,
'/downloads/travels/venice-2024.pdf',
'# Fly-In Venedig 2024

Das Fly-In 2024 führte die MMIG46 nach Venedig. Die Veranstaltung verband eine außergewöhnliche Destination mit dem bewährten persönlichen und fachlichen Austausch der PA-46-Community.

## Inhalte

- Individuelle Anreise
- Gemeinsames Programm
- Austausch zu Reiseplanung, IFR-Betrieb und Technik
- Persönliche Begegnungen innerhalb der MMIG46

Der Beitrag bleibt als Reise-Archiv erhalten.',
1),

('en',
'Fly-In Venice 2024',
'fly-in-venedig-2024',
'/assets/img/travels/venice-2024.jpg',
'Venice, Italy',
'2024-06-07',
'2024-06-09',
'completed',
'The MMIG46 Fly-In 2024 took place in Venice, combining a special destination with operational exchange.',
'View review',
NULL,
'/downloads/travels/venice-2024.pdf',
'# Fly-In Venice 2024

The 2024 fly-in took MMIG46 to Venice. The event combined an exceptional destination with the proven personal and technical exchange of the PA-46 community.

## Content

- Individual arrivals
- Shared programme
- Exchange on travel planning, IFR operations and maintenance
- Personal contact within MMIG46

This entry remains available in the travel archive.',
1),

('de',
'Fly-In Verona 2023',
'fly-in-verona-2023',
'/assets/img/travels/verona-2023.jpg',
'Verona, Italien',
'2023-06-09',
'2023-06-11',
'completed',
'Rückblick auf das MMIG46 Fly-In 2023 in Verona.',
'Rückblick ansehen',
NULL,
'/downloads/travels/verona-2023.pdf',
'# Fly-In Verona 2023

Das MMIG46 Fly-In 2023 fand in Verona statt. Die Veranstaltung bot Gelegenheit für Austausch, Reiseerfahrungen und persönliche Gespräche innerhalb der PA-46-Gemeinschaft.

## Schwerpunkte

- Erfahrungsaustausch zwischen Piloten und Haltern
- Reiseplanung im europäischen IFR-Umfeld
- Technische und operative Fragen
- Gemeinsames Rahmenprogramm

Der Beitrag bleibt als Archivseite verfügbar.',
1),

('en',
'Fly-In Verona 2023',
'fly-in-verona-2023',
'/assets/img/travels/verona-2023.jpg',
'Verona, Italy',
'2023-06-09',
'2023-06-11',
'completed',
'Review of the MMIG46 Fly-In 2023 in Verona.',
'View review',
NULL,
'/downloads/travels/verona-2023.pdf',
'# Fly-In Verona 2023

The MMIG46 Fly-In 2023 took place in Verona. The event offered opportunities for exchange, travel experience and personal conversations within the PA-46 community.

## Focus

- Exchange between pilots and owners
- Travel planning in the European IFR environment
- Technical and operational questions
- Shared programme

This entry remains available as an archive page.',
1);

COMMIT;