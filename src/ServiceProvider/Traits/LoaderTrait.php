<?php

namespace Nip\Router\ServiceProvider\Traits;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\DirectoryLoader;
use Symfony\Component\Routing\Loader\PhpFileLoader;

/**
 * Trait LoaderTrait
 * @package Nip\Router\ServiceProvider\Traits
 */
trait LoaderTrait
{
    public function registerLoader()
    {
        $this->getContainer()->share('routing.loader', function () {
            return $this->createLoader();
        });
    }

    /**
     * @return \Symfony\Component\Config\Loader\DelegatingLoader
     */
    protected function createLoader()
    {
        $app = $this->getContainer()->get('app');

        $locator = new FileLocator([
            $app->basePath() . DIRECTORY_SEPARATOR . 'routes',
            $app->path(),
            $app->basePath(),
        ]);

        $resolver = new \Symfony\Component\Config\Loader\LoaderResolver();
        $resolver->addLoader(new PhpFileLoader($locator));
        $resolver->addLoader(new DirectoryLoader($locator));

        $loader = new \Nip\Router\Loader\DelegatingLoader($resolver);

        return $loader;
    }
}
