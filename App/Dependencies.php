<?php

// Middleware Configuration

$container = $app->getContainer();

$container['newcookie'] = function ($c) {
    return new \Slim\Http\Cookies();
};

$container['cookie'] = function ($c) {
    return new \Slim\Http\Cookies($c->get('request')->getCookieParams());
};
