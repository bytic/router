<?php

namespace Nip\Router\RequestContext\Traits;

/**
 * Trait HasHeadersTrait
 * @package Nip\Router\RequestContext\Traits
 */
trait HasHeadersTrait
{

    /**
     * Headers (taken from the $_SERVER).
     *
     * @var \Symfony\Component\HttpFoundation\HeaderBag
     */
    protected $headers;

    /**
     * @return \Symfony\Component\HttpFoundation\HeaderBag
     */
    public function getHeaders(): \Symfony\Component\HttpFoundation\HeaderBag
    {
        return $this->headers;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\HeaderBag $headers
     */
    public function setHeaders(\Symfony\Component\HttpFoundation\HeaderBag $headers)
    {
        $this->headers = $headers;
    }
}
