<?php
namespace JSantos\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ViewsCommand extends Command
{
    use CommandTrait;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->path = __DIR__.'/../';
    }

    protected function configure()
    {
        $this->setName('make:view')
             ->setDescription('Create directory Views')
             ->setHelp('create directory Views: php gugaio make:view');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $msg = "Directory exist in project";
        if(!is_dir($this->path.'/Views'))
        {
            $msg = "The directory Views created with success!";
            if(!mkdir($this->path.'/Views')) {
                $msg = "Error to create directory Views";
            }
        }
        $output->writeln($msg);
    }
}