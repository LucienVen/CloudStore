<?php

$app->post('/test', "\App\Action\Test:test");
$app->get('/user', "\App\Action\Test:info");
