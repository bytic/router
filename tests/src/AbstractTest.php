<?php

namespace Nip\Router\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class AbstractTest
 */
abstract class AbstractTest extends TestCase
{
    protected $object;

    protected function setUp(): void
    {
        parent::setUp();

        $filesystem = new Filesystem();
        $filesystem->remove(TEST_FIXTURE_PATH . '/bootstrap/routes');
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        \Mockery::close();
    }
}
