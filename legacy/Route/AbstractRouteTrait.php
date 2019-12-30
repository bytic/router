<?php

namespace Nip\Router\Legacy\Route;

/**
 * Trait AbstractRouteTrait
 * @package Nip\Router\Legacy\Route
 */
trait AbstractRouteTrait
{
    /**
     * @param array $params
     * @deprecated Use setDefaults
     */
    public function setParams($params = [])
    {
        $this->getParser()->setParams($params);
        $this->addDefaults($params);
    }
}
