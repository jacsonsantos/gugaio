<?php
namespace JSantos\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateControllerCommand extends Command
{
    use CommandTrait;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->path = __DIR__.'/../Controller/';
    }

    protected function configure()
    {
        $this->setName('make:controller')
             ->setDescription('Create a New Controller')
             ->setHelp('To create a new controller use: php gugaio make:controller MyController')
             ->addArgument('name', InputArgument::REQUIRED, 'The name of the Controller.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $msg = "Controller is exist in project";

        $controller = $input->getArgument('name');
        $controller = $this->manipulation($controller);
        $controllerName = $this->getNameFile($controller);

        $content = "<?php\nnamespace JSantos\\Controller;\n\nuse Symfony\\Component\\HttpFoundation\\Request;\nuse Symfony\\Component\\HttpFoundation\\JsonResponse;\n\nclass $controllerName extends Controller\n{\n\n}";

        if(!file_exists($this->path.$controller.'.php'))
        {
            $msg = "Controller created with success!";
            if(!file_put_contents($this->path.$controller.'.php',$content)) {
                $msg = "Error to create new Controller";
            }
        }
        $output->writeln($msg);
    }
}