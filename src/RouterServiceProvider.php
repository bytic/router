<?php

namespace Nip\Router;

use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use Nip\Router\Console\CacheCommand;
use Nip\Router\Console\ClearCommand;

/**
 * Class RouterServiceProvider
 * @package Nip\Router
 */
class RouterServiceProvider extends AbstractSignatureServiceProvider
{
    use ServiceProvider\Traits\LoaderTrait;
    use ServiceProvider\Traits\RouterTrait;
    use ServiceProvider\Traits\RoutesTrait;
    use ServiceProvider\Traits\UrlGeneratorTrait;

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['router', 'routing.loader', 'routes', 'url'];
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerLoader();
        $this->registerRouter();
        $this->registerRoutes();
        $this->registerUrlGenerator();
    }

    protected function registerCommands()
    {
        $this->commands(
            CacheCommand::class,
            ClearCommand::class
        );
    }
}
