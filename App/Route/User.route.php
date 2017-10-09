<?php

$app->get('/user', "\App\Action\User:login");
$app->post('/user', "\App\Action\User:signup");
