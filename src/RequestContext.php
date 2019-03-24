<?php

namespace Nip\Router;

use Nip\Router\RequestContext\Traits\HasHeadersTrait;
use Nip\Router\RequestContext\Traits\HasUrlFunctionsTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestContext
 * @package Nip\Router
 */
class RequestContext extends \Symfony\Component\Routing\RequestContext
{
    use HasHeadersTrait;
    use HasUrlFunctionsTrait;

    /**
     * @inheritdoc
     */
    public function fromRequest(Request $request)
    {
        $this->setHeaders($request->headers);

        return parent::fromRequest($request);
    }
}