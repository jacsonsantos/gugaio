<?php
require __DIR__.'/../vendor/autoload.php';

use JSantos\Command\CreateModelCommand;
use Symfony\Component\Console\Application;

$console = new Application();
//NEW COMMAND
$console->add(new CreateModelCommand());

$console->run();