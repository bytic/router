<?php

namespace Nip\Router\Route;

/**
 * Class StandardRoute
 * @package Nip\Router\Route
 */
class StandardRoute extends AbstractRoute
{
    /**
     * @inheritDoc
     */
    public function __construct($map = false, $defaults = [])
    {
        $this->setType('standard');

        parent::__construct($map, $defaults);
    }
}
