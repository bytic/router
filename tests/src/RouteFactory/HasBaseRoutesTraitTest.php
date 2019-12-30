<?php

namespace Nip\Router\Tests\RouteFactory;

use Nip\Router\Route\LiteralRoute;
use Nip\Router\Route\StandardRoute;
use Nip\Router\RouteCollection;
use Nip\Router\RouteFactory;
use Nip\Router\Tests\AbstractTest;
use Nip\Router\Tests\Fixtures\Application\Library\Router\Route\LiteralRoute as FixturesLiteralRoute;
use Nip\Router\Tests\Fixtures\Application\Library\Router\Route\StandardRoute as FixturesStandardRoute;

/**
 * Class HasBaseRoutesTraitTest
 * @package Nip\Router\Tests\RouteFactory
 */
class HasBaseRoutesTraitTest extends AbstractTest
{
    public function test_generateIndexRoute_emptyClass()
    {
        $collection = new RouteCollection();
        RouteFactory::generateIndexRoute($collection, 'index');

        self::assertCount(2, $collection);

        $firstRoute = $collection->get('index');
        self::assertInstanceOf(LiteralRoute::class, $firstRoute);
        self::assertSame('/', $firstRoute->getParser()->getMap());
        self::assertSame(["controller" => "index", "action" => "index"], $firstRoute->getDefaults());
    }

    public function test_generateIndexRoute_existingClass()
    {
        $collection = new RouteCollection();
        RouteFactory::generateIndexRoute($collection, 'index', FixturesLiteralRoute::class);

        self::assertCount(2, $collection);

        $firstRoute = $collection->get('index');
        self::assertInstanceOf(FixturesLiteralRoute::class, $firstRoute);
    }

    public function test_generateIndexRoute_nonClass()
    {
        $collection = new RouteCollection();
        RouteFactory::generateIndexRoute($collection, 'index', 'MyApplication\Module\Route\LiteralRoute');

        self::assertCount(2, $collection);

        $firstRoute = $collection->get('index');
        self::assertInstanceOf(LiteralRoute::class, $firstRoute);
    }


    public function test_generateStandardRoute_emptyClass()
    {
        $collection = new RouteCollection();
        RouteFactory::generateStandardRoute($collection, 'index');

        self::assertCount(2, $collection);

        $firstRoute = $collection->get('index');
        self::assertInstanceOf(StandardRoute::class, $firstRoute);
        self::assertSame('/{controller}/{action?index}', $firstRoute->getParser()->getMap());
        self::assertSame(["action" => "index"], $firstRoute->getDefaults());
    }

    public function test_generateStandardRoute_existingClass()
    {
        $collection = new RouteCollection();
        RouteFactory::generateStandardRoute($collection, 'index', FixturesStandardRoute::class);

        self::assertCount(2, $collection);

        $firstRoute = $collection->get('index');
        self::assertInstanceOf(FixturesStandardRoute::class, $firstRoute);
    }

    public function test_generateStandardRoute_nonClass()
    {
        $collection = new RouteCollection();
        RouteFactory::generateStandardRoute($collection, 'index', 'MyApplication\Module\Route\StandardRoute');

        self::assertCount(2, $collection);

        $firstRoute = $collection->get('index');
        self::assertInstanceOf(StandardRoute::class, $firstRoute);
    }
}
