<?php

namespace astrid\WeatherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use astrid\WeatherBundle\Form\CityType;
use Symfony\Component\HttpFoundation\Request;
use astrid\WeatherBundle\Entity\City;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;


class ForecastController extends Controller
{

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

    	$city = $this->getDoctrine()
    		->getManager()
    		->getRepository('astridWeatherBundle:City')
    		->findOneBy(array('latitude' => $latitude, 'longitude' => $longitude));


    	if($city == false) 
    	{
    		$city = new City();
    		$city->setLatitude($latitude);
    		$city->setLongitude($longitude);
    		$false = true; // since we're setting city to something other than false, we can no longer rely on this condition to carry on
    	}                  // hydrating it. So we have to create a $false variable.

		$weatherConnect = $this->get('astrid_weather.owaconnect.weather');
		$apiResponse = $weatherConnect->getWeatherCoord($city->getLatitude(), $city->getLongitude());

		if($false) // or null?? 
    	{
    		$city->setOwaId($apiResponse['id']);
    		$city->setName($apiResponse['name']);
    		$em = $this->getDoctrine()->getManager();
		    $em->persist($city);
		    $em->flush();
		    print_r('toubidou!!');
    	}
    		
    	$cacher = $this->get('astrid_weather.cacher');
		$weather = $cacher->createCache($apiResponse, $city);

	    $image = $this->getImage($weather);
	
		return $this->render('astridWeatherBundle::weather.html.twig', array('weather' => $weather, 'image' => $image));

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
