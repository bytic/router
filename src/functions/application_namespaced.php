<?php

namespace Nip;

if (!function_exists('url')) {
    /** @noinspection PhpFunctionNamingConventionInspection
     *
     * Get Url Generator
     * @return \Nip\Router\Generator\UrlGenerator
     */
    function url()
    {
        return app('url');
    }
}
