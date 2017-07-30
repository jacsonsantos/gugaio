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

        $app->mount($app['api_version'].'/api', function ($auth) use ($app) {
            require(__DIR__.'/../Router/RouterAuth.php');

            $auth->before(function (Request $request) use ($app) {
                $token = $request->headers->get('Authorization');
                $token = trim(str_replace('Bearer ', '', $token));

                $jwt = $app['jwt'];
                $jwt->setApplication($app);

                if (!$jwt->validateToken($token)) {
                    $response = new JsonResponse(['token invalid'],401);
                    return $response;
                }
            });
        });

        $app->after($app['cors']);
    }
}