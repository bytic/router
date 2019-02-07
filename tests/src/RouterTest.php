<?php

namespace Nip\Router\Tests;


use Nip\Request;
use Nip\Router\Route\Route;
use Nip\Router\RouteFactory;
use Nip\Router\Router;

/**
 * Class RouterTest
 * @package Nip\Router\Tests
 */
class RouterTest extends AbstractTest
{

    public function testMatchRequest()
    {
        $router = new Router();
        $collection = $router->getRoutes();

        RouteFactory::generateLiteralRoute($collection, "admin.index", Route::class, "/admin", "/index");
        RouteFactory::generateLiteralRoute($collection, "api.index", Route::class, "/api", "/index");
        self::assertCount(2, $router->getRoutes());

        $request = Request::create('/api/404');

//        $router->matchRequest($request);
//        self::assertNull($router->getCurrent());
//
//        $request = Request::create('/api/index');
//        $params = $router->route($request);
//        self::assertSame([], $params);
    }
}