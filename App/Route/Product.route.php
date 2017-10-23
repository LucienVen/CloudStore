<?php

$app->group('/product', function() {
    $this->get('', "\App\Action\SKU:simpleInfo");
    $this->get('/search', "\App\Action\SKU:searchOptInfo");
    $this->post('/search', "\App\Action\SKU:search");
    $this->get('/{spu_id}', "\App\Action\SKU:detailInfo");
})->add('\App\Action\User:checkToken');
