<?php
namespace Plugins\Areanet_Geo\Traits;

use Areanet\PIM\Classes\Annotations as PIM;
use Plugins\Areanet_Geo\Annotations as AN_GEO;

trait Geo
{

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

    /**
     * @PIM\Config(label="Geodaten")
     * @AN_GEO\Geo()
     */
    protected $geo;


    /**
     * @return mixed
     */
    public function getGeo()
    {
        return $this->geo;
    }

    /**
     * @param mixed $geo
     */
    public function setGeo($geo)
    {
        $this->geo = $geo;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param mixed $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }


}

