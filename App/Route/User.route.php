<?php

$app->group('/auth', function() {
    $this->post('', "\App\Action\User:login");
    $this->delete('', "\App\Action\User:logout");
});

$app->group('/user', function() {
    $this->get('[/{id}]', "\App\Action\User:info");
    $this->post('', "\App\Action\User:signup");
    $this->put('/{id}', "\App\Action\User:update");
});
