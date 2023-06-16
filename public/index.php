<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

  @ session_start();
  defined('__APP_PATH__') || define('__APP_PATH__', dirname(__FILE__)."/..");

  include "../vendor/autoload.php";

if(!isset($_GET["activity"])){
	$_GET['activity']="inscription";
}
use Smartedutech\Littlemvc\mvc\Configuration;
use Smartedutech\Littlemvc\mvc\Application;
use Smartedutech\Littlemvc\dbadapter;

Configuration::config();
dbadapter::connect();


$MonApp = new Application();
$MonApp->Run();
