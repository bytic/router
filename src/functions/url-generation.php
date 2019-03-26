<?php

namespace Nip\Router;

/**
 * @param $name
 * @param array $parameters
 * @param bool $absolute
 * @return string|null
 */
function route($name, $parameters = [], $absolute = true)
{
    if (!function_exists('app')) {
        return null;
    }
    if ($absolute === true) {
        return app('router')->assembleFull($name, $parameters);
    }
    return app('router')->assemble($name, $parameters);
}
