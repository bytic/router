<?php

use Nip\Request;
use Nip\Router\Route\Route;
use Nip\Router\RouteFactory;
use Nip\Router\Router;

/**
 * Class RouterBench
 * @Iterations(5)
 * @Revs(1000)
 * @BeforeMethods({"init"})
 */
class RouterBench
{
    /**
     * @var Router
     */
    protected $router;

    public function benchStaticRoutes()
    {
        $request = Request::create('/index999');
        $this->router->route($request);
    }

    public function init()
    {
        $this->router = new Router();
        $collection = $this->router->getRoutes();

        for ($i = 0; $i < 10000; ++$i) {
            RouteFactory::generateLiteralRoute(
                $collection,
                "index." . $i,
                Route::class,
                "",
                "/index" . $i);
        }
    }
}