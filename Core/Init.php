<?php
// session_start();

// load composer vendor
require __DIR__.'/../vendor/autoload.php';

// load PDO
require "FluentPDO/FluentPDO.php";

// define const value
define("SERVER_URL", preg_split("/\/public/", dirname($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['PHP_SELF']))[0]);
define('SETTING_PATH', APP_PATH.'/Settings.php');
define('PUBLIC_PATH', APP_PATH.'/../public');


// load core file
require CORE_PATH."/Config.php";
require CORE_PATH."/Action.php";
require CORE_PATH."/Validate.php";
require CORE_PATH."/Model.php";
require CORE_PATH."/Start.php";

// load config file
\Core\Config::load(SETTING_PATH);
