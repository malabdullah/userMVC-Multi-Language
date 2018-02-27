<?php
//start session
session_start();

//autoload all classes,files and vendor classes
require_once __DIR__ . '/../vendor/autoload.php';

//initializing error reporting
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

//initializing phpdotenv to use .env file
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

//initializing Geo class to get user time zone
$geo = new \App\Core\Geo;
//get user IP address
$ip = getRealIP();
$geo->request($ip);
//check if ip not from localhost
if ($ip != '::1'){
	date_default_timezone_set($geo->timezone);	
}

//require config file
require_once __DIR__ . '/../app/config/config.php';

//define the global language variable for all view pages
$l = [];

//begin routing
$bootstrap = new App\Core\Bootstrap;