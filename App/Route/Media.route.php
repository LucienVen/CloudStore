<?php

$app->group('/media', function () {
    $this->post('', "\App\Action\Media:detailFileUpload");
});
