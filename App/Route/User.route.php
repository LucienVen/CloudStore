<?php

// log operation
$app->group('/auth', function () {
    $this->post('', "\App\Action\User:login");
    $this->delete('', "\App\Action\User:logout");
});

// sign up
$app->post('/user', "\App\Action\User:signup");

// user operation
$app->group('/user', function () {
    // TODO
    $this->get('[/{id}]', "\App\Action\User:info");
    $this->patch('/{id}', "\App\Action\User:update");

    // order operation
    $this->get('/orders', "App\Action\Order:info");
    $this->post('/orders', "App\Action\Order:add");
    $this->patch('/orders', "App\Action\Order:changeStatus");
    $this->delete('/orders', "App\Action\Order:delete");

    // address operation
    $this->get('/address', "App\Action\User:addressInfo");
    $this->post('/address', "App\Action\User:addAddress");
    $this->patch('/address', "App\Action\User:updateAddress");
    $this->delete('/address', "App\Action\User:deleteAddress");
})->add("\App\Action\User:checkToken");
