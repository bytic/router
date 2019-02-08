<?php

namespace Nip\Router\Router\Traits;

use Nip\Router\Route\Route;

/**
 * Trait HasCurrentRouteTrait
 * @package Nip\Router\Router\Traits
 */
trait HasCurrentRouteTrait
{

    /**
     * @var Route
     */
    protected $route;


    /**
     * @param Route $route
     * @return $this
     */
    public function setCurrent($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @return Route
     */
    public function getCurrent()
    {
        return $this->route;
    }
}
