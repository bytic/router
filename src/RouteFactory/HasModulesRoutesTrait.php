<?php

namespace Nip\Router\RouteFactory;

use Nip\Router\RouteCollection;

/**
 * Trait HasModulesRoutesTrait
 * @package Nip\Router\RouteFactory
 */
trait HasModulesRoutesTrait
{

    /**
     * @param RouteCollection $collection
     * @param $module
     * @param $prefix
     */
    public static function generateGenericModuleDefaultRoutes($collection, $module, $prefix)
    {
        $moduleName = is_array($module) ? $module[0] : $module;
        $params = ['module' => $module];

        self::generateIndexRoute(
            $collection,
            $moduleName,
            self::generateModuleRouteClassBase($module, 'Literal'),
            $prefix,
            $params
        );

        self::generateStandardRoute(
            $collection,
            $moduleName . ".default",
            self::generateModuleRouteClassBase($module, 'Standard'),
            $prefix,
            null,
            $params
            );
    }

    /**
     * @param string|array $module
     * @param string $type
     * @return string
     */
    public static function generateModuleRouteClassBase($module, $type)
    {
        if (is_array($module)) {
            $namespace = $module[1];
            $module = $module[0];
            $module = $module == 'default' ? 'frontend' : $module;
            return $namespace . 'Modules\\' . ucfirst($module) . '\Routes\\' . ucfirst($type) . 'Route';
        }
        return ucfirst($module) . '_Route_' . ucfirst($type);
    }

    /**
     * @param RouteCollection $collection
     * @param $class
     */
    public static function generateModuleDefaultErrorRoutes($collection, $class)
    {
        self::generateModuleErrorRoutes($collection, $class, 'default');
    }

    /**
     * @param RouteCollection $collection
     * @param $class
     * @param string $module
     */
    public static function generateModuleErrorRoutes($collection, $class, $module = 'default')
    {
        foreach (['403', '404', '500'] as $code) {
            self::generateLiteralRoute($collection, $module . ".error." . $code, $class, '', '/' . $code,
                ["controller" => "error", "action" => "index", "error_type" => $code]);
        }
    }
}
