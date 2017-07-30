<?php
namespace JSantos\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterImapCommand extends Command
{
    use CommandTrait;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->path = __DIR__.'/../../config/';
    }

    protected function configure()
    {
        $this->setName('register:imap')
             ->setDescription('Register IMAP Service Provider')
             ->setHelp('Register IMAP: php gugaio register:imap');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $msg = "The file register.php not exist in project.\nUse: php gugaio make:register";

        $content = "\n".'$app->register(new JSantos\\Provider\\IMAPServiceProvider());';

        if(file_exists($this->path.'register.php'))
        {
            $msg = "The IMAP register with success!";
            if(!file_put_contents($this->path.'register.php',$content,FILE_APPEND)) {
                $msg = "Error to register IMAP";
            }
        }
        $output->writeln($msg);
    }
}