<?php

namespace Nip\Router\Route;

/**
 * Class LiteralRoute
 * @package Nip\Router\Route
 */
class LiteralRoute extends AbstractRoute
{
    /**
     * @inheritDoc
     */
    public function __construct($map = false, $defaults = [])
    {
        $this->setType('literal');

        parent::__construct($map, $defaults);
    }
}
