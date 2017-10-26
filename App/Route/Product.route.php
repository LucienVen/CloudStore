<?php

$app->group('/product', function() {
    $this->get('', "\App\Action\Product:simpleInfo");
    $this->get('/search', "\App\Action\Product:searchOptInfo");
    $this->post('/search', "\App\Action\Product:search");
    $this->get('/{spu_id}', "\App\Action\Product:detailInfo");
    $this->get('/sku/{sku_id}', "\App\Action\Product:info");
});

$app->group('/product/sku', function () {
    $this->patch('/{sku_id}', "\App\Action\Product:updateSKU");
// })->add("\App\Action\User:checkRoot");
});

$app->group('/product/spu', function () {
    $this->post('', "\App\Action\Product:add");
// })->add("\App\Action\User:checkRoot");
});
