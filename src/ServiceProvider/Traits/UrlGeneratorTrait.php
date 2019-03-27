<?php

namespace Nip\Router\ServiceProvider\Traits;

use Nip\Request;
use Nip\Router\Generator\UrlGenerator;
use Nip\Router\RequestContext;

/**
 * Trait UrlGeneratorTrait
 * @package Nip\Router\ServiceProvider\Traits
 */
trait UrlGeneratorTrait
{

    /**
     * Register the URL generator service.
     *
     * @return void
     */
    public function registerUrlGenerator()
    {
        $this->getContainer()->singleton('url', function () {
            $router = $this->getContainer()->get('router');
            return $router->getGenerator();
        });
    }
}
