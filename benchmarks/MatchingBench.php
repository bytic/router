<?php

use Nip\Request;
use Nip\Router\Route\Route;
use Nip\Router\RouteFactory;
use Nip\Router\Router;
use Nip\Router\Tests\Fixtures\Application\Library\Router\Route\StandardRoute;

/**
 * Class MatchingBench
 * @Iterations(5)
 * @Revs(100)
 * @BeforeMethods({"init"})
 */
class MatchingBench
{
    /**
     * @var Router
     */
    protected $router;

    public function benchStaticRoutesNip()
    {
        $request = Request::create('/index999');
        $this->router->route($request);
    }

    public function benchDynamicRoutesNip()
    {
        $request = Request::create('/999/posts/create');
        $this->router->route($request);
    }

    public function benchStaticRoutesSymfony()
    {
        $request = Request::create('/index999');
        $this->router->matchRequest($request);
    }

    public function benchDynamicRoutesSymfony()
    {
        $request = Request::create('/999/posts/create');
        $this->router->matchRequest($request);
    }

    public function init()
    {
        $this->router = new Router();
        $collection = $this->router->getRoutes();

        for ($i = 0; $i < 1000; ++$i) {
            RouteFactory::generateLiteralRoute(
                $collection,
                "index." . $i,
                Route::class,
                "",
                "/index" . $i);

            RouteFactory::generateStandardRoute(
                $collection,
                "index.standard" . $i,
                StandardRoute::class,
                "/".$i);
        }
    }
}