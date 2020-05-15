<?php

namespace Nip\Router\Tests\Fixtures\Application\Library;

/**
 * Class Application
 * @package Nip\Router\Tests\Fixtures\Application\Library
 */
class Application
{

    /**
     * Determine if the application routes are cached.
     *
     * @return bool
     */
    public function routesAreCached()
    {
        return ($this->getCachedRoutesPath());
    }

    /**
     * Get the path to the routes cache file.
     *
     * @return string
     */
    public function getCachedRoutesPath()
    {
        return $this->basePath() . '/bootstrap/cache/routes';
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->basePath() . '/application';
    }

    /**
     * @return string
     */
    public function basePath()
    {
        return TEST_FIXTURE_PATH;
    }
}
