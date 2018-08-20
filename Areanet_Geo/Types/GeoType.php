<?php
namespace Plugins\Areanet_Geo\Types;

use Areanet\PIM\Classes\Type\PluginType;
use Silex\Application;

class GeoType extends PluginType
{

    protected $key = null;

    public function __construct(Application $app, $key = null)
    {
        parent::__construct($app);
        $this->key = $key;
    }


    public function getAlias()
    {
        return 'geo';
    }

    public function getAnnotationFile()
    {
        return 'Geo';
    }

    public function doMatch($propertyAnnotations){
        if(!isset($propertyAnnotations['Plugins\\Areanet_Geo\\Annotations\\Geo'])) {
            return false;
        }

        return true;
    }

    public function processSchema($key, $defaultValue, $propertyAnnotations, $entityName){
        $schema                 = parent::processSchema($key, $defaultValue, $propertyAnnotations, $entityName);
        //$propertyAnnotations    = $propertyAnnotations['Plugins\\Areanet_Geo\\Annotations\\Geo'];
        $schema['nullable']     = true;
        $schema['dbtype']       = null;
        $schema['mapbox_token'] = $this->key;
        return $schema;
    }


}
