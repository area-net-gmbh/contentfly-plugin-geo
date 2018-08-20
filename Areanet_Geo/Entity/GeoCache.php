<?php
namespace Plugins\Areanet_Geo\Entity;

use Areanet\PIM\Entity\Base;
use Areanet\PIM\Classes\Annotations as PIM;
use Custom\Classes\Annotations as CUSTOM;
use Areanet\PIM\Entity\BaseSortable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="geoplugin_cache")
 * @PIM\Config(label="GeoCache")
 */
class GeoCache extends Base
{
    /**
     * @ORM\Column(type="string", length=255)
     * @PIM\Config(label="Suchbegriff", showInList=20)
     */
    protected $query;

    /**
     * @ORM\Column(type="string", length=255, unique = true)
     * @PIM\Config(label="Kodiert", readonly=true)
     */
    protected $queryEncoded;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=8, nullable=true)
     * @PIM\Config(label="Breitengrad", showInList=30)
     */
    protected $lat;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=8, nullable=true)
     * @PIM\Config(label="Längengrad", showInList=40)
     */
    protected $lng;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @PIM\Config(label="Fehler", showInList=50)
     */
    protected $error = 0;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @PIM\Config(label="API-Rückgabe")
     */
    protected $response;

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return mixed
     */
    public function getQueryEncoded()
    {
        return $this->queryEncoded;
    }

    /**
     * @param mixed $queryEncoded
     */
    public function setQueryEncoded($queryEncoded)
    {
        $this->queryEncoded = $queryEncoded;
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

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return mixed
     */
    public function incError()
    {
        $this->error++;
        return $this->error;
    }


    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }






}