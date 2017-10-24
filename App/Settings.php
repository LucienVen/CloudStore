<?php

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'determineRouteBeforeAppMiddleware' => true,
    ],
    // database setting
    'db' => [
        'host' => '127.0.0.1',
        'user' => 'root',
        'pass' => '0212',
        'dbname' => 'cloudstore',
        'prefix' => '',
    ],
    // JWT token setting
    'secret' => 'yvenchang',
    'jwt' => [
        'iss' => 'www.yvenchang.xyz',
    ],
    'page_limit' => 10,
    'pay_limit' => 1800,
    'order_type' => [
        'web' => '1',
        'app' => '2'
    ],
    'freight_limit' => 100,
    'freight' => 10
];
