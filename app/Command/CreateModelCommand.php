<?php
namespace JSantos\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateModelCommand extends Command
{
    use CommandTrait;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->path = __DIR__.'/../Model/';
    }

    protected function configure()
    {
        $this->setName('make:model')
             ->setDescription('Create a New Model')
             ->setHelp('To create a new model use: php gugaio make:model MyModel')
             ->addArgument('name', InputArgument::REQUIRED, 'The name of the Model.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $msg = "Model is exist in project";

        $model = $input->getArgument('name');
        $model = $this->manipulation($model);
        $modelName = $this->getNameFile($model);

        $content = "<?php\nnamespace JSantos\\Model;\n\nuse Illuminate\\Database\\Eloquent\\Model;\n\nclass $modelName extends Model\n{\n\n}";

        if(!file_exists($this->path.$model.'.php'))
        {
            $msg = "Model created with success!";
            if(!file_put_contents($this->path.$model.'.php',$content)) {
                $msg = "Error to create new Model";
            }
        }
        $output->writeln($msg);
    }
}