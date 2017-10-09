<?php

// application path, can be edit
define("APP_PATH", __DIR__."/../App");
// framework core path
define("CORE_PATH", __DIR__."/../Core");
define('ROOT_PATH', substr(__DIR__, 0, strrpos(__DIR__, "/")));
// init framework
require CORE_PATH."/Init.php";

require CORE_PATH."/DefException.php";
set_exception_handler("\Core\DefException::handle");

// define slim app variable
$app = \Core\Start::getApp();

// require CORE_PATH."/Autoload.php";
// \Core\Autoload::load("\App\Action\Test");


// start framework
require __DIR__."/start.php";
