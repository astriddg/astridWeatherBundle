<?php

namespace astrid\WeatherBundle\Services;

use astrid\WeatherBundle\Services\OwaConnect;

class OwaConnectForecast extends OwaConnect {

	public static $type = '/forecast';



	public function __construct($url, $apiKey) {

		parent::__construct($url, $apiKey);
	}
}