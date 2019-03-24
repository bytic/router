<?php

namespace Nip\Router\ServiceProvider\Traits;

use Nip\Router\Router;

/**
 * Trait RoutesTrait
 * @package Nip\Router\ServiceProvider\Traits
 */
trait RoutesTrait
{
    public function registerRoutes()
    {
        $this->getContainer()->singleton('routes', function () {
            return $this->getContainer()->get('router')->getRoutes();
        });
    }
}
