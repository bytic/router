<?php

use Nip\Router\Loader\DelegatingLoader;
use Nip\Router\Generator\UrlGenerator;
use Nip\Router\Route\Route as NipRoute;
use Nip\Router\RouteCollection;
use Nip\Router\Router;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Loader\ClosureLoader;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection as SymfonyRouteCollection;

class SymfonyCompatibilityTest extends TestCase
{
    public function testSymfonyRoutesCanBeLoadedMatchedAndGenerated(): void
    {
        $resolver = new LoaderResolver([new ClosureLoader()]);
        $loader = new DelegatingLoader($resolver);
        $resource = function () {
            $routes = new SymfonyRouteCollection();
            $routes->add('article', new Route('/articles/{id}', ['id' => '1']));

            return $routes;
        };
        $router = new Router($loader, $resource);

        self::assertInstanceOf(RouteCollection::class, $router->getRouteCollection());
        self::assertTrue($router->getRouteCollection()->has('article'));
        self::assertTrue(isset($router->getRouteCollection()['article']));
        self::assertTrue($router->hasRoute('article'));
        self::assertTrue((new UrlGenerator($router->getRouteCollection(), new RequestContext()))->hasRoute('article'));
        self::assertSame('/articles/42', $router->generate('article', ['id' => '42']));
        self::assertSame('/articles/42', $router->assemble('article', ['id' => '42']));
        self::assertEquals(
            ['id' => '42', '_route' => 'article'],
            $router->matchRequest(Request::create('/articles/42'))
        );
    }

    public function testRouterAcceptsSymfonyLoadersDirectly(): void
    {
        $resource = function () {
            $routes = new SymfonyRouteCollection();
            $routes->add('article', new Route('/articles/{id}'));

            return $routes;
        };
        $router = new Router(new ClosureLoader(), $resource);

        $routes = $router->getRouteCollection();
        self::assertInstanceOf(RouteCollection::class, $routes);
        self::assertSame($routes, $router->getRouteCollection());
        self::assertTrue($routes->has('article'));
        self::assertSame('/articles/42', $router->generate('article', ['id' => '42']));
        self::assertEquals(
            ['id' => '42', '_route' => 'article'],
            $router->matchRequest(Request::create('/articles/42'))
        );
    }

    public function testLegacyRoutesCanBeUsedAlongsideSymfonyRoutes(): void
    {
        $router = new Router();
        $router->initRouteCollection();
        $legacy = new NipRoute();
        $legacy->setName('legacy');
        $legacy->setPath('/legacy');
        $router->addRoute($legacy);
        $router->getRouteCollection()->add('article', new Route('/articles/{id}'));

        self::assertTrue($router->getRouteCollection()->has($legacy));
        self::assertTrue($router->getRouteCollection()->has('article'));
        self::assertSame('/legacy', $router->assemble('legacy'));
        self::assertSame('/articles/42', $router->generate('article', ['id' => '42']));
        self::assertEquals(['_route' => 'legacy'], $router->matchRequest(Request::create('/legacy')));
    }

    public function testCachedSymfonyRoutesCanBeReused(): void
    {
        $cacheDir = tempnam(sys_get_temp_dir(), 'router-compatibility-');
        self::assertNotFalse($cacheDir);
        unlink($cacheDir);

        $resource = function () {
            $routes = new SymfonyRouteCollection();
            $routes->add('article', new Route('/articles/{id}'));

            return $routes;
        };

        try {
            for ($i = 0; $i < 2; ++$i) {
                $router = new Router(new ClosureLoader(), $resource, ['cache_dir' => $cacheDir]);
                self::assertTrue($router->hasRoute('article'));
                self::assertSame('/articles/42', $router->generate('article', ['id' => '42']));
                self::assertEquals(
                    ['id' => '42', '_route' => 'article'],
                    $router->matchRequest(Request::create('/articles/42'))
                );
            }
        } finally {
            (new Filesystem())->remove($cacheDir);
        }
    }
}
