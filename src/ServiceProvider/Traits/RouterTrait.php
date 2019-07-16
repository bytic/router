<?php

namespace Nip\Router\ServiceProvider\Traits;

use Nip\Router\RequestContext;
use Nip\Router\Router;

/**
 * Trait RouterTrait
 * @package Nip\Router\ServiceProvider\Traits
 */
trait RouterTrait
{
    public function registerRouter()
    {
        $this->getContainer()->singleton('router', function () {
            return $this->newRouter();
        });
    }

    /**
     * @return Router
     */
    public function newRouter()
    {
        return $this->getContainer()->get(Router::class);
    }
}
