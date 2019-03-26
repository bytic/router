<?php

namespace Nip\Router\Router\Traits;

use Nip\Router\Route\Route;
use Nip\Router\Router;

/**
 * Trait HasGeneratorTrait
 * @package Nip\Router\Router\Traits
 */
trait HasGeneratorTrait
{

    /**
     * @param $name
     * @param array $params
     * @return string|null
     */
    public function assemble($name, $params = [])
    {
        return $this->generate($name, $params);
    }

    /**
     * @param $name
     * @param array $params
     * @return string
     */
    public function assembleFull($name, $params = [])
    {
        return $this->generate($name, $params, self::ABSOLUTE_URL);
    }
}
