<?php

$app->group('/product', function() {
    $this->get('', "\App\Action\SKU:simpleInfo");
    $this->get('/{spu_id}', "\App\Action\SKU:detailInfo");
})->add('\App\Action\User:checkToken');
