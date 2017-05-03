<?php
namespace JSantos\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateRouterCommand extends Command
{
    use CommandTrait;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->path = __DIR__.'/../Router/';
    }

    protected function configure()
    {
        $this->setName('make:router')
             ->setDescription('Create a new Router')
             ->setHelp('To Create a new Router, use: --method')
             ->addArgument('router', InputArgument::REQUIRED, 'The name of the Router.')
             ->addOption('method',null,InputOption::VALUE_REQUIRED,'The Method HTTP of the Router')
             ->addOption('service',null,InputOption::VALUE_REQUIRED,'The Service there Controller of the Router')
             ->addOption('group',null,InputOption::VALUE_REQUIRED,'The Group of the Router')
             ->addOption('auth',null,InputOption::VALUE_OPTIONAL,'The Authentication of the Router',false);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $msg = "";
        $router = $input->getArgument('router');
        $method = $input->getOption('method');
        $service = $input->getOption('service');
        $group = $input->getOption('group');
        $auth = $input->getOption('auth');
        $file = 'Router';

        $name = $group ?? 'router';
        $nameRouter = $group ? '/'.$group : '';

        $groupContent = "\n".'$app->mount($app[\'api_version\']'.$nameRouter.', function ($'.$name.') use ($app) {';

        $content = $groupContent. "\n\t".'$'.$name.'->get(\'/'.$router.'\', \''.$service.':read\');'.
                    "\n\t".'$'.$name.'->get(\'/'.$router.'/{id}\', \''.$service.':get\');'.
                    "\n\t".'$'.$name.'->post(\'/'.$router.'\', \''.$service.':create\');'.
                    "\n\t".'$'.$name.'->put(\'/'.$router.'\', \''.$service.':update\');'.
                    "\n\t".'$'.$name.'->delete(\'/'.$router.'/{id}\', \''.$service.':delete\');';

        if ($auth) {
            $file = 'RouterAuth';
            $content =  "\n\n\t".'$auth->get(\'/'.$router.'\', \''.$service.':read\');'.
                        "\n\t".'$auth->get(\'/'.$router.'/{id}\', \''.$service.':get\');'.
                        "\n\t".'$auth->post(\'/'.$router.'\', \''.$service.':create\');'.
                        "\n\t".'$auth->put(\'/'.$router.'\', \''.$service.':update\');'.
                        "\n\t".'$auth->delete(\'/'.$router.'/{id}\', \''.$service.':delete\');';
        }

        if ($method) {
            $authName = $auth ? 'auth':'app';
            $content = "\n".'$'.$authName.'->'.$method.'($app[\'api_version\'].\'/'.$router.'\', function() use ($app) {'."\n\n".'});';
        }

        $content = ($method || $auth) ? $content : $content."\n});";

        if(file_exists($this->path.$file.'.php'))
        {
            $msg = "Register with success!";
            if(!file_put_contents($this->path.$file.'.php',$content,FILE_APPEND)) {
                $msg = "Error to register new Router";
            }
        }

        $output->writeln($msg);
    }
}