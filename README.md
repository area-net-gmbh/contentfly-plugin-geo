# Contentfly Geo Plugin
- **Lizenz**: AGPL v3
- **Contentfly CMS Version**: ab 1.5.0
- **Webseite**: http://www.contentfly-cms.de

## Beschreibung

Plugin, um Geodaten (Längen- und Breitengrad) für eigene Entitäten im Contentfly CMS verwenden zu können.

- Die Darstellung der Karten erfolgt über Leaflet.js und OpenStreetMap
- Das Geocoding erfolgt über OpenCage (https://opencagedata.com/), ein entsprechender Account und API-Key wird benötigt

Um Geodaten in einer eigenen Entität verwenden zu können, muss der Trait _geo_ eingebunden werden.

```
namespace Custom\Entity;

use Areanet\PIM\Entity\Base;
use Doctrine\ORM\Mapping as ORM;
use Areanet\PIM\Classes\Annotations as PIM;
use Plugins\Areanet_Geo\Traits\Geo;

/**
 * @ORM\Entity
 * @ORM\Table(name="test")
 * @PIM\Config(label="Test")
 */
class Test extends Base
{

    use Geo;
    
    ...
```

Über den Trait werden folgende Properties (Datenbank-Felder) zur Entität hinzugefügt:
```
/**
 * @ORM\Column(type="decimal", precision=10, scale=8, nullable=true)
 * @PIM\Config(label="Längengrad", hide=true)
 */
protected $lat;

/**
 * @ORM\Column(type="decimal", precision=10, scale=8, nullable=true)
 * @PIM\Config(label="Breitengrad", hide=true)
 */
protected $lng;
```

## Installation

Download und Entpacken im plugin-Ordner: _plugins/Areanet_Geo_

**Registrieren des Plugins in der app.php**
```
$app['pluginManager]->register('Areanet_Geo', 'OPENCAGE_API-KEY');
```

## Geocoding

Damit das automatische Geocoding korrekt funktioniert, muss die Entität folgende Properties besitzen:
```
protected $street;
protected $zipcode;
protected $city;
```

Sobald alle drei Felder im Backend ausgefüllt (oder geändert) werden, startet das Plugin im Hintergrund eine Geocoding-Abfrage der Adresse an OpenCage, speichert den Längen- und Breitengrad in den Properties _lat_ und _lng_  und stellt das Ergebnis auf der Karte dar.


# Die Contentfly Plattform ist ein Produkt der AREA-NET GmbH

AREA-NET GmbH
Öschstrasse 33
73072 Donzdorf

**Kontakt**

- Telefon: 0 71 62 / 94 11 40
- Telefax: 0 71 62 / 94 11 18
- http://www.area-net.de
- http://www.app-agentur-bw.de
- http://www.contentfly-cms.de


**Geschäftsführer**
Gaugler Stephan, Köller Holger, Schmid Markus

**Handelsregister**
HRB 541303 Ulm
Sitz der Gesellschaft: Donzdorf
UST-ID: DE208051892




