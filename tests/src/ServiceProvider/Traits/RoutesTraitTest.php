<?php

namespace Nip\Router\Tests\ServiceProvider\Traits;

use Nip\Container\Container;
use Nip\Router\RouteCollection;
use Nip\Router\Router;
use Nip\Router\RouterServiceProvider;
use Nip\Router\Tests\AbstractTest;

/**
 * Class RoutesTraitTest
 * @package Nip\Router\Tests\ServiceProvider\Traits
 */
class RoutesTraitTest extends AbstractTest
{
    public function testRegisterRouter()
    {
        $container = new Container();
        $container->set('router', new Router());
        $provider = new RouterServiceProvider();
        $provider->setContainer($container);
        $provider->registerRoutes();

        self::assertInstanceOf(RouteCollection::class, $container->get('routes'));
    }
}
