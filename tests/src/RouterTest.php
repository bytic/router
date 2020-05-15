<?php

namespace Nip\Router\Tests;

use Nip\Request;
use Nip\Router\Route\Route;
use Nip\Router\RouteFactory;
use Nip\Router\Router;
use Nip\Router\Tests\Fixtures\Application\Library\Router\Route\StandardRoute;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Class RouterTest
 * @package Nip\Router\Tests
 */
class RouterTest extends AbstractTest
{
    public function testMatchRequest404()
    {
        $router = new Router();
        $router->initRouteCollection();
        $collection = $router->getRoutes();

        RouteFactory::generateLiteralRoute(
            $collection, "admin.index", Route::class, "/admin", "/index",
            ['module' => 'admin']
        );
        RouteFactory::generateLiteralRoute(
            $collection, "api.index", Route::class, "/api", "/index",
            ['module' => 'api']
        );
        self::assertCount(2, $router->getRoutes());

        $request = Request::create('/api/404');
        $this->expectException(ResourceNotFoundException::class);
        $router->matchRequest($request);
    }

    public function testMatchRequest()
    {
        $router = new Router();
        $router->initRouteCollection();
        $collection = $router->getRoutes();

        RouteFactory::generateLiteralRoute($collection, "admin.index", Route::class, "/admin", "/index",
            ['module' => 'admin']);
        RouteFactory::generateLiteralRoute($collection, "api.index", Route::class, "/api", "/index",
            ['module' => 'api']);
        self::assertCount(2, $router->getRoutes());

        $request = Request::create('/api/index');
        $params = $router->matchRequest($request);
        self::assertEquals(
            ['module' => 'api', '_route' => 'api.index'],
            $params
        );
    }

    public function testMatchRequestWithStandardRoute()
    {
        $router = new Router();
        $router->initRouteCollection();
        $collection = $router->getRoutes();

        RouteFactory::generateStandardRoute($collection, "admin.standard", StandardRoute::class, "/admin",
            "/:controller/:action",
            ['module' => 'admin']);

        $request = Request::create('/admin/post/create');
        $params = $router->matchRequest($request);
        self::assertEquals(
            ['module' => 'admin', 'controller' => 'post', 'action' => 'create', '_route' => 'admin.standard'],
            $params
        );
    }
}
