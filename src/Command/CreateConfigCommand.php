<?php
namespace JSantos\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateConfigCommand extends Command
{
    use CommandTrait;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->path = __DIR__.'/../../';
    }

    protected function configure()
    {
        $this->setName('make:config')
             ->setDescription('Create a File config.yml')
             ->setHelp('To create a File config.yml: php gugaio make:config');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $msg = "config.yml is exist in project";

        $content = file_get_contents($this->path.'config.example.yml');

        if(!file_exists($this->path.'config.yml'))
        {
            $msg = "The file config.yml created with success!";
            if(!file_put_contents($this->path.'config.yml',$content)) {
                $msg = "Error to create config.yml";
            }
        }
        $output->writeln($msg);
    }
}