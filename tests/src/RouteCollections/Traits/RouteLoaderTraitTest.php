<?php

namespace Nip\Router\Tests\RouteCollections\Traits;

use Nip\Router\RouteCollection;
use Nip\Router\Tests\AbstractTest;
use Nip\Router\Tests\Fixtures\Application\Library\Router\Route\LiteralRoute;
use Nip\Router\Tests\Fixtures\Application\Library\Router\Route\StandardRoute;

/**
 * Class RouteLoaderTraitTest
 * @package Nip\Router\Tests\RouteCollections\Traits
 */
class RouteLoaderTraitTest extends AbstractTest
{
    public function testLoadFromIncludedPhp()
    {
        $collection = new RouteCollection();
        $collection->loadFromIncludedPhp(
            TEST_FIXTURE_PATH . '/routes/routes.php'
        );

        self::assertSame(8, $collection->count());
        self::assertInstanceOf(LiteralRoute::class, $collection->get('default.index'));
        self::assertInstanceOf(StandardRoute::class, $collection->get('default.standard'));
        self::assertInstanceOf(StandardRoute::class, $collection->get('default.standard.index'));
    }
}
