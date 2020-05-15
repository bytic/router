<?php

namespace Nip\Router\Generator;

use Nip\Router\RequestContext;
use Nip\Router\RouteCollection;
use Symfony\Component\Routing\Route;

/**
 * Class UrlGenerator
 * @package Nip\Router\Generator
 * @method RequestContext getContext()
 */
class UrlGenerator extends \Symfony\Component\Routing\Generator\UrlGenerator
{
    use Traits\FormattingTrait;
    use Traits\HasDefaultRouteTrait;
    use Traits\HasPreviousUrlTrait;
    use Traits\HasRequestTrait;
    use Traits\UrlFunctionTrait;

    /**
     * @param $name
     * @return bool
     */
    public function hasRoute($name)
    {
        if ($this->routes instanceof RouteCollection) {
            return $this->routes->has($name);
        }

        return $this->routes->get($name) instanceof Route;
    }
}
