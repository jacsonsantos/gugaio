<?php
require __DIR__.'/../vendor/autoload.php';

use JSantos\Command\CreateModelCommand;
use JSantos\Command\CreateConfigCommand;
use Symfony\Component\Console\Application;

$console = new Application();
//NEW COMMAND
$console->add(new CreateModelCommand());
$console->add(new CreateConfigCommand());

$console->run();