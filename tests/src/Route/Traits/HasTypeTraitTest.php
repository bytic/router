<?php

namespace Nip\Router\Tests\Route\Traits;

use Nip\Router\Route\Route;
use Nip\Router\Tests\AbstractTest;
use Nip\Router\Tests\Fixtures\Route\StandardRoute;

/**
 * Class HasTypeTraitTest
 * @package Nip\Router\Tests\Route\Traits
 */
class HasTypeTraitTest extends AbstractTest
{
    public static function testGetTypeLiteralForSimpleRoute()
    {
        $route = new Route();
        static::assertSame('literal', $route->getType());
    }

    public static function testGetTypeFromName()
    {
        $route = new StandardRoute();
        static::assertSame('standard', $route->getType());
    }
}
