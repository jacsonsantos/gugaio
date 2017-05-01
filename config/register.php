<?php
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new JDesrosiers\Silex\Provider\CorsServiceProvider(), [
    'cors.allowOrigin' => '*',
    'cors.allowMethods' => 'POST,PUT,DELETE, OPTIONS',
    'cors.allowHeaders' => 'Content-Type, Authorization,Access-Control-Allow-Origin'
]);
$app->register(new JSantos\Provider\RouterServiceProvider());
$app->register(new JSantos\Provider\ControllerServiceProvider());
$app->register(new JSantos\Provider\JWTServiceProvider());
$app->register(new JSantos\Provider\ConnectionServiceProvider());
$app->register(new JSantos\Provider\DataBaseServiceProvider());