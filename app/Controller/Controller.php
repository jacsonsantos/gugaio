<?php
namespace JSantos\Controller;

use Pimple\Container;

abstract class Controller
{
    protected $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }
}