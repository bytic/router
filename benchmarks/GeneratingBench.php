<?php

use Nip\Router\Route\Route;
use Nip\Router\RouteFactory;
use Nip\Router\Router;
use Nip\Router\Tests\Fixtures\Application\Library\Router\Route\StandardRoute;

/**
 * Class GeneratingBench
 * @Iterations(5)
 * @Revs(100)
 * @BeforeMethods({"init"})
 */
class GenerationBench
{
    /**
     * @var Router
     */
    protected $router;

    public function benchAssembleStaticNip()
    {
        $this->router->assemble(
            'index.999',
            ['controller' => 'posts', 'action' => 'create', 'title' => 'test']
        );
    }

    public function benchAssembleStandardNip()
    {
        $this->router->assemble(
            'index.standard999',
            ['controller' => 'posts', 'action' => 'create', 'title' => 'test']
        );
    }

    public function benchAssembleStaticSymfony()
    {
        $this->router->generate(
            'index.999',
            ['controller' => 'posts', 'action' => 'create', 'title' => 'test']
        );
    }

    public function benchAssembleDynamicSymfony()
    {
        $this->router->generate(
            'index.standard999',
            ['controller' => 'posts', 'action' => 'create', 'title' => 'test']
        );
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
                "/" . $i);
        }
    }
}
