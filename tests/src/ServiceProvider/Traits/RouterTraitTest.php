<?php

namespace Nip\Router\Tests\ServiceProvider\Traits;

use Nip\Container\Container;
use Nip\Router\Generator\CompiledUrlGenerator;
use Nip\Router\Router;
use Nip\Router\RouterServiceProvider;
use Nip\Router\Tests\AbstractTest;
use Nip\Router\Tests\Fixtures\Application\Library\Application;
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
        $container->set('app', new Application());

        $provider = new RouterServiceProvider();
        $provider->setContainer($container);
        $provider->register();

        /** @var Router $router */
        $router = $container->get('router');
        self::assertInstanceOf(Router::class, $router);

        $generator = $router->getGenerator();
        self::assertInstanceOf(CompiledUrlGenerator::class, $generator);
        self::assertTrue($generator->hasRoute('default.standard'));
    }

    public function testRegisterCustomRouter()
    {
        $container = new Container();
        $container->set('app', new Application());

        $provider = new RouterServiceProvider();
        $provider->setContainer($container);
        $provider->register();

        $container->add(RouterInterface::class, CustomRouter::class);

        self::assertInstanceOf(CustomRouter::class, $container->get('router'));
    }
}
