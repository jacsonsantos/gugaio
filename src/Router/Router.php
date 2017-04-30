<?php
$app->mount($app['api_version'], function ($router) use ($app) {
    /**
     * Example Users
     */
    $router->get('/users', function () {
        return JSantos\Model\User::all();
    });

//    $router->get('/users', 'user:index');
//    $router->get('/users/{id}', 'user:read');
//    $router->post('/users', 'user:create');
//    $router->put('/users', 'user:update');
//    $router->delete('/users/{id}', 'user:delete');

});