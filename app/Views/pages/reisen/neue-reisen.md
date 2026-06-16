#Wenn du später z. B. 2027 eine neue statische Seite anlegst:

#app/Views/pages/reisen/fly-in-xyz-2027.php

#Dann musst du den Slug an zwei Stellen ergänzen.

#In PageController.php:

#$staticTravelViews = [
#    'fly-in-woerthersee-2026' => 'pages/reisen/fly-in-woerthersee-2026',
#    'fly-in-xyz-2027' => 'pages/reisen/fly-in-xyz-2027',
#];

#In reisen.php:

#$staticTravelPages = [
#    'fly-in-woerthersee-2026',
#    'fly-in-xyz-2027',
#];

#Das ist doppelt, aber für deinen aktuellen Stand am einfachsten und am wenigsten riskant.