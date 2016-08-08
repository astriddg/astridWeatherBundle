<?php

namespace astrid\WeatherBundle\Services;

use astrid\WeatherBundle\Services\OwaConnect;

class OwaConnectForecast extends OwaConnect {

	private $type = '/forecast';



	public function __construct($url, $apiKey) {

		parent::__construct($url, $apiKey);
	}



	public function getWeatherId($id) {

	}

	public function getWeatherName($name) {

	}

	public function getWeatherCoord($latitude, $longitude) {
		
	}

	public function connectToApi($param)
}