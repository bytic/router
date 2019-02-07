<?php

namespace Nip\Router\Router\Traits;

use Nip\Request;
use Nip\Router\Route\Route;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Trait HasMatcherTrait
 * @package Nip\Router\Router\Traits
 */
trait HasMatcherTrait
{
    /**
     * @param Request|ServerRequestInterface $request
     * @return array
     */
    public function route($request)
    {
        $current = false;
        $uri = $request->path();
        $routes = $this->getRoutes();

        foreach ($routes as $name => $route) {
            $route->setRequest($request);
            if ($route->match($uri)) {
                $current = $route;
                break;
            }
        }

        if ($current instanceof Route) {
            $this->setCurrent($current);
            $current->populateRequest();

            return $current->getParams() + $current->getMatches();
        } else {
            return [];
        }
    }
}