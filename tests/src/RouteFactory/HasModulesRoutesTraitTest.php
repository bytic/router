<?php

namespace Nip\Router\Tests\RouteFactory;

use Nip\Router\Route\LiteralRoute;
use Nip\Router\Route\StandardRoute;
use Nip\Router\RouteCollection;
use Nip\Router\RouteFactory;
use Nip\Router\Tests\AbstractTest;
use Nip\Router\Tests\Fixtures\Application\Modules\Admin\Routes\LiteralRoute as AdminLiteralRoute;
use Nip\Router\Tests\Fixtures\Application\Modules\Admin\Routes\StandardRoute as AdminStandardRoute;

/**
 * Class HasModulesRoutesTraitTest
 * @package Nip\Router\Tests\RouteFactory
 */
class HasModulesRoutesTraitTest extends AbstractTest
{
    public function test_generateGenericModuleDefaultRoutes_no_namespace()
    {
        $collection = new RouteCollection();
        RouteFactory::generateGenericModuleDefaultRoutes($collection, "admin", '/admin');

        self::assertCount(4, $collection);

        self::assertInstanceOf(LiteralRoute::class, $collection->get('admin.slash'));
        self::assertInstanceOf(LiteralRoute::class, $collection->get('admin'));
        self::assertInstanceOf(StandardRoute::class, $collection->get('admin.default'));
        self::assertInstanceOf(StandardRoute::class, $collection->get('admin.default.index'));
    }

    public function test_generateGenericModuleDefaultRoutes_with_namespace()
    {
        $collection = new RouteCollection();
        RouteFactory::generateGenericModuleDefaultRoutes($collection,
            ["admin", "Nip\Router\Tests\Fixtures\Application\\"], '/admin');

        self::assertCount(4, $collection);

        self::assertInstanceOf(AdminLiteralRoute::class, $collection->get('admin.slash'));
        self::assertInstanceOf(AdminLiteralRoute::class, $collection->get('admin'));
        self::assertInstanceOf(AdminStandardRoute::class, $collection->get('admin.default'));
        self::assertInstanceOf(AdminStandardRoute::class, $collection->get('admin.default.index'));
    }

    public function test_generateGenericModuleDefaultRoutes_with_namespace_missing_classes()
    {
        $collection = new RouteCollection();
        RouteFactory::generateGenericModuleDefaultRoutes($collection,
            ["frontend", "Nip\Router\Tests\Fixtures\Application\\"], '/admin');

        self::assertCount(4, $collection);

        self::assertInstanceOf(LiteralRoute::class, $collection->get('frontend.slash'));
        self::assertInstanceOf(LiteralRoute::class, $collection->get('frontend'));
        self::assertInstanceOf(StandardRoute::class, $collection->get('frontend.default'));
        self::assertInstanceOf(StandardRoute::class, $collection->get('frontend.default.index'));
    }
}
