<?php

// Middleware Configuration

$container = $app->getContainer();

$container['newcookie'] = function ($c) {
    return new \Slim\Http\Cookies();
};

$container['cookie'] = function ($c) {
    return $c->get('request')->getCookieParams();
};

$container['jwt'] = function ($c) {
    return (array) Firebase\JWT\JWT::decode($c->get('cookie')['token'], \Core\Config::get('secret'), array('HS256'));
};
