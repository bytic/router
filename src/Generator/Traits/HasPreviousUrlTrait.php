<?php

namespace Nip\Router\Generator\Traits;

use Nip\Router\RequestContext;

/**
 * Trait HasPreviousUrlTrait
 * @package Nip\Router\Generator\Traits
 * @method RequestContext getContext()
 */
trait HasPreviousUrlTrait
{

    /**
     * Get the URL for the previous request.
     *
     * @param  mixed $fallback
     * @return string
     */
    public function previous($fallback = false)
    {
        $referrer = $this->getContext()->getHeaders()->get('referer');
        $url = $referrer ? $this->to($referrer) : $this->getPreviousUrlFromSession();
        if ($url) {
            return $url;
        } elseif ($fallback) {
            return $this->to($fallback);
        } else {
            return $this->to('/');
        }
    }

    /**
     * Get the previous URL from the session if possible.
     *
     * @return string|null
     */
    protected function getPreviousUrlFromSession()
    {
        return null;
//        $session = $this->getSession();
//        return $session ? $session->previousUrl() : null;
    }
}
