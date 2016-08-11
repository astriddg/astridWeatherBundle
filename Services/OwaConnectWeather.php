<?php

namespace astrid\WeatherBundle\Services;

use astrid\WeatherBundle\Services\OwaConnect;

class OwaConnectWeather extends OwaConnect {

	public static $type = '/weather';



	public function __construct($url, $apiKey) {

		parent::__construct($url, $apiKey);
	}





}