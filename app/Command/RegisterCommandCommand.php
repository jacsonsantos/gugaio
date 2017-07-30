<?php
namespace JSantos\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterCommandCommand extends Command
{
    use CommandTrait;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->path = __DIR__.'/../../config/';
    }

    protected function configure()
    {
        $this->setName('register:command')
             ->setDescription('Register a new Command, add namespace: --namespace')
             ->setHelp('To register a new Command')
             ->addArgument('mycommand', InputArgument::REQUIRED, 'The name of the Command.')
             ->addOption('namespace',null,InputOption::VALUE_REQUIRED,'The namespace of the Command');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $msg = "";
        $command = $input->getArgument('mycommand');
        $namespace = $input->getOption('namespace') ?? 'JSantos\\Command';
        $namespace = $this->manipulation($namespace);
        $namespace = str_replace('/',"\\",$namespace);
        $content = "\n".'$console->add(new '.$namespace.'\\'.ucfirst($command).'());';

        if(file_exists($this->path.'command.php'))
        {
            $msg = "Register with success!";
            if(!file_put_contents($this->path.'command.php',$content,FILE_APPEND)) {
                $msg = "Error to register new Command";
            }
        }

        $output->writeln($msg);
    }
}