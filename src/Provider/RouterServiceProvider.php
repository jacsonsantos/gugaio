<?php
namespace JSantos\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RouterServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        require(__DIR__.'/../Router/Router.php');
        require(__DIR__.'/../Router/RouterAuth.php');

        $app->after($app['cors']);
    }
}