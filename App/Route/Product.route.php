<?php

$app->group('/product', function() {
    $this->get('', "\App\Action\Product:simpleInfo");
    $this->get('/search', "\App\Action\Product:searchOptInfo");
    $this->post('/search', "\App\Action\Product:search");
    $this->get('/{spu_id}', "\App\Action\Product:detailInfo");
});

$app->group('/product', function () {
    $this->post('', "\App\Action\Product:add");
// })->add("\App\Action\User:checkRoot");
});
