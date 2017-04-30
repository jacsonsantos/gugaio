<?php
namespace JSantos\Provider;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container as DBContainer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class DataBaseServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $capsule = new Manager();
        $capsule->addConnection([
            'driver'    => $app['db.driver'] ?? CONFIG['DB']['DRIVE'],
            'host'      => $app['db.host'] ?? CONFIG['DB']['HOST'],
            'database'  => $app['db.database'] ?? CONFIG['DB']['DBNAME'],
            'username'  => $app['db.username'] ?? CONFIG['DB']['USERNAME'],
            'password'  => $app['db.password'] ?? CONFIG['DB']['PASSWORD'],
            'charset'   => $app['db.charset'] ?? CONFIG['DB']['CHARSET'],
            'collation' => $app['db.collation'] ?? CONFIG['DB']['COLLATION'],
            'prefix'    => $app['db.prefix'] ?? CONFIG['DB']['PREFIX'],
        ]);
        $capsule->setEventDispatcher(new Dispatcher(new DBContainer));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $app['capsule'] = $capsule;
    }
}