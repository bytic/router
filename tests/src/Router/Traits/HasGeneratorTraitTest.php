<?php

namespace Nip\Router\Tests\Router\Traits;

use Nip\Router\Generator\UrlGenerator;
use Nip\Router\Route\Route;
use Nip\Router\RouteFactory;
use Nip\Router\Router;
use Nip\Router\Tests\AbstractTest;
use Nip\Router\Tests\Fixtures\Application\Library\Router\Route\StandardRoute;

/**
 * Class HasGeneratorTraitTest
 * @package Nip\Router\Tests\Router\Traits
 */
class HasGeneratorTraitTest extends AbstractTest
{
    public function testGetGenerator()
    {
        $router = new Router();
        self::assertInstanceOf(UrlGenerator::class, $router->getGenerator());
    }

    public function testAssemble()
    {
        $router = new Router();
        $collection = $router->getRoutes();

        RouteFactory::generateLiteralRoute($collection, "admin.index", Route::class, "/admin", "/index");
        RouteFactory::generateStandardRoute($collection, "api.index", StandardRoute::class, "/api");

        self::assertSame(
            '/admin/index?controller=posts',
            $router->assemble('admin.index', ['controller' => 'posts'])
        );

        self::assertSame(
            '/api/posts',
            $router->assemble('api.index', ['controller' => 'posts'])
        );

        self::assertSame(
            '/api/posts/create?test=true',
            $router->assemble('api.index', ['controller' => 'posts', 'action' => 'create', 'test' => 'true'])
        );
    }

    public function testGenerate()
    {
        $router = new Router();
        $collection = $router->getRoutes();

        RouteFactory::generateLiteralRoute($collection, "admin.index", Route::class, "/admin", "/index");
        RouteFactory::generateStandardRoute($collection, "api.index", StandardRoute::class, "/api");

        self::assertSame(
            '/admin/index?controller=posts',
            $router->generate('admin.index', ['controller' => 'posts'])
        );

        self::assertSame(
            '/api/posts',
            $router->generate('api.index', ['controller' => 'posts'])
        );

        self::assertSame(
            '/api/posts/create?param=test',
            $router->generate('api.index', ['controller' => 'posts','action' => 'create', 'param' => 'test'])
        );
    }
}
