<?php

namespace astrid\WeatherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use astrid\WeatherBundle\Form\CityType;
use Symfony\Component\HttpFoundation\Request;
use astrid\WeatherBundle\Entity\City;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use astrid\WeatherBundle\Exceptions\CityDuplicateException;


class ForecastController extends Controller
{

    private $days = ['today', 'tomorrow', 'in two days', 'in three days', 'in four days'];

    public function idForecastAction(City $city) {
    	$cacher = $this->get('astrid_weather.forecastcacher'); 

    	$weather = $cacher->cacheExists($city); // checking first if the weather has been cached. If yes, the weather is returned.

    	if ($weather == false) { //  if not, the service returns false and  we connect to the API.
    		$weatherConnect = $this->get('astrid_weather.owaconnect.forecast');
    		$apiResponse = $weatherConnect->getWeatherId($city->getOwaId()); // ID connection
    		$weather = $cacher->createCache($apiResponse, $city);
    	}

    	$images = $this->getImage($weather); // We get the right image for the given weather.

    	return $this->render('astridWeatherBundle::forecast.html.twig', array('weather' => $weather, 'images' => $images, 'days' => $this->days));
    }


    public function coordForecastAction(Request $request) {

    	$latitude = $_GET['lat'];
    	$longitude = $_GET['long'];            

		$weatherConnect = $this->get('astrid_weather.owaconnect.weather');
		$apiResponse = $weatherConnect->getWeatherCoord($latitude, $longitude);

        $city = $this->getDoctrine()
            ->getManager()
            ->getRepository('astridWeatherBundle:City')
            ->findOneBy(array('owaId' => $apiResponse['id']));

        if($city == false) 
        {
            $city = new City();
            $city->setLatitude($latitude);
            $city->setLongitude($longitude);
            $city->setOwaId($apiResponse['id']);
            $city->setName($apiResponse['name']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($city);
            $em->flush();
        }

    		
    	$cacher = $this->get('astrid_weather.cacher');
		$weather = $cacher->createCache($apiResponse, $city);

	    $image = $this->getImage($weather);
	
		return $this->render('astridWeatherBundle::weather.html.twig', array('weather' => $weather, 'image' => $image));

    	}



    public function getImage($forecast) {
        $images = [];

        foreach($forecast as $forecast) {
            switch($forecast->getConditions()) { // load different images depending on weather.
            case 'Clear':
                $images[] = 'bundles/astridweather/images/clear.jpg'; 
            break;
            case 'Clouds':
                $images[] = 'bundles/astridweather/images/clouds.jpg'; 
            break;
            case 'Rain':
                $images[] = 'bundles/astridweather/images/rain.jpg'; 
            break;
            case 'Snow':
                $images[] = 'bundles/astridweather/images/snow.jpg'; 
            break;
            }
        }

        return $images;


    }
 }
