<?php
namespace JSantos\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $token = [];
        $saved = false;

        $data = $request->request->all();

        if ($saved) {
            $token  = $this->app['jwt']->generateToken();
        }

        return new JsonResponse($token);
    }
    public function logout(Request $request)
    {
        return new JsonResponse([]);
    }
}