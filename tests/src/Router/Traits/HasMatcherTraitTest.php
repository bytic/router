<?php

namespace Nip\Router\Tests\Router\Traits;

use Nip\Request;
use Nip\Router\Route\Route;
use Nip\Router\RouteFactory;
use Nip\Router\Router;
use Nip\Router\Tests\AbstractTest;
use Nip\Router\Tests\Fixtures\Application\Library\Router\Route\StandardRoute;

/**
 * Class HasMatcherTraitTest
 * @package Nip\Router\Tests\Router\Traits
 */
class HasMatcherTraitTest extends AbstractTest
{

    public function testRouteLiteral()
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

    public function testRouteDynamic()
    {
        $router = new Router();
        $collection = $router->getRoutes();

        RouteFactory::generateStandardRoute($collection, "admin.standard", StandardRoute::class, "/admin",
            '/:controller/:action', ['module' => 'admin']);
        RouteFactory::generateStandardRoute($collection, "api.standard", StandardRoute::class, "/api",
            '/:controller/:action', ['module' => 'api']);

        $request = Request::create('/api/pages/delete');
        self::assertSame(
            ['module' => 'api', 'controller' => 'pages', 'action' => 'delete'],
            $router->route($request)
        );

        $request = Request::create('/admin/pages/delete');
        self::assertSame(
            ['module' => 'admin', 'controller' => 'pages', 'action' => 'delete'],
            $router->route($request)
        );
    }
}
