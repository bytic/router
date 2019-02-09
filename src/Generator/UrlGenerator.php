<?php

namespace Nip\Router\Generator;

use Nip\Request;
use Nip\Router\Generator\Traits\FormattingTrait;
use Nip\Router\Generator\Traits\HasPreviousUrlTrait;
use Nip\Router\Generator\Traits\UrlFunctionTrait;
use Nip\Router\RequestContext;

/**
 * Class UrlGenerator
 * @package Nip\Router\Generator
 * @method RequestContext getContext()
 */
class UrlGenerator extends \Symfony\Component\Routing\Generator\UrlGenerator
{
    use FormattingTrait;
    use UrlFunctionTrait;
    use HasPreviousUrlTrait;

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
