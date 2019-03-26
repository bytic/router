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
        self::expectException(ResourceNotFoundException::class);

        $request = Request::create('/404');
        $router->matchRequest($request);
    }

    public function testRouteLiteral()
    {
        $router = new Router();
        $collection = $router->getRoutes();

        RouteFactory::generateLiteralRoute($collection, "admin.index", Route::class, "/admin", "/index");
        RouteFactory::generateLiteralRoute($collection, "api.index", Route::class, "/api", "/index");

        $request = Request::create('/api/index');
        $params = $router->matchRequest($request);
        self::assertEquals(['_route' => 'api.index'], $params);

        $currentRoute = $router->getCurrent();
        self::assertInstanceOf(Route::class, $currentRoute);
        self::assertEquals('api.index', $currentRoute->getName());

        $request = Request::create('/admin/index');
        $router->matchRequest($request);
        self::assertEquals('admin.index', $router->getCurrent()->getName());
    }

    public function testRouteDynamic()
    {
        $router = new Router();
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

        $request = Request::create('/api/pages/delete');
        self::assertEquals(
            ['module' => 'api', 'controller' => 'pages', 'action' => 'delete', '_route' => 'api.standard'],
            $router->matchRequest($request)
        );

        $request = Request::create('/api/pages/');
        self::assertEquals(
            ['module' => 'api', 'controller' => 'pages', 'action' => 'index', '_route' => 'api.standard'],
            $router->matchRequest($request)
        );

        $request = Request::create('/api/pages');
        self::assertEquals(
            ['module' => 'api', 'controller' => 'pages', 'action' => 'index', '_route' => 'api.standard'],
            $router->matchRequest($request)
        );

        $request = Request::create('/admin/pages/delete');
        self::assertEquals(
            ['module' => 'admin', 'controller' => 'pages', 'action' => 'delete', '_route' => 'admin.standard'],
            $router->matchRequest($request)
        );

        $request = Request::create('/users/delete');
        self::assertEquals(
            ['controller' => 'users', 'action' => 'delete', '_route' => 'frontend.standard'],
            $router->matchRequest($request)
        );

        $request = Request::create('/users/');
        self::assertEquals(
            ['controller' => 'users', 'action' => 'index', '_route' => 'frontend.standard'],
            $router->matchRequest($request)
        );

        $request = Request::create('/users');
        self::assertEquals(
            ['controller' => 'users', 'action' => 'index', '_route' => 'frontend.standard'],
            $router->matchRequest($request)
        );
    }
}
