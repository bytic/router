<?php

namespace Nip\Router\Tests\Middleware;

use Nip\Router\Middleware\RouteResolverMiddleware;
use Nip\Router\Router;
use Nip\Router\Tests\AbstractTest;
use Nip\Http\Response\Response;
use Nip\Http\ServerMiddleware\Dispatcher;
use Nip\Request;

/**
 * Class DebugbarMiddlewareTest
 * @package Nip\Router\Tests\Middleware
 */
class RouteResolverMiddlewareTest extends AbstractTest
{
    public function testProcess()
    {
        $request = Request::create('/test');
        $router =\Mockery::mock(Router::class);
        $router->shouldReceive('matchRequest')->with($request);
        $router->shouldReceive('setContext');

        $dispatcher = new Dispatcher(
            [
                new RouteResolverMiddleware($router),
                function () {
                    return (new Response())->setContent('test');
                },
            ]
        );

        /** @var Response $response */
        $response = $dispatcher->dispatch($request);

        self::assertInstanceOf(Response::class, $response);
        self::assertSame('test', $response->getContent());
    }
}
