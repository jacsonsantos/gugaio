<?php
namespace JSantos\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConnectionServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $drive  = CONFIG['DB']['DRIVE'];
        $host   = CONFIG['DB']['HOST'];
        $dbname = CONFIG['DB']['DBNAME'];
        $port   = CONFIG['DB']['PORT'];

        $user     = CONFIG['DB']['USERNAME'];
        $password = CONFIG['DB']['PASSWORD'];

        $dsn = $drive.':host='.$host.';dbname='.$dbname.';port='.$port;
        try {
            $app['connection'] = new \PDO($dsn, $user, $password);
        } catch (\PDOException $e) {
            echo "ERROR IN CONNECTION";die;
        }
    }
}