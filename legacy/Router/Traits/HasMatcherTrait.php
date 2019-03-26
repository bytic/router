<?php

namespace Nip\Router\Legacy\Router\Traits;

use Nip\Request;
use Nip\Router\Route\Route;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Trait HasMatcherTrait
 * @package Nip\Router\Legacy\Router\Traits
 */
trait HasMatcherTrait
{
    /**
     * @param Request|ServerRequestInterface $request
     * @return array
     * @deprecated Use matchRequest($request)
     */
    public function route($request)
    {
        $return = $this->matchRequest($request);
        return $return;
    }
}
