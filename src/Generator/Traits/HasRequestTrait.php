<?php

namespace Nip\Router\Generator\Traits;

use Nip\Request;
use Nip\Router\RequestContext;

/**
 * Trait HasRequestTrait
 * @package Nip\Router\Generator\Traits
 */
trait HasRequestTrait
{

    /**
     * Set the current request instance.
     *
     * @param  Request $request
     */
    public function setRequest(Request $request)
    {
        $context = (new RequestContext())->fromRequest($request);

        $this->cachedRoot = null;
        $this->cachedSchema = null;
        return $this->setContext($context);
    }
}
