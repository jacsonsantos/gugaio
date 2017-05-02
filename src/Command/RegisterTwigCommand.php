<?php
namespace JSantos\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterTwigCommand extends Command
{
    use CommandTrait;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->path = __DIR__.'/../../config/';
    }

    protected function configure()
    {
        $this->setName('register:twig')
             ->setDescription('Register Twig Service Provider')
             ->setHelp('Register Twig: php gugaio register:twig');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $msg = "The file register.php not exist in project.\nUse: php gugaio make:register";

        $content = "\n".'$app->register(new Silex\Provider\TwigServiceProvider(), array('.
                            "\n\t".'\'twig.path\' => __DIR__.\'/../src/Views\','.
                        "\n".'));';

        if(file_exists($this->path.'register.php'))
        {
            $msg = "The Twig register with success!";
            if(!file_put_contents($this->path.'register.php',$content,FILE_APPEND)) {
                $msg = "Error to register Twig";
            }
        }
        $output->writeln($msg);
    }
}