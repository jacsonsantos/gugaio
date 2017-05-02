<?php
namespace JSantos\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterControllerCommand extends Command
{
    use CommandTrait;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->path = __DIR__.'/../../config/';
    }

    protected function configure()
    {
        $this->setName('register:controller')
             ->setDescription('Register a new service Controller')
             ->setHelp('To create a new Controller use: php gugaio register:controller MyController --name=my')
             ->addArgument('controller', InputArgument::REQUIRED, 'The name of the Controller.')
            ->addOption('name',null,InputOption::VALUE_REQUIRED,'The name of the Service Controller');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $msg = "";
        $controller = $input->getArgument('controller');
        $controller = $this->manipulation($controller);
        $controller = str_replace('/','\\',$controller);

        $name = $input->getOption('name');
        $service = $name ?? $controller;

        $content = "\n\n".'$app[\''.strtolower($service).'\'] = function (Pimple\Container $app) {'.
                    "\n\t".'return new JSantos\\Controller\\'.$controller.'($app);'.
                    "\n".'};';

        if(file_exists($this->path.'controller.php'))
        {
            $msg = "Register with success!";
            if(!file_put_contents($this->path.'controller.php',$content,FILE_APPEND)) {
                $msg = "Error to register new Controller";
            }
        }

        $output->writeln($msg);
    }
}