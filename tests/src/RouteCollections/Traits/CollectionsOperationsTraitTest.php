<?php

namespace Nip\Router\Tests\RouteCollections\Traits;

use Nip\Router\Route\Route;
use Nip\Router\RouteCollection;
use Nip\Router\Tests\AbstractTest;

/**
 * Class CollectionsOperationsTraitTest
 * @package Nip\Router\Tests\RouteCollections\Traits
 */
class CollectionsOperationsTraitTest extends AbstractTest
{
    public function testPrependRoute()
    {
        $collection = new RouteCollection();
        foreach ([1, 2] as $key) {
            $route = new Route();
            $route->setName('route' . $key);
            $collection->addRoute($route);
        }
        self::assertCount(2, $collection);

        $allRoutes = $collection->all();
        $firstRoute = reset($allRoutes);
        self::assertInstanceOf(Route::class, $firstRoute);
        self::assertSame('route1', $firstRoute->getName());

        $route = new Route();
        $route->setName('route3');
        $collection->prependRoute($route);

        $allRoutes = $collection->all();
        $firstRoute = reset($allRoutes);
        self::assertSame('route3', $firstRoute->getName());
    }
}
