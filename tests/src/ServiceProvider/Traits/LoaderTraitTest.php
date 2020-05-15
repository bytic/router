<?php

namespace Nip\Router\Tests\ServiceProvider\Traits;

use Nip\Container\Container;
use Nip\Router\RouteCollection;
use Nip\Router\RouterServiceProvider;
use Nip\Router\Tests\AbstractTest;
use Nip\Router\Tests\Fixtures\Application\Library\Application;
use Symfony\Component\Config\Loader\DelegatingLoader;

/**
 * Class LoaderTraitTest
 * @package Nip\Router\Tests\ServiceProvider\Traits
 */
class LoaderTraitTest extends AbstractTest
{

    public function test_registerLoader()
    {
        $container = new Container();
        $container->set('app', new Application());

        $provider = new RouterServiceProvider();
        $provider->setContainer($container);
        $provider->registerLoader();

        $loader = $container->get('routing.loader');
        self::assertInstanceOf(DelegatingLoader::class, $loader);

        /** @var RouteCollection $collection */
        $collection = $loader->load('routes.php');
        self::assertInstanceOf(RouteCollection::class, $collection);
        self::assertCount(8, $collection);
        self::assertTrue($collection->has('admin.index'));
    }
}
