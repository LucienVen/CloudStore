<?php

$app->get('/test', "\App\Action\Test:test1");
$app->get('/test/{name}', "\App\Action\Test:test");
