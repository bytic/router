<?php

namespace Nip\Router\Tests\Utility;

use Nip\Router\Tests\AbstractTest;
use Nip\Router\Utility\MapTransform;

/**
 * Class MapTransformTest
 * @package Nip\Router\Tests\Utility
 */
class MapTransformTest extends AbstractTest
{

    /**
     * @param $map
     * @param $transform
     * @dataProvider runData()
     */
    public function testRun($map, $transform)
    {
        self::assertSame($transform, MapTransform::run($map));
    }

    /**
     * @return array
     */
    public function runData()
    {
        return [
            ['simple', 'simple'],
            ['/index/index', '/index/index'],
            ['/admin/:index', '/admin/{index}'],
            ['/admin/:controller/:action', '/admin/{controller}/{action}'],
        ];
    }
}
