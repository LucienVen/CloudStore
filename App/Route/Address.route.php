<?php

// address operation
$app->group('/address', function () {
    $this->get('', "\App\Action\Address:info");
    $this->post('', "\App\Action\Address:add");
    $this->patch('/{address_id}', "\App\Action\Address:updateInfo");
    $this->delete('/{address_id}', "\App\Action\Address:deleteInfo");
})->add("\App\Action\User:checkToken");
