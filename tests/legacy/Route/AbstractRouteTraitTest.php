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
    public function testSetParamsNotOverwriteMapDefaults()
    {
        $route = new Route('/{controller}/{action?index}');
        self::assertSame(['action' => 'index'], $route->getDefaults());

        $params = ['test' => 9];
        $route->setParams($params);
        self::assertEquals(['test' => 9, 'action' => 'index'], $route->getDefaults());
    }

    public function testSetParams()
    {
        $route = new Route();
        self::assertSame([], $route->getDefaults());

        $params = ['test' => 9];
        $route->setParams($params);
        self::assertEquals($params, $route->getDefaults());
    }
}
