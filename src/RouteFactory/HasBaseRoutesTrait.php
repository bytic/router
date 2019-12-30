<?php

namespace Nip\Router\RouteFactory;

use Nip\Router\Route\LiteralRoute;
use Nip\Router\Route\Route;
use Nip\Router\Route\StandardRoute;
use Nip\Router\RouteCollection;

/**
 * Trait HasBaseRoutesTrait
 * @package Nip\Router\RouteFactory
 */
trait HasBaseRoutesTrait
{

    /**
     * @param RouteCollection $collection
     * @param $name
     * @param $class
     * @param string $mapPrefix
     * @return mixed
     */
    public static function generateIndexRoute(
        $collection,
        $name,
        $class = null,
        $mapPrefix = ''
    ) {
        $params = ["controller" => "index", "action" => "index"];

        self::generateLiteralRoute(
            $collection, $name . '.slash', $class, $mapPrefix, '', $params
        );

        return self::generateLiteralRoute(
            $collection, $name, $class, $mapPrefix, '/', $params
        );
    }

    /**
     * @param RouteCollection $collection
     * @param $name
     * @param $class
     * @param string $mapPrefix
     * @param string $map
     * @param array $params
     * @return mixed
     */
    public static function generateLiteralRoute(
        $collection,
        $name,
        $class = null,
        $mapPrefix = '',
        $map = '/',
        $params = []
    ) {
        $map = $mapPrefix . $map;
        $class = empty($class) ? LiteralRoute::class : $class;

        return self::generateGenericRoute($collection, $name, $class, $map, $params);
    }

    /**
     * @param RouteCollection $collection
     * @param $name
     * @param $class
     * @param string $map
     * @param array $params
     * @return mixed
     */
    public static function generateGenericRoute(
        $collection,
        $name,
        $class = null,
        $map,
        $params = []
    ) {
        $map = str_replace('//', '/', $map);
        $class = static::generateRouteClassName($class);

        $route = new $class($map, $params);
        return $collection->addRoute($route, $name);
    }

    /**
     * @param RouteCollection $collection
     * @param $name
     * @param $class
     * @param string $mapPrefix
     * @param string $map
     * @param array $params
     */
    public static function generateStandardRoute(
        $collection,
        $name,
        $class = null,
        $mapPrefix = '',
        $map = '/{controller}/{action?index}',
        $params = []
    ) {
        $class = empty($class) ? StandardRoute::class : $class;
        self::generateGenericRoute($collection, $name, $class, $mapPrefix . $map, $params);

        $params['action'] = 'index';
        self::generateGenericRoute($collection, $name . '.index', $class, $mapPrefix . '/{controller}/',
            $params);
    }

    /**
     * @param null $class
     * @return string
     */
    protected static function generateRouteClassName($class = null)
    {
        if (empty($class)) {
            return Route::class;
        }

        if (class_exists($class)) {
            return $class;
        }

        $maps = [
            LiteralRoute::class => ['_Literal', '\Literal'],
            StandardRoute::class => ['_Standard', '\Standard']
        ];
        foreach ($maps as $routeClass => $needles) {
            foreach ($needles as $needle) {
                if (strpos($class, $needle) !== false) {
                    return $routeClass;
                }
            }
        }

        return Route::class;
    }
}
