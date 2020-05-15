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
     * @inheritdoc
     * @return RouteCollection
     */
    public function getRouteCollection()
    {
//        if (null === $this->collection) {
//            $this->collection = $this->newRoutesCollection();
//        }
        return parent::getRouteCollection();
    }

    /**
     * @param $name
     * @return null|Route\Route
     */
    public function getRoute($name)
    {
        return $this->getRouteCollection()->get($name);
    }

    /**
     * @return RouteCollection|Route[]
     */
    public function getRoutes()
    {
        return $this->getRouteCollection();
    }

    /**
     * @param Route $route
     */
    public function addRoute($route)
    {
        $this->getRouteCollection()->addRoute($route);
    }

    /**
     * @param $name
     * @return bool
     */
    public function connected($name)
    {
        return $this->hasRoute($name);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasRoute($name)
    {
        return $this->getGenerator()->hasRoute($name);
    }

    public function initRouteCollection()
    {
        $this->collection = $this->newRoutesCollection();
    }

    /**
     * @return RouteCollection
     */
    protected function newRoutesCollection()
    {
        return new RouteCollection();
    }
}
