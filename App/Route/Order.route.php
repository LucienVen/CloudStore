<?php

// order operation
$app->group('/orders', function () {
    $this->get('[/{order_id}]', "\App\Action\Orders:info");
    $this->post('', "\App\Action\Orders:create");
    $this->patch('/{order_id}', "\App\Action\Orders:check");
    $this->delete('/{order_id}', "\App\Action\Orders:deleteOrder");
    $this->patch('/{order_id}/express', "\App\Action\Orders:express");
    $this->get('/{order_id}/payment', "\App\Action\Orders:payInfo");
})->add("\App\Action\User:checkToken");

$app->post('/trade', "\App\Action\Orders:payReturn");
