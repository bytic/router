<?php

namespace Nip\Router\Tests;

use Nip\Router\Route\Route;
use Nip\Router\RouteCollection;

/**
 * Class RouteCollectionTest
 * @package Nip\Router\Tests
 */
class RouteCollectionTest extends AbstractTest
{
    public function testArrayAccess()
    {
        $collection = new RouteCollection();

        $route = new Route();
        $route->setName('test');
        $collection->addRoute($route);


        self::assertInstanceOf(Route::class, $collection['test']);
        self::assertInstanceOf(Route::class, $collection->get('test'));
    }

    public function testCountable()
    {
        $collection = new RouteCollection();

        self::assertCount(0, $collection);
        self::assertSame(0, $collection->count());

        $route = new Route();
        $route->setName('test');
        $collection->addRoute($route);


        self::assertCount(1, $collection);
        self::assertSame(1, $collection->count());
    }
}