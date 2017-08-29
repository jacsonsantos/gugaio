<?php
$app->mount('/', function ($router) use ($app) {
    $router->get('/', function (){
        return "index";
    });

});