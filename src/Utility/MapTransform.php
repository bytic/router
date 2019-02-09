<?php

namespace Nip\Router\Utility;

/**
 * Class MapTransform
 * @package Nip\Router\Utility
 */
class MapTransform
{
    /**
     * @param $map
     * @return string|string[]|null
     */
    public static function run($map)
    {
        $map = str_replace(':controller/:action', '{controller}/{action?index}', $map);
        if (self::needToRun($map)) {
            $map = self::transform($map);
        }

        return $map;
    }

    /**
     * @param $string
     * @return bool
     */
    protected static function needToRun($string)
    {
        return strpos($string, ':') !== false;
    }

    /**
     * @param $string
     * @return string|string[]|null
     */
    protected static function transform($string)
    {
        $return = preg_replace('/:([a-z]+)/', '{${0}}', $string);
        return str_replace('{:', '{', $return);
    }
}