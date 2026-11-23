<?php
declare(strict_types=1);

namespace Nip\Router\Middleware;

use Nip\Http\ServerMiddleware\Middlewares\ServerMiddlewareInterface;
use Nip\Http\Request\PsrRequest;
use Nip\Router\RequestContext;
use Nip\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\HttpFoundation\Request;

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
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $symfonyRequest = $this->toSymfonyRequest($request);
        $this->getRouter()->setContext((new RequestContext())->fromRequest($symfonyRequest));
        $return = $this->getRouter()->matchRequest($symfonyRequest);
        if (is_array($return) && isset($return['_route'])) {
            $request = $this->populateRequest($request, $return);
        }

        return $handler->handle($request);
    }

    /**
     * @param array $params
     */
    protected function populateRequest(ServerRequestInterface $request, array $params): ServerRequestInterface
    {
        foreach ($params as $param => $value) {
            $request = $request->withAttribute($param, $value);
        }

        if ($request instanceof PsrRequest) {
            $symfonyRequest = $request->getSymfonyRequest();
        } elseif ($request instanceof Request) {
            $symfonyRequest = $request;
        } else {
            return $request;
        }

        $symfonyRequest->attributes->add($params);
        foreach (['module' => 'setModuleName', 'controller' => 'setControllerName', 'action' => 'setActionName'] as $param => $method) {
            if (array_key_exists($param, $params) && method_exists($symfonyRequest, $method)) {
                $symfonyRequest->$method($params[$param]);
            }
        }

        return $request;
    }

    private function toSymfonyRequest(ServerRequestInterface $request): Request
    {
        if ($request instanceof Request) {
            return $request;
        }
        if ($request instanceof PsrRequest) {
            $embeddedRequest = $request->getSymfonyRequest();
            if ((string) $request->getUri() === $embeddedRequest->getUri()
                && $request->getMethod() === $embeddedRequest->getMethod()) {
                return $embeddedRequest;
            }
        }

        $symfonyRequest = Request::create(
            (string) $request->getUri(),
            $request->getMethod(),
            [],
            $request->getCookieParams(),
            [],
            $request->getServerParams()
        );
        $symfonyRequest->headers->replace($request->getHeaders());
        $symfonyRequest->attributes->add($request->getAttributes());

        return $symfonyRequest;
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }
}
