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


class WeatherController extends Controller
{
    public function indexAction()
    {
    	$cities = $this->getDoctrine() // getting all the stored citites.
    		->getManager()
    		->getRepository('astridWeatherBundle:City')
    		->findall();

        return $this->render('astridWeatherBundle::index.html.twig', array('cities' => $cities));
    }

    public function idWeatherAction(City $city) {
    	$cacher = $this->get('astrid_weather.cacher'); 

    	$weather = $cacher->cacheExists($city); // checking first if the weather has been cached. If yes, the weather is returned.

    	if ($weather == false) { //  if not, the service returns false and  we connect to the API.
    		$weatherConnect = $this->get('astrid_weather.owaconnect.weather');
    		$apiResponse = $weatherConnect->getWeatherId($city->getOwaId()); // ID connection
    		$weather = $cacher->createCache($apiResponse, $city);
    	}

    	$image = $this->getImage($weather); // We get the right image for the given weather.
    	
    	return $this->render('astridWeatherBundle::weather.html.twig', array('weather' => $weather, 'image' => $image));
    }

    public function nameWeatherAction(Request $request) {
    	$city = new City(); // Here we create a new city based on request.
    	$form   = $this->get('form.factory')->create(CityType::class, $city);

    	if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
    		$weatherConnect = $this->get('astrid_weather.owaconnect.weather'); // get the API connection service
    		$apiResponse = $weatherConnect->getWeatherName($city->getName()); // get data

    		$city->setOwaId($apiResponse['id']); // hydrate the city object.
    		$city->setLatitude($apiResponse['coord']['lat']);
    		$city->setLongitude($apiResponse['coord']['lon']);
    		$em = $this->getDoctrine()->getManager();
		    $em->persist($city);
		    $em->flush();

		    $cacher = $this->get('astrid_weather.cacher');
    		$weather = $cacher->createCache($apiResponse, $city); // cache data

    		$image = $this->getImage($weather); // add image to the view
    	
    		return $this->render('astridWeatherBundle::weather.html.twig', array('weather' => $weather, 'image' => $image));

    	}
    	return $this->render('astridWeatherBundle::add.html.twig', array(
        'form' => $form->createView(),
    	));
    }

    public function coordWeatherAction(Request $request) {

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

	public function deleteAction(City $city) {

		$cacher = $this->get('astrid_weather.cacher'); // check that this city really does exist.
		$weather = $cacher->cacheExists($city); // check if there are caches associated with it.

		while($weather) { // if so, delete them.
			$cacher->deleteCache($weather);
            $weather = $cacher->cacheExists($city);
		}

        $cacher = $this->get('astrid_weather.forecastcacher'); // check that this city really does exist.
        $weather = $cacher->cacheExists($city); // check if there are caches associated with it.

        while($weather) { // if so, delete them.
            $cacher->deleteCache($weather);
            $weather = $cacher->cacheExists($city);
        }

		$em = $this->getDoctrine()->getManager(); // delete the city
	    $em->remove($city);
	    $em->flush();

	    $url = $this->get('router')->generate('astrid_weather_homepage'); // go back to homepage.

		return new RedirectResponse($url);

	}

    public function getImage($weather) {
    	switch($weather->getConditions()) { // load different images depending on weather.
    		case 'Clear':
    			return 'bundles/astridweather/images/clear.jpg'; 
    		break;
    		case 'Clouds':
    			return 'bundles/astridweather/images/clouds.jpg'; 
    		break;
    		case 'Rain':
    			return 'bundles/astridweather/images/rain.jpg'; 
    		break;
    		case 'Snow':
    			return 'bundles/astridweather/images/snow.jpg'; 
    		break;
    	}

    }
 }
