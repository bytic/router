<?php

namespace Nip\Router\Tests\ServiceProvider\Traits;

use Nip\Container\Container;
use Nip\Router\Router;
use Nip\Router\RouterServiceProvider;
use Nip\Router\Tests\AbstractTest;

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
}