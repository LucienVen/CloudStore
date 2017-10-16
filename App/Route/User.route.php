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
    $this->get('', "\App\Action\User:info");
    $this->patch('', "\App\Action\User:update");
})->add("\App\Action\User:checkToken");
