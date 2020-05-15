<?php

namespace Nip\Router\RouteCollections\Traits;

use Symfony\Component\Routing\RouteCollection;

/**
 * Trait RouteLoaderTrait
 * @package Nip\Router\RouteCollections\Traits
 */
trait RouteLoaderTrait
{

    /**
     * @param $path
     */
    public function loadFromIncludedPhp($path)
    {
        /** @noinspection PhpIncludeInspection */
        $collection = require $path;
        if ($collection instanceof RouteCollection) {
            $this->addCollection($collection);
        }
    }
}
