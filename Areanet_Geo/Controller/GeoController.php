<?php
namespace Plugins\Areanet_Geo\Controller;

use Areanet\PIM\Classes\Controller\BaseController;
use Areanet\PIM\Classes\Exceptions\ContentflyException;
use Plugins\Areanet_Geo\Entity\GeoCache;
use Plugins\Areanet_Geo\GeoPlugin;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GeoController extends BaseController
{
    public function geocodeAction(Request $request){
        $query = trim($request->get('query'));

        if(!$query){
            throw new ContentflyException('geoplugin_empty_query');
        }

        $queryEncoded = urlencode($query);
        $cachedObject = $this->em->getRepository('Plugins\\Areanet_Geo\\Entity\\GeoCache')->findOneBy(array('queryEncoded' => $queryEncoded));

        if($cachedObject){
            if($cachedObject->getError() == 0){
                return new JSONResponse(array('lat' => $cachedObject->getLat(), 'lng' => $cachedObject->getLng(), 'cached' => true));
            }

            if($cachedObject->getError() < 3){
                try{
                    $data = $this->geocodeFromOpencagedata($queryEncoded);
                    $cachedObject->setLat($data['lat']);
                    $cachedObject->setLng($data['lng']);
                    $cachedObject->setError(0);
                    $this->em->flush();

                    return new JSONResponse(array('lat' => $data['lat'], 'lng' => $data['lng'], 'cached' => false));
                }catch (\Exception $e){
                    $cachedObject->incError();
                    $this->em->flush();
                    
                    throw new ContentflyException('geoplugin_no_result', 'cache');
                }
            }
        }else{
            try {
                $data = $this->geocodeFromOpencagedata($queryEncoded);
                $cachedObject = new GeoCache();
                $cachedObject->setQuery($query);
                $cachedObject->setQueryEncoded($queryEncoded);
                $cachedObject->setLat($data['lat']);
                $cachedObject->setLng($data['lng']);
                $cachedObject->setError(0);

                $this->em->persist($cachedObject);
                $this->em->flush();

                return new JSONResponse(array('lat' => $data['lat'], 'lng' => $data['lng'], 'cached' => false));
            }catch (\Exception $e){
                throw new ContentflyException('geoplugin_no_result', $e->getMessage(), $e->getCode());
            }
        }



    }

    protected function geocodeFromOpencagedata($query){
        $url    = "https://api.opencagedata.com/geocode/v1/json?q=$query&countrycode=de&limit=1&key=".GeoPlugin::$API_KEY;
        $curl   = curl_init($url);

        curl_setopt($curl, CURLOPT_HTTPHEADER ,array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $response  = curl_exec ($curl);
        curl_close ($curl);

        $arr = json_decode($response, true);

        if(is_array($arr['results']) && count($arr['results']) > 0){
            $firstOject = $arr['results'][0];

            $lat = $firstOject['geometry']['lat'];
            $lng = $firstOject['geometry']['lng'];

            return array('lat' => $lat, 'lng' => $lng);
        }

        throw new \Exception($arr['status']['message'], $arr['status']['code']);

    }
}