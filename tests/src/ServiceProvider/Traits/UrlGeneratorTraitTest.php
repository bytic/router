<?php

namespace Nip\Router\Tests\ServiceProvider\Traits;

use Nip\Container\Container;
use Nip\Router\Generator\CompiledUrlGenerator;
use Nip\Router\Router;
use Nip\Router\RouterServiceProvider;
use Nip\Router\Tests\AbstractTest;

/**
 * Class UrlGeneratorTraitTest
 * @package Nip\Router\Tests\ServiceProvider\Traits
 */
class UrlGeneratorTraitTest extends AbstractTest
{
    public function testRegisterRouter()
    {
        $container = new Container();
        $router = new Router();
        $router->initRouteCollection();
        $container->set('router', $router);

        $provider = new RouterServiceProvider();
        $provider->setContainer($container);
        $provider->registerUrlGenerator();

        self::assertInstanceOf(CompiledUrlGenerator::class, $container->get('url'));
    }
}
