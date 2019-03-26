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
     * @param boolean $params
     * @return string|null
     */
    public function assemble($name, $params = [])
    {
        $route = $this->getDefaultRoute($name, $params);
        return $this->generate($route->getName(), $params);
//        if ($route) {
//            $route->setRequest($this->getRequest());
//            return $route->assemble($params);
//        }
//
//        trigger_error("Route \"$name\" not connected", E_USER_ERROR);
//        return null;
    }

    /**
     * @param $name
     * @param boolean $params
     * @return string
     */
    public function assembleFull($name, $params = [])
    {
        $route = $this->getDefaultRoute($name, $params);
        if ($route) {
            $route->setRequest($this->getRequest());
            return $route->assembleFull($params);
        }

        trigger_error("Route \"$name\" not connected", E_USER_ERROR);

        return null;
    }

    /**
     * @param $name
     * @param array $params
     * @return null|Route
     */
    public function getDefaultRoute($name, &$params = [])
    {
        $route = $this->getRoute($name);
        if (!$route) {
            $parts = explode(".", $name);
            $count = count($parts);
            if ($count <= 3) {
                if (in_array(reset($parts), app('mvc.modules')->getNames())) {
                    $module = array_shift($parts);
                    $params['controller'] = isset($parts[0]) ? $parts[0] : null;
                    $params['action'] = isset($parts[1]) ? $parts[1] : null;
                    $route = $this->getRoute($module . '.default');
                }
            }
        }

        return $route;
    }
}
