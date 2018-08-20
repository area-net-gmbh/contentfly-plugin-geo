<?php
namespace Plugins\Areanet_Geo;

use Areanet\PIM\Classes\Plugin;
use Plugins\Areanet_Geo\Types\GeoType;

class GeoPlugin extends Plugin
{
    public static $API_KEY = null;


    public function init(){
        self::$API_KEY = $this->options;

        $this->useFrontend();
        $this->useORM();

        $this->app['routeManager']->mount('geoplugin', 'Plugins\Areanet_Geo\Controller\GeoController')
            ->post('geocode', true);

        $this->registerPluginType(new GeoType($this->app, $this->options));

        $this->addJSFile('/scripts/leaflet.js');
        $this->addCSSFile('/styles/plugin.css');
        $this->addCSSFile('/styles/leaflet.css');

    }

}
