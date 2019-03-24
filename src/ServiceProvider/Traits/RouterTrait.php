<?php

namespace Nip\Router\ServiceProvider\Traits;

use Nip\Router\Router;

/**
 * Trait RouterTrait
 * @package Nip\Router\ServiceProvider\Traits
 */
trait RouterTrait
{
    public function registerRouter()
    {
        $this->getContainer()->singleton('router', self::newRouter());
    }

    /**
     * @return Router
     */
    public static function newRouter()
    {
        return new Router();
    }
}
