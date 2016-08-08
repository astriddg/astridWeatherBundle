<?php

namespace astrid\WeatherBundle\Services;

abstract class OwaConnect {

	protected $url;
	protected $apiKey;


	public function __construct($url, $apiKey) {
		$this->url = $url;
		$this->apiKey = '&APPID='.$apiKey;
	}



	abstract public function getWeatherId($id) ;

	abstract public function getWeatherName($name) ;

	abstract public function getWeatherCoord($latitude, $longitude) ;

	abstract public function connectToApi($param) ;
}