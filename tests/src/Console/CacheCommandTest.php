<?php

namespace Nip\Router\Tests\Console;

use Nip\Container\Container;
use Nip\Router\Console\CacheCommand;
use Nip\Router\Console\ClearCommand;
use Nip\Router\RouterServiceProvider;
use Nip\Router\Tests\AbstractTest;
use Nip\Router\Tests\Fixtures\Application\Library\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class CacheCommandTest
 * @package Nip\Router\Tests\Console
 */
class CacheCommandTest extends AbstractTest
{
    public function test_handle()
    {
        $container = new Container();
        $container->set('app', new Application());
        Container::setInstance($container);

        $serviceProvider = new RouterServiceProvider();
        $serviceProvider->setContainer($container);
        $serviceProvider->register();

        $applicationConsole = new \Symfony\Component\Console\Application();
        $applicationConsole->add(new ClearCommand());
        $applicationConsole->add(new CacheCommand());
        $command = $applicationConsole->get('router:cache');

        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();
        static::assertStringContainsString('Routes  cached successfully!', $output);
    }
}
