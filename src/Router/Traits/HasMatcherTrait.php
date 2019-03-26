<?php

namespace Nip\Router\Router\Traits;

use \Symfony\Component\HttpFoundation\Request;
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
    public function matchRequest(Request $request)
    {
        $return = parent::matchRequest($request);
        if (isset($return['_route'])) {
            $this->setCurrent($this->getRoute($return['_route']));
        }
        return $return;
    }
}
