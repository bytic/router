# Router
ByTIC Router component

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bytic/router.svg?style=flat-square)](https://packagist.org/packages/bytic/router)
[![Latest Stable Version](https://poser.pugx.org/bytic/router/v/stable)](https://packagist.org/packages/bytic/router)
[![Latest Unstable Version](https://poser.pugx.org/bytic/router/v/unstable)](https://packagist.org/packages/bytic/router)

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Symfony compatibility](https://github.com/bytic/router/actions/workflows/symfony-compatibility.yml/badge.svg)](https://github.com/bytic/router/actions/workflows/symfony-compatibility.yml)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/92329f47-7940-4b14-91e9-45330b887bdd/mini.png)](https://insight.sensiolabs.com/projects/92329f47-7940-4b14-91e9-45330b887bdd)
[![Quality Score](https://img.shields.io/scrutinizer/g/bytic/router.svg?style=flat-square)](https://scrutinizer-ci.com/g/bytic/router)
[![StyleCI](https://styleci.io/repos/119902214/shield?branch=master)](https://styleci.io/repos/119902214)
[![Total Downloads](https://img.shields.io/packagist/dt/bytic/router.svg?style=flat-square)](https://packagist.org/packages/bytic/router)

## Compatibility

The router supports Symfony Routing, Config and HttpFoundation 5 through 8.
Symfony 8 requires PHP 8.4 or newer; Composer selects compatible versions for
older PHP releases. Existing Nip routes and helpers remain available, and
standard Symfony routes can be loaded, matched and generated alongside them.

For example, a Symfony loader can be passed directly to the router:

```php
use Nip\Router\Router;
use Symfony\Component\Routing\Loader\ClosureLoader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$router = new Router(new ClosureLoader(), function () {
    $routes = new RouteCollection();
    $routes->add('article', new Route('/articles/{id}'));

    return $routes;
});

$url = $router->generate('article', ['id' => 42]);
```

The compatibility workflow tests matching Symfony component versions in an
isolated installation. Some optional ByTIC integrations may have narrower
Symfony version constraints of their own.
