<?php
$app->mount($app['api_version'].'/auth', function ($auth) use ($app) {

    $auth->post('/login', 'auth:login');
    $auth->post('/logout', 'auth:logout');

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