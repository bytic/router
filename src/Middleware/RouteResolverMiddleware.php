<?php

namespace Nip\Router\Middleware;

use Nip\Http\ServerMiddleware\Middlewares\ServerMiddlewareInterface;
use Nip\Request;
use Nip\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class StartSession
 * @package Nip\Session\Middleware
 */
class RouteResolverMiddleware implements ServerMiddlewareInterface
{

    /**
     * The session manager.
     *
     * @var Router
     */
    protected $router;

    /**
     * Create a new session middleware.
     *
     * @param  Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @inheritdoc
     * @param Request $request
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->getRouter()->matchRequest($request);

        return $handler->handle($request);
    }


    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }
}
