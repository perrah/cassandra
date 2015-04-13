<?php
session_start();
//file includes 
$setup_configs = require('config/setup-config.php');
$db_configs = require('config/db-config.php');
/*
    The Config file allows for global settings in the project.
*/		
$config = array(
    //url path addresses in an easy to edit system
    "urls" => array(
    	"root_path" =>  $_SERVER['DOCUMENT_ROOT']."/cassandra", //root_path is for includes or require
        "public" => "http://localhost/cassandra", //references i.e. href or POST action
        "functions" => "/application/functions",
        "modules" => "/application/modules",
        "services" => "/application/services",
        "resources" => "/res",
        "scripts" => "/application/scripts",
    	)
    );
//set constants from the array set above for URLs
defined("TEMPLATES_PATH")
    or define("TEMPLATES_PATH", realpath(dirname(__FILE__)  . '/templates'));

defined("ROOT_PATH")
    or define("ROOT_PATH",  $config['urls']['root_path']);

defined("PUBLIC_PATH")
    or define("PUBLIC_PATH",  $config['urls']['public'].'/public');

	
defined("CONFIG_PATH")
    or define("CONFIG_PATH",   $config['urls']['root_path'].$config['urls']['resources'].'/config');
	
defined("BASE_URL")
    or define("BASE_URL",  $config['urls']['public']);

defined("RESOURCE_PATH")
    or define("RESOURCE_PATH",  $config['urls']['root_path'].$config['urls']['resources']);

defined("SCRIPT_PATH")
    or define("SCRIPT_PATH",  $config['urls']['public'].$config['urls']['scripts']);

defined("DATA")
    or define("DATA",   $config['urls']['root_path'].$config['urls']['resources'].'/data');
	
defined("SETUP")
    or define("SETUP",  $setup_configs['setup']);

defined("ADMIN")
    or define("ADMIN",  $setup_configs['admin']);

defined("HOST")
    or define("HOST",  $db_configs['host']);

defined("DATABASE")
    or define("DATABASE",  $db_configs['database']);

defined("USERNAME")
    or define("USERNAME",  $db_configs['username']);

defined("PASSWORD")
    or define("PASSWORD",  $db_configs['password']);

//include listings
require($config['urls']['root_path'].$config['urls']['services'].'/services.php');
//REDIRECT FUNCTION
function redirect($url){
    printf('<script>location.href="'.$url.'";</script>');
}


?>