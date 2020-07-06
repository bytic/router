<?php

namespace Nip\Router\Generator\Traits;

use Nip\Router\Route\Route;

/**
 * Trait HasDefaultRouteTrait
 * @package Nip\Router\Generator\Traits
 */
trait HasDefaultRouteTrait
{

    /**
     * {@inheritdoc}
     */
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        $name = $this->initDefaultRoute($name, $parameters);
        return parent::generate($name, $parameters, $referenceType);
    }

    /**
     * @param $name
     * @param array $params
     * @return string
     */
    protected function initDefaultRoute($name, &$params = [])
    {
        $route = $this->hasRoute($name);
        if ($route) {
            return $name;
        }
        return $this->initMvcRoute($name, $params);
    }

    /**
     * @param $name
     * @param array $params
     * @return string
     */
    protected function initMvcRoute($name, &$params = [])
    {
        $parts = explode(".", $name);
        $count = count($parts);
        if ($count > 3) {
            return $name;
        }
        $firstPart = strtolower(reset($parts));
        if (!in_array($firstPart, app('mvc.modules')->getNames())) {
            return $name;
        }
        $module = array_shift($parts);
        $params['controller'] = isset($parts[0]) ? $parts[0] : null;
        $params['action'] = isset($parts[1]) ? $parts[1] : null;
        $defaultRoute = $module . '.default';
        if ($this->hasRoute($defaultRoute)) {
            return $defaultRoute;
        }
        return $name;
    }
}
