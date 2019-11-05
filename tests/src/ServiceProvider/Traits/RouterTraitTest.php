<?php

namespace Nip\Router\Tests\ServiceProvider\Traits;

use Nip\Container\Container;
use Nip\Router\Router;
use Nip\Router\RouterServiceProvider;
use Nip\Router\Tests\AbstractTest;
use Nip\Router\Tests\Fixtures\Application\Library\Router\CustomRouter;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class RouterServiceProviderTest
 * @package Nip\Router\Tests\ServiceProvider\Traits
 */
class RouterTraitTest extends AbstractTest
{
    public function testRegisterRouter()
    {
        $container = new Container();
        $provider = new RouterServiceProvider();
        $provider->setContainer($container);
        $provider->registerRouter();

        self::assertInstanceOf(Router::class, $container->get('router'));
    }

    public function testRegisterCustomRouter()
    {
        $container = new Container();
        $provider = new RouterServiceProvider();
        $provider->setContainer($container);
        $provider->registerRouter();

        $container->singleton(RouterInterface::class, CustomRouter::class);

        self::assertInstanceOf(CustomRouter::class, $container->get('router'));
    }
}
