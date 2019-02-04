<?php

namespace Nip\Router\Route\Traits;

use Nip\Router\Route\Route;

/**
 * Trait HasTypeTrait
 * @package Nip\Router\Route\Traits
 */
trait HasTypeTrait
{
    /**
     * @var string
     */
    protected $type = null;

    /**
     * @return string
     */
    public function getType()
    {
        if ($this->type === null) {
            $this->initType();
        }

        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    protected function initType()
    {
        $this->setType($this->generateType());
    }

    /**
     * @return string
     */
    protected function generateType()
    {
        if ($this->getClassName() == Route::class) {
            return 'literal';
        }

        if ($this->isNamespaced()) {
            $name = strtolower($this->getClassFirstName());
            return str_replace('route', '', $name);
        }
        $name = get_class($this);
        $parts = explode('_', $name);

        return strtolower(end($parts));
    }
}
