<?php

namespace Nip\Router;

use ArrayAccess;
use Nip\Router\RouteCollections\Traits\ArrayAccessTrait;
use Nip\Router\RouteCollections\Traits\CollectionsOperationsTrait;
use Nip\Router\RouteCollections\Traits\RouteLoaderTrait;

/**
 * Class RouteCollection
 * @package Nip\Router
 */
class RouteCollection extends \Symfony\Component\Routing\RouteCollection implements ArrayAccess
{
    use RouteLoaderTrait;
    use ArrayAccessTrait;
    use CollectionsOperationsTrait;
}
