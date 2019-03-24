<?php

namespace Nip\Router\Tests;

use Nip\Container\Container;
use Nip\Router\Router;
use Nip\Router\RouterServiceProvider;

/**
 * Class RouterServiceProviderTest
 * @package Nip\Router\Tests
 */
class RouterServiceProviderTest extends AbstractTest
{
    public function testRegisterRouter()
    {
        $container = new Container();
        $provider = new RouterServiceProvider();
        $provider->setContainer($container);
        $provider->registerRouter();

        self::assertInstanceOf(Router::class, $container->get('router'));
    }
}