<?php
namespace JSantos\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends Controller
{
    public function index()
    {
        return $this->app['twig']->render('index.twig',[]);
    }
}