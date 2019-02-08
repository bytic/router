<?php

use Nip\Router\RouteFactory;
use Nip\Router\Tests\Fixtures\Application\Library\Router\Route\LiteralRoute;
use Nip\Router\Tests\Fixtures\Application\Library\Router\Route\StandardRoute;

RouteFactory::generateIndexRoute($this, 'admin.index', LiteralRoute::class, '/admin');
RouteFactory::generateStandardRoute($this, 'admin.standard', StandardRoute::class, '/admin');

RouteFactory::generateIndexRoute($this, 'default.index', LiteralRoute::class, '/');
RouteFactory::generateStandardRoute($this, 'default.standard', StandardRoute::class, '/');
