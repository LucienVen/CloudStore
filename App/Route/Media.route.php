<?php

$app->group('/media', function () {
    $this->post('', "\App\Action\Media:upload");
    $this->post('/desc', "\App\Action\Media:detailFileUpload");
});
