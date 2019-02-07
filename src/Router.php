<?php

namespace Nip\Router;

use Nip\Request;
use Nip\Router\Route\AbstractRoute as Route;
use Nip\Router\Router\Traits\HasCurrentRouteTrait;
use Nip\Router\Router\Traits\HasMatcherTrait;
use Nip\Router\Router\Traits\HasRouteCollectionTrait;

/**
 * Class Router
 * @package Nip\Router
 */
class Router
{
    use HasRouteCollectionTrait;
    use HasCurrentRouteTrait;
    use HasMatcherTrait;

    /**
     * @var \Nip\Request
     */
    protected $request;


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
     * @return null|Route\Route
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

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @param $name
     * @param boolean $params
     * @return string|null
     */
    public function assemble($name, $params = [])
    {
        $route = $this->getDefaultRoute($name, $params);

        if ($route) {
            $route->setRequest($this->getRequest());
            return $route->assemble($params);
        }

        trigger_error("Route \"$name\" not connected", E_USER_ERROR);
        return null;
    }
}
