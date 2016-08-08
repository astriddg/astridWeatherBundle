<?php

namespace astrid\WeatherBundle\Services;

use astrid\WeatherBundle\Entity\CachedWeather;
use astrid\WeatherBundle\Entity\City;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class Cacher {

	private $lapse = '1 hour';

	/**
     * @var EntityManagerInterface
     */
    private $em;

    // On injecte l'EntityManager
    public function __construct(EntityManagerInterface $em)
    {
    	$this->em = $em;
    }


	public function cacheExists(City $city) {

		$cache = $this->em
    		->getRepository('astridWeatherBundle:CachedWeather')
    		->findOneBy(array('city' => $city));

    	if (!$cache == NULL) {
    		if($this->cacheValid($cache)) {
    			return $cache;
    		}
    		$this->deleteCache($cache);
    		return false;
    	}
    	return false;
	}

	public function cacheValid($cache) {

		$expiryDate = date_add($cache->getCreationDate(), date_interval_create_from_date_string($this->lapse));
		$now = new \Datetime;

		if ( $expiryDate > $now) {
			return true;
		}
		return false;
	}

	public function deleteCache($cache){
		$this->em->remove($cache);
		$this->em->flush();
	}

	public function createCache($apiResponse, City $city) {
		$cache = new CachedWeather();
		$cache->setCity($city);
		$cache->setConditions($apiResponse['weather'][0]['main']);
		$cache->setTemperature($apiResponse['main']['temp']-273);
		$cache->setHumidity($apiResponse['main']['humidity']);
	    $this->em->persist($cache);
	    $this->em->flush();
		return $cache;
	}


}