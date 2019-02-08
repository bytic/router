<?php

namespace Nip\Router\Route\Traits;

/**
 * Trait HasMatchTrait
 * @package Nip\Router\Route\Traits
 */
trait HasMatchTrait
{

    /**
     * @param $uri
     * @return bool
     */
    public function match($uri)
    {
        $this->uri = $uri;
        if ($this->domainCheck()) {
            $return = $this->getParser()->match($uri);
            if ($return === true) {
                $this->postMatch();
            }

            return $return;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function domainCheck()
    {
        return true;
    }

    public function postMatch()
    {
    }
}