<?php
require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use JSantos\Command\CreateModelCommand;
use JSantos\Command\CreateConfigCommand;
use JSantos\Command\CreateControllerCommand;
use JSantos\Command\ViewsCommand;
use JSantos\Command\RegisterImapCommand;
use JSantos\Command\RegisterMailCommand;
use JSantos\Command\CreateRepositoryCommand;

$console = new Application();
//NEW COMMAND
$console->add(new CreateModelCommand());
$console->add(new CreateConfigCommand());
$console->add(new CreateControllerCommand());
$console->add(new ViewsCommand());
$console->add(new RegisterImapCommand());
$console->add(new RegisterMailCommand());
$console->add(new CreateRepositoryCommand());

//The End Command
$console->run();