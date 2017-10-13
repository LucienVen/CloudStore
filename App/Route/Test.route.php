<?php

$app->post('/test', "\App\Action\Test:test");
$app->get('/test', "\App\Action\Test:info");
