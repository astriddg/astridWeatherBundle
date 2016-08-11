<?php

namespace astrid\WeatherBundle\Services;

use astrid\WeatherBundle\Entity\CachedWeather;
use astrid\WeatherBundle\Entity\City;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use astrid\WeatherBundle\Services\Cacher;

class ForecastCacher extends Cacher {

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

		$caches = $this->em
    		->getRepository('astridWeatherBundle:CachedWeather')
    		->findCachedForecast($city);

    	if (!$caches == NULL) {
    		if($this->cacheValid($caches)) {
    			return $cache;
    		}
    		foreach($cache as $cache) {
    			$this->deleteCache($cache);
    		}
    		return false;
    	}
    	return false;
	}

	public function cacheValid($caches) {

		$cache = $caches[0];
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

		$forecast = [];
		for ($i = 0; $i < 5; $i++) {
			$j = $i*8;
			$cache = new CachedWeather();
			$time = new \Datetime($apiResponse['list'][$j]['dt_txt']);
			$cache->setCity($city);
			$cache->setConditions($apiResponse['list'][$j]['weather'][0]['main']);
			$cache->setTemperature($apiResponse['list'][$j]['main']['temp']-273);
			$cache->setHumidity($apiResponse['list'][$j]['main']['humidity']);
			$cache->setDate($time);
			$cache->setDay('f'.$i);
			$this->em->persist($cache);
			$forecast[] = $cache;
		}
	    
	    $this->em->flush();


		return $forecast;
	}


}