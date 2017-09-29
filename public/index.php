<?php

define("APP_PATH", __DIR__."/../App");
define("CORE_PATH", __DIR__."/../Core");
require CORE_PATH."/Init.php";


$app = \Core\Start::getApp();


require __DIR__."/start.php";
