<?php

namespace Nip\Router\Tests\Router\Traits;

use Nip\Request;
use Nip\Router\Route\Route;
use Nip\Router\RouteFactory;
use Nip\Router\Router;
use Nip\Router\Tests\AbstractTest;
use Nip\Router\Tests\Fixtures\Application\Library\Router\Route\StandardRoute;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Class HasMatcherTraitTest
 * @package Nip\Router\Tests\Router\Traits
 */
class HasMatcherTraitTest extends AbstractTest
{
    public function testNotFound()
    {
        $router = new Router();
        $router->initRouteCollection();
        self::expectException(ResourceNotFoundException::class);

        $request = Request::create('/404');
        $router->matchRequest($request);
    }

    public function testRouteLiteral()
    {
        $router = new Router();
        $router->initRouteCollection();
        $collection = $router->getRoutes();

        RouteFactory::generateLiteralRoute($collection, "admin.index", Route::class, "/admin", "/index");
        RouteFactory::generateLiteralRoute($collection, "api.index", Route::class, "/api", "/index");

        $request = Request::create('/api/index');
        $params = $router->matchRequest($request);
        self::assertEquals(['_route' => 'api.index'], $params);

        $currentRoute = $router->getCurrent();
        self::assertEquals('api.index', $currentRoute);

        $request = Request::create('/admin/index');
        $router->matchRequest($request);
        self::assertEquals('admin.index', $router->getCurrent());
    }

    /**
     * @dataProvider dataRouteDynamic
     */
    public function testRouteDynamic($uri, $routeName, $params)
    {
        $router = new Router();
        $router->initRouteCollection();
        $collection = $router->getRoutes();

        RouteFactory::generateStandardRoute(
            $collection,
            "admin.standard",
            StandardRoute::class,
            "/admin",
            '/:controller/:action', ['module' => 'admin']);
        RouteFactory::generateStandardRoute(
            $collection, "api.standard",
            StandardRoute::class,
            "/api",
            '/:controller/:action', ['module' => 'api']);

        RouteFactory::generateStandardRoute(
            $collection,
            "frontend.standard",
            StandardRoute::class,
            "/");

        $request = Request::create($uri);
        $matches = $router->matchRequest($request);

        self::assertArrayHasKey('_route', $matches);

        foreach ($params as $param=>$value) {
            self::assertArrayHasKey($param, $matches);
            self::assertSame($matches[$param], $value);
        }
    }

    /**
     * @return array
     */
    public function dataRouteDynamic()
    {
        return [
            ['/api/pages', 'api.standard', ['module' => 'api', 'controller' => 'pages', 'action' => 'index']],
            ['/api/pages/', 'api.standard', ['module' => 'api', 'controller' => 'pages', 'action' => 'index']],
            ['/api/pages/delete', 'api.standard', ['module' => 'api', 'controller' => 'pages', 'action' => 'delete']],
            ['/admin/pages/delete', 'admin.standard', ['module' => 'admin', 'controller' => 'pages', 'action' => 'delete']],
            ['/users/delete', 'frontend.standard', ['controller' => 'users', 'action' => 'delete']],
            ['/users/', 'frontend.standard', ['controller' => 'users', 'action' => 'index']],
            ['/users', 'frontend.standard', ['controller' => 'users', 'action' => 'index']],
        ];
    }
}
