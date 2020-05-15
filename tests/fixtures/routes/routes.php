<?php

$collection = new \Nip\Router\RouteCollection();

use Nip\Router\RouteFactory;
use Nip\Router\Tests\Fixtures\Application\Library\Router\Route\LiteralRoute;
use Nip\Router\Tests\Fixtures\Application\Library\Router\Route\StandardRoute;

RouteFactory::generateIndexRoute($collection, 'admin.index', LiteralRoute::class, '/admin');
RouteFactory::generateStandardRoute($collection, 'admin.standard', StandardRoute::class, '/admin');

RouteFactory::generateIndexRoute($collection, 'default.index', LiteralRoute::class, '/');
RouteFactory::generateStandardRoute($collection, 'default.standard', StandardRoute::class, '/');

return $collection;
