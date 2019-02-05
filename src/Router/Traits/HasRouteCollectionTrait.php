<?php

namespace Nip\Router\Router\Traits;

use Nip\Router\Route\Route;
use Nip\Router\RouteCollection;

/**
 * Class HasRouteCollectionTrait
 * @package Nip\Router\Router\Traits
 */
trait HasRouteCollectionTrait
{
    /**
     * @var RouteCollection|Route[]
     */
    protected $routes = null;

    /**
     * @param $name
     * @return null|Route\Route
     */
    public function getRoute($name)
    {
        return $this->getRoutes()->get($name);
    }

    /**
     * @return RouteCollection
     */
    public function getRoutes()
    {
        if ($this->routes === null) {
            $this->initRoutes();
        }

        return $this->routes;
    }

    protected function initRoutes()
    {
        $this->routes = $this->newRoutesCollection();
    }

    /**
     * @return RouteCollection
     */
    protected function newRoutesCollection()
    {
        return new RouteCollection();
    }
}
