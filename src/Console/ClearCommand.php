<?php

namespace Nip\Router\Console;

use ByTIC\Console\Command;
use Exception;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class ClearCommand
 * @package Nip\Config\Console
 */
class ClearCommand extends Command
{
    protected function configure()
    {
        parent::configure();
        $this->setName('router:clear');
        $this->setDescription('Remove the route cache');
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    protected function handle()
    {
        $app = $this->getByticApp();
        $configPath = $app->getCachedRoutesPath();

        $filesystem = new Filesystem();
        $filesystem->remove($configPath);

        $this->info('Routes  cached cleared!');

        return 0;
    }
}
