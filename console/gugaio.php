<?php
require __DIR__.'/../vendor/autoload.php';

use JSantos\Command\CreateModelCommand;
use JSantos\Command\CreateConfigCommand;
use JSantos\Command\CreateControllerCommand;
use Symfony\Component\Console\Application;

$console = new Application();
//NEW COMMAND
$console->add(new CreateModelCommand());
$console->add(new CreateConfigCommand());
$console->add(new CreateControllerCommand());

$console->run();