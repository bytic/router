<?php

namespace Nip\Router\RouteCollections\Traits;

use Nip\Router\Route\Route;

/**
 * Trait CollectionsOperationsTrait
 * @package Nip\Router\RouteCollections\Traits
 */
trait CollectionsOperationsTrait
{
    /**
     * @var Route[]
     */
    protected $routes = [];

    /**
     * @inheritdoc
     * @deprecated Use all()
     */
    public function getRoutes()
    {
        return $this->all();
    }

    /**
     * @param array $routes
     */
    public function setRoutes($routes)
    {
        $this->routes = $routes;
    }

    /**
     * @param $route
     * @return bool
     */
    public function has($route)
    {
        $name = $route instanceof Route ? $route->getName() : $route;

        return $this->get($name) instanceof Route;
    }

    /**
     * @param $route
     * @return Route|\Symfony\Component\Routing\Route|null
     */
    public function get($route)
    {
        $name = $route instanceof Route ? $route->getName() : $route;
        return parent::get($name);
    }


    /**
     * @param Route $route
     * @param null $name
     * @return
     */
    public function addRoute($route, $name = null)
    {
        if ($name) {
            $route->setName($name);
        } else {
            $name = $route->getName();
        }
        return $this->add($name, $route);
    }
}
