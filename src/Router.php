<?php

namespace Nip\Router;

use Nip\Request;
use Nip\Router\Generator\CompiledUrlGenerator;
use Nip\Router\Generator\UrlGenerator;
use Nip\Router\Legacy\Router\Traits\HasMatcherTrait as LegacyHasMatcherTrait;
use Nip\Router\Router\Traits\HasCurrentRouteTrait;
use Nip\Router\Router\Traits\HasGeneratorTrait;
use Nip\Router\Router\Traits\HasMatcherTrait;
use Nip\Router\Router\Traits\HasRouteCollectionTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Routing\Loader\ClosureLoader;

/**
 * Class Router
 * @package Nip\Router
 *
 * @method CompiledUrlGenerator getGenerator()
 */
class Router extends \Symfony\Component\Routing\Router
{
    use LegacyHasMatcherTrait;

    use HasRouteCollectionTrait;
    use HasCurrentRouteTrait;
    use HasGeneratorTrait;
    use HasMatcherTrait;

    /**
     * @inheritdoc
     */
    public function __construct(
        LoaderInterface $loader = null,
        $resource = null,
        array $options = [],
        RequestContext $context = null,
        LoggerInterface $logger = null
    ) {
        $loader = $loader ?: new ClosureLoader();
        $options['generator_class'] = isset($options['generator_class']) ? $options['generator_class'] : CompiledUrlGenerator::class;
//        $options['generator_base_class'] = isset($options['generator_base_class']) ? $options['generator_base_class'] : UrlGenerator::class;
        $context = $context ?: new RequestContext();
        return parent::__construct($loader, $resource, $options, $context, $logger);
    }

    /**
     * @var \Nip\Request
     */
    protected $request;


    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }
}
