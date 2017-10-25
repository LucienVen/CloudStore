<?php

$app->group('/media', function () {
    $this->post('/desc', "\App\Action\Media:detailFileUpload");
});
