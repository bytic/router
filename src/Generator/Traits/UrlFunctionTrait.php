<?php

namespace Nip\Router\Generator\Traits;

use Nip\Router\RequestContext;
use Nip\Utility\Str;

/**
 * Trait UrlFunctionTrait
 * @package Nip\Router\Generator\Traits
 * @method RequestContext getContext()
 */
trait UrlFunctionTrait
{
    /**
     * Get the full URL for the current request.
     *
     * @return string
     */
    public function full()
    {
        return $this->getContext()->fullUrl();
    }

    /**
     * Get the current URL for the request.
     *
     * @return string
     */
    public function current()
    {
        return $this->to($this->getContext()->getPathInfo());
    }

    /**
     * Generate an absolute URL to the given path.
     *
     * @param  string  $path
     * @param  mixed  $extra
     * @param  bool|null  $secure
     * @return string
     */
    public function to($path, $extra = [], $secure = null)
    {
        // First we will check if the URL is already a valid URL. If it is we will not
        // try to generate a new one but will simply return the URL as is, which is
        // convenient since developers do not always have to check if it's valid.
        if ($this->isValidUrl($path)) {
            return $path;
        }
        $tail = implode('/', array_map(
                'rawurlencode', (array) $this->formatParameters($extra))
        );
        // Once we have the scheme we will compile the "tail" by collapsing the values
        // into a single string delimited by slashes. This just makes it convenient
        // for passing the array of parameters to this URL as a list of segments.
        $root = $this->formatRoot($this->formatScheme($secure));
        list($path, $query) = $this->extractQueryString($path);
        return $this->format(
                $root, '/' . trim($path . '/' . $tail, '/')
            ) . $query;
    }

    /**
     * Generate the URL to an application asset.
     *
     * @param  string $path
     * @param  bool|null $secure
     * @return string
     */
    public function asset($path, $secure = null)
    {
        if ($this->isValidUrl($path)) {
            return $path;
        }
        // Once we get the root URL, we will check to see if it contains an index.php
        // file in the paths. If it does, we will remove it since it is not needed
        // for asset paths, but only for routes to endpoints in the application.
        $root = $this->formatRoot($this->formatScheme($secure));
        return $this->removeIndex($root) . '/assets/' . trim($path, '/');
    }

    /**
     * Determine if the given path is a valid URL.
     *
     * @param  string $path
     * @return bool
     */
    public function isValidUrl($path)
    {
        if (!Str::startsWith($path, ['#', '//', 'mailto:', 'tel:', 'http://', 'https://'])) {
            return filter_var($path, FILTER_VALIDATE_URL) !== false;
        }
        return true;
    }


    /**
     * Extract the query string from the given path.
     *
     * @param  string  $path
     * @return string[]
     */
    protected function extractQueryString($path)
    {
        if (($queryPosition = strpos($path, '?')) !== false) {
            return [
                substr($path, 0, $queryPosition),
                substr($path, $queryPosition),
            ];
        }
        return [$path, ''];
    }
}