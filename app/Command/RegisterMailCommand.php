<?php
namespace JSantos\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterMailCommand extends Command
{
    use CommandTrait;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->path = __DIR__.'/../../config/';
    }

    protected function configure()
    {
        $this->setName('register:mailer')
             ->setDescription('Register Mailer Service Provider')
             ->setHelp('Register IMAP: php gugaio register:mailer');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $msg = "The file register.php not exist in project.\nUse: php gugaio make:register";

        $content = "\n".'$app->register(new Silex\\Provider\\SwiftmailerServiceProvider());'.
                        "\n".'$app[\'swiftmailer.options\'] = ['.
                                "\n\t".'\'host\' => CONFIG[\'MAIL\'][\'HOSTSMTP\'],'.
                                "\n\t".'\'port\' => CONFIG[\'MAIL\'][\'PORT\'],'.
                                "\n\t".'\'username\' => CONFIG[\'USER\'][\'USERNAME\'],'.
                                "\n\t".'\'password\' => CONFIG[\'USER\'][\'PASSWORD\'],'.
                                "\n\t".'\'encryption\' => CONFIG[\'MAIL\'][\'ENCRYPTION\'],'.
                                "\n\t".'\'auth_mode\' => CONFIG[\'MAIL\'][\'AUTH_MODE\'],'.
                        "\n".'];';

        if(file_exists($this->path.'register.php'))
        {
            $msg = "The Mailer register with success!";
            if(!file_put_contents($this->path.'register.php',$content,FILE_APPEND)) {
                $msg = "Error to register Mailer";
            }
        }
        $output->writeln($msg);
    }
}