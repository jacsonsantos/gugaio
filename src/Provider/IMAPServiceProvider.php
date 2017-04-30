<?php
namespace JSantos\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Ddeboer\Imap\Server;

class IMAPServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['imap.connection'] = function () {
            $server = new Server(
                CONFIG['IMAP']['HOSTNAME'],
                CONFIG['IMAP']['PORT'],
                CONFIG['IMAP']['FLAGS'],
                CONFIG['IMAP']['PARAMETERS']
            );

            return $server->authenticate(CONFIG['USER']['USERNAME'], CONFIG['USER']['PASSWORD']);
        };
    }
}