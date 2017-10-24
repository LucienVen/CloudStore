<?php

$app->group('/cart', function () {
    $this->get('', "\App\Action\Cart:info");
    $this->post('', "\App\Action\Cart:add");
    $this->patch('', "\App\Action\Cart:updateInfo");
    $this->delete('/{cart_id}', "\App\Action\Cart:deleteInfo");
})->add("\App\Action\User:checkToken");
