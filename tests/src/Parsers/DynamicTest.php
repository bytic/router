<?php

namespace Nip\Router\Tests\Parsers;

use Nip\Router\Parsers\Dynamic;
use Nip\Router\Tests\AbstractTest;

/**
 * Test class for Nip_Route_Abstract.
 * Generated by PHPUnit on 2010-11-17 at 15:16:44.
 */
class DynamicTest extends AbstractTest
{

    /**
     * @var Dynamic
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Dynamic();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    public function testSetMap()
    {
        $map = 'shop/category_:url/:name';
        $this->object->setMap($map);
        static::assertEquals($map, $this->object->getMap());
        static::assertEquals(3, count($this->object->getParts()));
        static::assertEquals(['url', 'name'], $this->object->getVariables());
    }

    public function testGetVariableFromPart()
    {
        static::assertEquals(['url'], $this->object->getVariableFromPart(':url'));
        static::assertEquals(['url'], $this->object->getVariableFromPart('category_:url'));
        static::assertEquals(['category', 'url_shop'], $this->object->getVariableFromPart(':category:url_shop'));
        static::assertEquals(['category_main', 'url_shop'], $this->object->getVariableFromPart(':category_main:url_shop'));
        static::assertEquals(['category', 'url_product'], $this->object->getVariableFromPart(':category-:url_product'));
        static::assertEquals(['category', 'url_product'], $this->object->getVariableFromPart(':category-:url_product-test'));
        static::assertEquals(['category', 'url_product'], $this->object->getVariableFromPart('shop-:category-:url_product-test'));
        static::assertEquals(['category_main', 'url_product'], $this->object->getVariableFromPart('shop-:category_main-:url_product-test'));
    }


    public function testAssemble()
    {
        $params = [
            'url' => 'lorem',
            'name' => 'ipsum',
            'company' => 'dolo&rem',
        ];
        static::assertEquals('?url=lorem&name=ipsum&company=dolo%26rem', $this->object->assemble($params));

        $this->object->setMap('shop/category_:url/:name');
        static::assertEquals('shop/category_lorem/ipsum?company=dolo%26rem', $this->object->assemble($params));
    }

    public function testMatch()
    {
        $map = 'shop/category_:url/:name';
        $this->object->setMap($map);
        static::assertFalse($this->object->match('shop/category_cast/'));
        static::assertTrue($this->object->match('shop/category_cars/honda'));
    }
}