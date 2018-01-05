<?php declare(strict_types=1);

namespace App\Seed;

use Dms\Core\Ioc\IIocContainer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SeedCommand extends Command
{
    private $container;

    public function __construct(IIocContainer $container)
    {
        $this->container = $container;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('db:seed')
            ->setDescription('Populate data to database')
            ;
    }

    /**
     * Execute the console command.
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = getcwd() . '/database/seeds';
        $iterator = new \DirectoryIterator($dir);
        foreach ($iterator as $finfo) {
            if (!$finfo->isDot()) {
                require_once $finfo->getRealPath();
                $class = $finfo->getBasename('.php');
                $classes = class_implements($class);
                if (in_array('App\Seed\SeedInterface', $classes)) {
                    $object = $this->container->get($class);
                    $object->run();
                }
            }
        }
    }
}
