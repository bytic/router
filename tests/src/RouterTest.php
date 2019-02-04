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
    public function testRoute()
    {
        $router = new Router();
        $collection = $router->getRoutes();

        RouteFactory::generateLiteralRoute($collection, "admin.index", Route::class, "/admin", "/index");
        RouteFactory::generateLiteralRoute($collection, "api.index", Route::class, "/api", "/index");

        $request = Request::create('/api/404');
        $router->route($request);
        self::assertNull($router->getCurrent());

        $request = Request::create('/api/index');
        $params = $router->route($request);
        self::assertSame([], $params);

        $currentRoute = $router->getCurrent();
        self::assertInstanceOf(Route::class, $currentRoute);
        self::assertSame('api.index', $currentRoute->getName());

        $request = Request::create('/admin/index');
        $router->route($request);
        self::assertSame('admin.index', $router->getCurrent()->getName());
    }
}