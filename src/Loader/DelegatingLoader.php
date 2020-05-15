<?php

namespace Nip\Router\Loader;

use Symfony\Component\Config\Loader\DelegatingLoader as SymfonyDirectoryLoader;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class DelegatingLoader
 * @package Nip\Router\Loader
 */
class DelegatingLoader extends SymfonyDirectoryLoader
{
    /**
     * {@inheritdoc}
     */
    public function load($file, $type = null)
    {
        $collection = parent::load($file, $type);
        return $this->transformCollection($collection);
    }

    /**
     * @param RouteCollection $symfonyCollection
     * @return \Nip\Router\RouteCollection
     */
    protected function transformCollection(RouteCollection $symfonyCollection)
    {
        $collection = new \Nip\Router\RouteCollection();
        $collection->addCollection($symfonyCollection);

        return $collection;
    }
}
