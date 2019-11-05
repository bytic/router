<?php

namespace Nip\Router\ServiceProvider\Traits;

use Nip\Request;
use Nip\Router\RequestContext;
use Nip\Router\Router;
use Symfony\Component\Routing\RouterInterface;

/**
 * Trait RouterTrait
 * @package Nip\Router\ServiceProvider\Traits
 */
trait RouterTrait
{
    public function registerRouter()
    {
        $this->getContainer()->add(RouterInterface::class, Router::class);

        $this->getContainer()->share('router', function () {
            return $this->newRouter();
        });
    }

    /**
     * @return Router
     */
    public function newRouter()
    {
        /** @var Router $router */
        $router = $this->getContainer()->get(RouterInterface::class);
        $request = Request::instance();
        if ($request instanceof Request) {
            $router->setContext((new RequestContext())->fromRequest($request));
        }
        return $router;
    }
}
