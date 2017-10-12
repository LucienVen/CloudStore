<?php

// define const value
define('ROOT_PATH', substr(__DIR__, 0, strrpos(__DIR__, "/")));
define("SERVER_URL", preg_split("/\/public/", dirname($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['PHP_SELF']))[0]);
define('PUBLIC_PATH', APP_PATH.'/../public');

// load composer vendor
require __DIR__.'/../vendor/autoload.php';
// load PDO
require "FluentPDO/FluentPDO.php";
// load custom exception class
require CORE_PATH."/DefException.php";
set_exception_handler("DefException::handle");

// load autoload class
require CORE_PATH."/Autoload.php";
spl_autoload_register("Autoload::load");

// load config file
\Core\Config::load(SETTING_PATH);
