<?php

namespace astrid\WeatherBundle\Services;

use astrid\WeatherBundle\Services\OwaConnect;

class OwaConnectWeather extends OwaConnect {

	private $type = '/weather';



	public function __construct($url, $apiKey) {

		parent::__construct($url, $apiKey);
	}



	public function getWeatherId($id) {
		// integer test
		$param = '?id='.$id;
		return $this->connectToApi($param);
	}

	public function getWeatherName($name) {
		// strlength
		$name = str_replace(' ', '', $name); // for city names with spaces. E.g. New York
		$name = normalizer_normalize ($name);

		$param = '?q='.$name;
		return $this->connectToApi($param);
	}

	public function getWeatherCoord($latitude, $longitude) {
		// integer test

		$param = '?lat='.$latitude.'&lon='.$longitude ;
		return $this->connectToApi($param);


	}

	public function connectToApi($param) {
		$apiUrl = $this->url.$this->type.$param.$this->apiKey;

		$apiResponse = file_get_contents($apiUrl);
		$apiResponse = json_decode($apiResponse, true);


		if ($apiResponse['cod'] == 200) {
			return $apiResponse;
		}
		else {
			return false;
		}
		

	}

}