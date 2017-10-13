<?php

// application config file
define("APP_PATH", __DIR__."/../App");

// config path
define('SETTING_PATH', APP_PATH.'/Settings.php');
// framework core path
define("CORE_PATH", __DIR__."/../Core");

// init framework
require CORE_PATH."/Init.php";

// define slim app variable name
$app = \Core\Start::getApp();

// start framework
require __DIR__."/start.php";
