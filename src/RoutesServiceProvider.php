<?php

namespace Nip\Router;

use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;
use Nip\Container\ServiceProviders\Providers\BootableServiceProviderInterface;

/**
 * Class MailServiceProvider
 * @package Nip\Mail
 */
class RoutesServiceProvider extends AbstractSignatureServiceProvider implements BootableServiceProviderInterface
{

    /**
     * @inheritdoc
     */
    public function register()
    {
    }

    /**
     * @inheritdoc
     */
    public function boot()
    {
        if ($this->routesAreCached()) {
            // Call get matcher to load the routes
//            $this->getContainer()->get('router')->getMatcher();
            return;
        }

        $this->loadRoutes();
    }

    public function loadRoutes()
    {
    }

    /**
     * Determine if the application routes are cached.
     *
     * @return bool
     */
    protected function routesAreCached()
    {
        return $this->getContainer()->get('app')->routesAreCached();
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return [];
    }
}
