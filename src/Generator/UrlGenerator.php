<?php

namespace Nip\Router\Generator;

use Nip\Request;
use Nip\Router\Generator\Traits\FormattingTrait;
use Nip\Router\Generator\Traits\HasPreviousUrlTrait;
use Nip\Router\Generator\Traits\UrlFunctionTrait;
use Nip\Router\RequestContext;
use Nip\Router\Route\Route;

/**
 * Class UrlGenerator
 * @package Nip\Router\Generator
 * @method RequestContext getContext()
 */
class UrlGenerator extends \Symfony\Component\Routing\Generator\UrlGenerator
{
    use FormattingTrait;
    use UrlFunctionTrait;
    use HasPreviousUrlTrait;

    /**
     * Set the current request instance.
     *
     * @param  Request $request
     */
    public function setRequest(Request $request)
    {
        $context = (new RequestContext())->fromRequest($request);

        $this->cachedRoot = null;
        $this->cachedSchema = null;
        return $this->setContext($context);
    }

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
        $route = $this->routes->get($name);
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
                $route = $this->routes->get($module . '.default');
                if ($route) {
                    return $route->getName();
                }
            }
        }
        return $name;
    }
}
