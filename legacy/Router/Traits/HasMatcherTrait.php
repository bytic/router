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
        if ($return['_route']) {
            $this->populateRequest($request, $return);
        }
        return $return;
    }

    /**
     * @param Request $request
     * @param $params
     */
    protected function populateRequest($request, $params)
    {
        foreach ($params as $param => $value) {
            switch ($param) {
                case 'module':
                    $request->setModuleName($value);
                    break;
                case 'controller':
                    $request->setControllerName($value);
                    break;
                case 'action':
                    $request->setActionName($value);
                    break;
                default:
                    $request->attributes->set($param, $value);
                    break;
            }
        }
    }
}
