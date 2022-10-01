<?php
declare(strict_types=1);

namespace Nip\Router\RouteCollections\Traits;

use Nip\Router\Route\Route;

/**
 * Trait ArrayAccessTrait
 * @package Nip\Router\RouteCollections\Traits
 */
trait ArrayAccessTrait
{
    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    /**
     * @param mixed $offset
     * @return Route|null
     */
    public function offsetGet($offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->add($offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        $this->remove($offset);
    }
}
