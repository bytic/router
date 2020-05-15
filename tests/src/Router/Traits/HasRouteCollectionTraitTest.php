<?php

namespace Nip\Router\Tests\Router\Traits;

use Nip\Router\Route\Route;
use Nip\Router\Router;
use Nip\Router\Tests\AbstractTest;

/**
 * Class HasRouteCollectionTraitTest
 * @package Nip\Router\Tests\Router\Traits
 */
class HasRouteCollectionTraitTest extends AbstractTest
{
    public function testGetRoute()
    {
        $router = new Router();
        $router->initRouteCollection();

        foreach (['index', 'blog'] as $slug) {
            $route = new Route();
            $route->setName($slug);
            $router->addRoute($route);
        }

        self::assertInstanceOf(Route::class, $router->getRoute('index'));
    }
}
