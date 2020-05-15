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
     * @return null|Route
     */
    protected function initDefaultRoute($name, &$params = [])
    {
        $route = $this->hasRoute($name);
        if ($route) {
            return $name;
        }
        $parts = explode(".", $name);
        $count = count($parts);
        if ($count <= 3) {
            if (in_array(reset($parts), app('mvc.modules')->getNames())) {
                $module = array_shift($parts);
                $params['controller'] = isset($parts[0]) ? $parts[0] : null;
                $params['action'] = isset($parts[1]) ? $parts[1] : null;
                $defaultRoute = $module . '.default';
                if ($this->hasRoute($defaultRoute)) {
                    return $defaultRoute;
                }
            }
        }
        return $name;
    }
}
