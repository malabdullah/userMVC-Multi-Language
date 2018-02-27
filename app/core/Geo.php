<?php

namespace App\Core;

class Geo {

	protected $api = 'http://ip-api.com/json/';
	protected $properties = [];

	public function __get($key){

		if (isset($this->properties[$key])) {

			return $this->properties[$key];
		}

		return false;
	}

	public function request($ip){

		$url = $this->api . $ip;
		$data = $this->sendRequest($url);

		$this->properties = json_decode($data,true);
	}

	protected function sendRequest($url){

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_URL, $url);

		return curl_exec($curl);
	}
}