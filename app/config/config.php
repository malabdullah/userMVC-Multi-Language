<?php

define('ROOTPATH',getenv('ROOTPATH'));
define('DS',DIRECTORY_SEPARATOR);
define('APPPATH',dirname(dirname(dirname(__FILE__))) . DS .'app');
define('CACHEPATH', DS . 'app' . DS . 'cache');
define('PUBLICPATH',dirname(dirname(dirname(__FILE__))) . DS . 'public');
define('SITENAME', getenv('SITENAME'));
define('SECRET_KEY', getenv('SECRET_KEY'));

define('DBHOST',getenv('DBHOST'));
define('DBUSER',getenv('DBUSER'));
define('DBPASS',getenv('DBPASS'));
define('DBNAME',getenv('DBNAME'));
define('DBTYPE',getenv('DBTYPE')); //mysql, mssql, oracle ..

define('MAILHOST',getenv('MAILHOST'));
define('MAILUSER',getenv('MAILUSER'));
define('MAILPASS',getenv('MAILPASS'));
define('MAILPORT',getenv('MAILPORT'));
define('SMTPSECURE',getenv('SMTPSECURE'));
define('MAILFROM',getenv('MAILFROM'));
define('MAILFROMNAME',getenv('MAILFROMNAME'));