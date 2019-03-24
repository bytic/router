<?php

namespace Nip\Router;

use Nip\Container\ServiceProvider\AbstractSignatureServiceProvider;
use Nip\Router\Generator\UrlGenerator;
use Nip\Router\ServiceProvider\Traits\RouterTrait;
use Nip\Router\ServiceProvider\Traits\RoutesTrait;
use Nip\Router\ServiceProvider\Traits\UrlGeneratorTrait;

/**
 * Class RouterServiceProvider
 * @package Nip\Router
 */
class RouterServiceProvider extends AbstractSignatureServiceProvider
{
    use RouterTrait;
    use RoutesTrait;
    use UrlGeneratorTrait;

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerRouter();
        $this->registerRoutes();
        $this->registerUrlGenerator();
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['router', 'routes', 'url'];
    }
}
