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
            $routes = $this->getContainer()->get('routes');
            $request = $this->getRequest();

            $url = new UrlGenerator(
                $routes,
                (new RequestContext())->fromRequest($request)
            );
            return $url;
        });
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        if (function_exists('request')) {
            return request();
        }
        return new Request();
    }
}