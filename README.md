# Super Simple Router
PHP router library


![Build Status](https://github.com/alextodorov/super-simple-router/actions/workflows/phpunit.yml/badge.svg?branch=main)

Install
-------

```sh
composer require super-simple/router
```

Requires PHP 8.1 or newer.

Usage
-----

Basic usage:

```php

// Create a router.
$router = new Router;

// Add a route
$router->addRoute(
    '/test', // uri
    HTTPMethod::from($httpMethod), // http method
    function () {return 'success';} // handler in this case callable
);

// Or add a route as array

$router->addRoute(
    '/test', // uri
    HTTPMethod::from($httpMethod), // http method
    [
        'controller' => SomeController::class,
        'action' => 'index',
    ] // handler in this case array with config
);

// Or create a config and add routes using config. The config requires keys: uri,method,handler
// It depends on developer how to construct the handler array.
$config = [
    'uri' => '/just-a-test-route',
    'method' => 'GET',
    'handler' => [
        'controller' => SomeController::class,
        'action' => 'index',
    ],
];

$router->addConfig($config);

......


// Parse upcoming request

$result = $router->parse($uri, HTTPMethod::from($httpMethod)); // $uri and $httpMethod must come from Request.

```

The result of parsing is an array.
On first index is teh uri, the second is handler and the third contains the params if any exist.

```php

$result[0]; // is the uri.

// if callable you can call it as:
$result[1]();

// or with params

$result[1](...$result[2] ?? []);

// when using array instead of callable:
// It depends on structure of handler array in this example we have two keys the controller and the action.
(new $result[1]['controller'])->{$result[1]['action']}();

// Or with params
(new $result[1]['controller'])->{$result[1]['action']}(...$result[2]);

```

You can expect some exceptions:

```php

SSRouter\\NotFound // when router is not found
\ValueError // when method not found in HTTPMethod enum
\TypeError // comes from HTTPMethod enum or when the config array is not build correctly.

// Simple use 
try {
    //.......   
} catch {} // to handle these errors.

```