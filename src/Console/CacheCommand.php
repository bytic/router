<?php

namespace Nip\Router\Console;

use ByTIC\Console\Command;
use Exception;

/**
 * Class CacheCommand
 * @package Nip\Config\Console
 */
class CacheCommand extends Command
{
    protected function configure()
    {
        parent::configure();
        $this->setName('router:cache');
        $this->setDescription('Create a route cache file for faster route registration');
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    protected function handle()
    {
        $this->call('router:clear');

        $app = $this->getByticApp();
        $configPath = $app->getCachedRoutesPath();

        $router = $this->getFromContainer('router');
        $router->setOption('cache_dir', $configPath);

        $matcher = $router->getMatcher();

        $this->info('Routes  cached successfully!');

        return 0;
    }
}
