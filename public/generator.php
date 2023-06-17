<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

  @ session_start();
  defined('__APP_TMP__') || define('__APP_TMP__', dirname(__FILE__)."/tmp");
  define('MYSQL_SERVER', 'localhost:3319');
  define('MYSQL_DATABASE_NAME', 'elabreservation');
  define('MYSQL_USERNAME', 'root');
  define('MYSQL_PASSWORD', '');
  include "../vendor/autoload.php";



$NewGen=new Smartedutech\LitelleFrameworkGenerator\Generateur();
 
$NewGen->Modules();
