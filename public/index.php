<?php
chdir(dirname(__DIR__));
require_once "vendor/autoload.php";

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use Silex\Application;
try {
    define("CONFIG", Yaml::parse(file_get_contents('config.yml')));
} catch (ParseException $e) {
    echo $e->getMessage();
    echo "Error in Config";die;
}
    $app = new Application;

    $app['debug'] = CONFIG['DEBUG'];
    $app['api_version'] = CONFIG['VERSION'];

    $app['signer'] = new Lcobucci\JWT\Signer\Hmac\Sha256();
    $app['remote'] = CONFIG['TOKEN']['REMOTE'];
    $app['iss'] = empty(CONFIG['TOKEN']['ISS']) ? $_SERVER['SERVER_NAME'] : CONFIG['TOKEN']['ISS'];
    $app['jti'] = CONFIG['TOKEN']['JTI'];
    $app['expires'] = CONFIG['TOKEN']['EXPIRES'];
    $app['secret'] = CONFIG['TOKEN']['SECRET'];

    require "config/register.php";

    $app->run();