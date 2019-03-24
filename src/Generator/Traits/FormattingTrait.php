<?php

namespace Nip\Router\Generator\Traits;

use Nip\Router\RequestContext;
use Nip\Utility\Arr;
use Nip\Utility\Str;

/**
 * Trait FormattingTrait
 * @package Nip\Router\Generator\Traits
 * @method RequestContext getContext()
 */
trait FormattingTrait
{
    /**
     * A cached copy of the URL root for the current request.
     *
     * @var string|null
     */
    protected $cachedRoot;

    /**
     * A cached copy of the URL schema for the current request.
     *
     * @var string|null
     */
    protected $cachedSchema;

    /**
     * The forced URL root.
     *
     * @var string
     */
    protected $forcedRoot;

    /**
     * The forced schema for URLs.
     *
     * @var string
     */
    protected $forceScheme;

    /**
     * The callback to use to format hosts.
     *
     * @var \Closure
     */
    protected $formatHostUsing;

    /**
     * The callback to use to format paths.
     *
     * @var \Closure
     */
    protected $formatPathUsing;

    /**
     * Format the array of URL parameters.
     *
     * @param  mixed|array  $parameters
     * @return array
     */
    public function formatParameters($parameters)
    {
        $parameters = Arr::wrap($parameters);
//        foreach ($parameters as $key => $parameter) {
//            if ($parameter instanceof UrlRoutable) {
//                $parameters[$key] = $parameter->getRouteKey();
//            }
//        }
        return $parameters;
    }

    /**
     * Get the base URL for the request.
     *
     * @param  string $scheme
     * @param  string $root
     * @return string
     */
    public function formatRoot($scheme, $root = null)
    {
        if (is_null($root)) {
            if (is_null($this->cachedRoot)) {
                $this->cachedRoot = $this->forcedRoot ?: $this->getContext()->root();
            }
            $root = $this->cachedRoot;
        }
        $start = Str::startsWith($root, 'http://') ? 'http://' : 'https://';
        return preg_replace('~' . $start . '~', $scheme, $root, 1);
    }

    /**
     * Get the default scheme for a raw URL.
     *
     * @param  bool|null $secure
     * @return string
     */
    public function formatScheme($secure)
    {
        if (!is_null($secure)) {
            return $secure ? 'https://' : 'http://';
        }
        if (is_null($this->cachedSchema)) {
            $this->cachedSchema = $this->forceScheme ?: $this->getContext()->getScheme() . '://';
        }
        return $this->cachedSchema;
    }
    /**
     * Format the given URL segments into a single URL.
     *
     * @param  string $root
     * @param  string $path
     * @return string
     */
    public function format($root, $path)
    {
        $path = '/' . trim($path, '/');
        if ($this->formatHostUsing) {
            $root = call_user_func($this->formatHostUsing, $root);
        }
        if ($this->formatPathUsing) {
            $path = call_user_func($this->formatPathUsing, $path);
        }
        return trim($root . $path, '/');
    }

    /**
     * Remove the index.php file from a path.
     *
     * @param  string $root
     * @return string
     */
    protected function removeIndex($root)
    {
        $i = 'index.php';
        return Str::contains($root, $i) ? str_replace('/' . $i, '', $root) : $root;
    }
}
