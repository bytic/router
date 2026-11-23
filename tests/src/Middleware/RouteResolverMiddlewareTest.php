<?php

namespace Nip\Router\Tests\Middleware;

use Nip\Router\Middleware\RouteResolverMiddleware;
use Nip\Router\Router;
use Nip\Router\Tests\AbstractTest;
use Nip\Http\Response\Response;
use Nip\Http\Request\PsrRequest;
use Nip\Http\ServerMiddleware\Dispatcher;
use Nip\Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\Routing\Route;

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
                    $response = new Response();
                    $response->setContent('test');
                    return $response;
                },
            ]
        );

        /** @var Response $response */
        $response = $dispatcher->dispatch($request);

        self::assertInstanceOf(Response::class, $response);
        self::assertSame('test', $response->getContent());
    }

    public function testPsrRequestIsMatchedAndRouteAttributesReachHandler(): void
    {
        if (!class_exists(PsrRequest::class)) {
            self::markTestSkipped('This version of bytic/http does not provide PsrRequest.');
        }

        $symfonyRequest = SymfonyRequest::create('https://example.com:8443/old', 'GET');
        $symfonyRequest->headers->set('Referer', 'https://example.com/previous');
        $request = new PsrRequest($symfonyRequest);
        $request = $request->withUri($request->getUri()->withPath('/articles/42')->withQuery('sort=asc'))
            ->withMethod('POST');
        $router = new Router();
        $router->initRouteCollection();
        $router->getRoutes()->add('article', new Route('/articles/{id}', ['controller' => 'articles'], [], [], '', [], ['POST']));

        $response = \Mockery::mock(ResponseInterface::class);
        $handler = new class($response) implements RequestHandlerInterface {
            public $request;
            private $response;

            public function __construct(ResponseInterface $response)
            {
                $this->response = $response;
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                $this->request = $request;
                return $this->response;
            }
        };

        self::assertSame($response, (new RouteResolverMiddleware($router))->process($request, $handler));
        self::assertSame('article', $router->getCurrent());
        self::assertSame('42', $handler->request->getAttribute('id'));
        self::assertSame('articles', $handler->request->getAttribute('controller'));
        self::assertSame('article', $handler->request->getAttribute('_route'));
        self::assertNull($request->getAttribute('id'));
        self::assertSame('42', $handler->request->getSymfonyRequest()->attributes->get('id'));
        self::assertSame('https://example.com:8443', $router->getContext()->root());
        self::assertSame('sort=asc', $router->getContext()->getQueryString());
        self::assertSame('https://example.com/previous', $router->getContext()->getHeaders()->get('referer'));
    }

    public function testGenericPsrRequestCanBeMatched(): void
    {
        $uri = \Mockery::mock(UriInterface::class);
        $uri->shouldReceive('__toString')->andReturn('https://example.com/items/7');
        $request = \Mockery::mock(ServerRequestInterface::class);
        $request->shouldReceive('getUri')->andReturn($uri);
        $request->shouldReceive('getMethod')->andReturn('GET');
        $request->shouldReceive('getCookieParams', 'getServerParams', 'getAttributes')->andReturn([]);
        $request->shouldReceive('getBody')->never();
        $request->shouldReceive('getHeaders')->andReturn(['Host' => ['example.com']]);
        $request->shouldReceive('withAttribute')->with('id', '7')->andReturnSelf();
        $request->shouldReceive('withAttribute')->with('_route', 'item')->andReturnSelf();

        $router = new Router();
        $router->initRouteCollection();
        $router->getRoutes()->add('item', new Route('/items/{id}'));
        $response = \Mockery::mock(ResponseInterface::class);
        $handler = \Mockery::mock(RequestHandlerInterface::class);
        $handler->shouldReceive('handle')->once()->with($request)->andReturn($response);

        self::assertSame($response, (new RouteResolverMiddleware($router))->process($request, $handler));
        self::assertSame('item', $router->getCurrent());
        self::assertSame('https://example.com', $router->getContext()->root());
    }
}
