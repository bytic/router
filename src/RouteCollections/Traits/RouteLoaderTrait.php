<?php

namespace Nip\Router\RouteCollections\Traits;

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
        require_once $path;
    }
}
