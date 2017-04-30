<?php
namespace JSantos\Provider;

use Api\Controller\AuthController;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ControllerServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['auth'] = function (Container $app) {
            return new AuthController($app);
        };
    }
}