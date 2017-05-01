<?php
namespace JSantos\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateRepositoryCommand extends Command
{
    use CommandTrait;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->path = __DIR__.'/../Model/';
    }

    protected function configure()
    {
        $this->setName('make:repo')
             ->setDescription('Create a New Repository CRUD')
             ->setHelp('To create a new repository crud use: php gugaio make:repo MyRepository')
             ->addArgument('name', InputArgument::REQUIRED, 'The name of the Repository.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $msg = "Repository is exist in project";

        $repo = $input->getArgument('name');
        $repo = $this->manipulation($repo);
        $repoName = $this->getNameFile($repo);

        $content = "<?php\nnamespace JSantos\\Model;\n\nclass $repoName extends Repository\n{\n\n}";

        if(!file_exists($this->path.$repo.'.php'))
        {
            $msg = "Repository CRUD created with success!";
            if(!file_put_contents($this->path.$repo.'.php',$content)) {
                $msg = "Error to create new Repository CRUD";
            }
        }
        $output->writeln($msg);
    }
}