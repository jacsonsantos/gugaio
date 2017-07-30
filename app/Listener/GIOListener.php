<?php
namespace JSantos\Listener;

use Pimple\Container;

class GIOListener
{
    protected $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }
}