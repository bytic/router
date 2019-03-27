<?php

namespace Nip\Router\Tests\ServiceProvider\Traits;

use Nip\Container\Container;
use Nip\Router\Generator\UrlGenerator;
use Nip\Router\RouteCollection;
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
        $container->set('router', new Router());

        $provider = new RouterServiceProvider();
        $provider->setContainer($container);
        $provider->registerUrlGenerator();

        self::assertInstanceOf(UrlGenerator::class, $container->get('url'));
    }
}
