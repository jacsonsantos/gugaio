<?php
$app->mount('/', function ($router) use ($app) {
    $router->get('/', 'home:index');

});