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
    $cookie = $c->get('cookie');
    if (isset($cookie['token']) && !empty($cookie['token'])) {
        $jwt = (array) Firebase\JWT\JWT::decode($cookie['token'], \Core\Config::get('secret'), array('HS256'));

        return $jwt;
    }

    return false;
};
