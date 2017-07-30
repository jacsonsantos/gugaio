<?php
namespace JSantos\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class EventServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        require(__DIR__.'/../../config/listener.php');
    }
}