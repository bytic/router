<?php

namespace Nip\Router\Tests\Legacy\Route;

use Nip\Router\Route\Route;
use Nip\Router\Tests\AbstractTest;

/**
 * Class AbstractRouteTraitTest
 * @package Nip\Router\Tests\Legacy\Route
 */
class AbstractRouteTraitTest extends AbstractTest
{
    public function testSetParams()
    {
        $route = new Route();
        self::assertSame([], $route->getDefaults());

        $params = ['test' => 9];
        $route->setParams($params);
        self::assertSame($params, $route->getDefaults());
    }
}
