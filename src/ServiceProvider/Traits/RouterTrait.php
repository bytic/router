<?php

namespace Nip\Router\ServiceProvider\Traits;

use Nip\Http\Request;
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
        $this->getContainer()->share('router', function () {
            return $this->newRouter();
        });

        $this->getContainer()->add(RouterInterface::class, Router::class);

        $this->getContainer()->share(Router::class, function () {
            return $this->getContainer()->get('router');
        });
    }

    /**
     * @return Router
     */
    public function newRouter()
    {
        $app = $this->getContainer()->get('app');

        /** @var Router $router */
        $router = $this->getContainer()->make(
            RouterInterface::class,
            [
                'loader' => $this->getContainer()->get('routing.loader'),
                'resource' => 'routes.php',
                'options' => [
                    'cache_dir' => $app->getCachedRoutesPath(),
                ]
            ]
        );

        $request = Request::instance();
        if ($request instanceof Request) {
            $router->setContext((new RequestContext())->fromRequest($request));
        }
        return $router;
    }
}
