<?php

namespace Nip\Router;

use Nip\Request;
use Nip\Router\Generator\UrlGenerator;
use Nip\Router\Route\AbstractRoute as Route;
use Nip\Router\Router\Traits\HasCurrentRouteTrait;
use Nip\Router\Router\Traits\HasGeneratorTrait;
use Nip\Router\Router\Traits\HasMatcherTrait;
use Nip\Router\Router\Traits\HasRouteCollectionTrait;
use Symfony\Component\Routing\Loader\ClosureLoader;

/**
 * Class Router
 * @package Nip\Router
 */
class Router extends \Symfony\Component\Routing\Router
{
    use HasRouteCollectionTrait;
    use HasCurrentRouteTrait;
    use HasMatcherTrait;
    use HasGeneratorTrait;

    public function __construct()
    {
        $loader = new ClosureLoader();
        $options = [
            'generator_class' => UrlGenerator::class,
        ];
        return parent::__construct($loader, null, $options);
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
