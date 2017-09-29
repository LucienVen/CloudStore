<?php

// application path, can be edit
define("APP_PATH", __DIR__."/../App");
// framework core path
define("CORE_PATH", __DIR__."/../Core");
// init framework
require CORE_PATH."/Init.php";


// define slim app variable
$app = \Core\Start::getApp();


// start framework
require __DIR__."/start.php";
