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
     * @param Router $router
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
        $return = $this->getRouter()->matchRequest($request);
        if ($return['_route']) {
            $this->populateRequest($request, $return);
        }

        return $handler->handle($request);
    }

    /**
     * @param Request $request
     * @param $params
     */
    protected function populateRequest($request, $params)
    {
        foreach ($params as $param => $value) {
            switch ($param) {
                case 'module':
                    $request->setModuleName($value);
                    break;
                case 'controller':
                    $request->setControllerName($value);
                    break;
                case 'action':
                    $request->setActionName($value);
                    break;
                default:
                    $request->attributes->set($param, $value);
                    break;
            }
        }
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }
}
