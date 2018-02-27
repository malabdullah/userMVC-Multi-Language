<?php

namespace App\Core;

class Bootstrap {

	protected $url;
	protected $lang = 'en'; 			//set default language
	protected $languages = ['en','ar'];
	protected $controller = 'users';
	protected $method = 'index';
	protected $params = [];

	public function __construct(){

		if (isset($_REQUEST['url'])){

			$this->url = $this->getURL();
			
			if (isset($this->url[0]) && !empty($this->url[0])){

				$this->controller = ucfirst($this->url[0]);

				if (!file_exists(APPPATH . '/controllers/' . $this->controller . '.php')){

					$this->controller = 'NotFound';
				}

				unset($this->url[0]);
			}

			$class = 'App\\Controllers\\' . $this->controller;
			$obj = new $class;	

			if (isset($this->url[1]) && $this->controller != 'NotFound'){

				$this->method = ucwords($this->url[1]);

				if (!method_exists($obj, $this->method)){
					
					$this->controller = 'NotFound';
					$this->method = 'index';
				}

				unset($this->url[1]);
			}
		}

		//check if language exists in query string
		if (isset($_GET['lang']) && !empty($_GET['lang'])){

			//check if value is in the languages array
			if (in_array($_GET['lang'],$this->languages)){

				//set the language
				$this->lang = $_GET['lang'];
				setcookie('lang',$this->lang,time() + 60 * 60 * 24 * 30,'/');
			}
		}else{

			//check if language cookie already set
			if (checkIfCookieSet('lang')){

				$this->lang = $_COOKIE['lang'];
			}else {

				//save language in cookie
				setcookie('lang',$this->lang,time() + 60 * 60 * 24 * 30,'/');
				$_COOKIE['lang'] = $this->lang;
			}
		}

		//set and read languages files
		$this->setLanguage();

		$class = '\\App\\Controllers\\' . $this->controller;
		$obj = new $class;
		$method = $this->method;

		if (!empty($this->url)){
			
			$this->params = $this->url;
			$obj->$method($this->params);
		
		}else {

			$obj->$method();
		}
	}

	protected function getURL(){

		$url = $_REQUEST['url'];
		$url = rtrim($url,'/');
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = explode('/',$url);

		return $url;
	}

	protected function setLanguage(){

		global $l;

		foreach($this->languages as $dir){
			
			$dir_name = '..' . DS . 'app' . DS . 'cache' . DS . 'lang' . DS . $dir;

			if (!is_dir($dir_name)){
				mkdir($dir_name,0777);
			}
		}

		$file_name = '..' . DS . 'app' . DS . 'cache' . DS . 'lang' . DS . $this->lang . DS . 'lang.txt';

		if (!is_file($file_name)){
			file_put_contents($file_name,'');
		}

		$file_expiry = filemtime($file_name) + 60 * 60 * 24 * 30;

		if (!filesize($file_name) || $file_expiry < time()){
			
			$lang_arr = new \App\Core\Language($this->languages);
			$lang_arr->getAll();
		}

		$lang_arr = readFromFile($file_name);

		foreach($lang_arr as $row){

			$row = explode('=',$row);

			if (check($row[0]) && check($row[1])){
				$l[$row[0]] = $row[1];
			}
		}
	}
}