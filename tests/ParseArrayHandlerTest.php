<?php

namespace SSRouter\UnitTest;

use SSRouter\HTTPMethod;

class ParseArrayHandlerTest extends MainRouter
{
    /** @dataProvider provideStaticRoutes */
    public function testParseStaticRoute(array $config): void
    {   
        self::$router->setConfig([$config]);

        $result = self::$router->parse($config['uri'], HTTPMethod::from($config['method']));

        $this->assertSame($config['uri'], $result[0]);
        $this->assertSame($config['handler']['controller'], $result[1]['controller']);

        $this->assertSame('success', (new $result[1]['controller'])->{$result[1]['action']}());
    }

    /** @dataProvider provideRoutesWithParams */
    public function testParseRouteWithParams(array $config, string|int $param): void
    {
        self::$router->setConfig([$config]);

        $result = self::$router->parse($config['uri'] . '/' . $param, HTTPMethod::from($config['method']));

        $this->assertSame($config['uri'], $result[0]);
        $this->assertSame($config['handler']['controller'], $result[1]['controller']);

        $this->assertSame($param, (new $result[1]['controller'])->{$result[1]['action']}(...$result[2]));
    }


    public function provideStaticRoutes(): array
    {
        return [
            [
                [
                    'uri' => '/just-a-test-route',
                    'method' => 'GET',
                    'handler' => [
                        'controller' => ControllerOne::class,
                        'action' => 'index',
                    ],
                ],
                [
                    'uri' => '/just-a-test-route/and-sub-route',
                    'method' => 'POST',
                    'handler' => [
                        'controller' => ControllerOne::class,
                        'action' => 'update',
                    ],
                ],
                [
                    'uri' => '/just-a-test-route/put',
                    'method' => 'PUT',
                    'handler' => [
                        'controller' => ControllerOne::class,
                        'action' => 'another',
                    ],
                ],
                [
                    'uri' => '/just-a-test-route/delete',
                    'method' => 'DELETE',
                    'handler' => [
                        'controller' => ControllerOne::class,
                        'action' => 'delete',
                    ],
                ],
                [
                    'uri' => '/just-a-test-route/head',
                    'method' => 'HEAD',
                    'handler' => [
                        'controller' => ControllerOne::class,
                        'action' => 'dummy',
                    ],
                ],
                [
                    'uri' => '/just-a-test-route/options',
                    'method' => 'OPTIONS',
                    'handler' => [
                        'controller' => ControllerOne::class,
                        'action' => 'dummy',
                    ],
                ],
                [
                    'uri' => '/just-a-test-route/connect',
                    'method' => 'CONNECT',
                    'handler' => [
                        'controller' => ControllerOne::class,
                        'action' => 'dummy',
                    ],
                ],
            ],
        ];
    }

    public function provideRoutesWithParams(): array
    {
        return [
            [
                [
                    'uri' => '/just-a-test-route-with-params',
                    'method' => 'GET',
                    'handler' => [
                        'controller' => ControllerTwo::class,
                        'action' => 'slug',
                    ],
                ],
                'test-item'
            ],
            [
                [
                    'uri' => '/update/item',
                    'method' => 'PUT',
                    'handler' => [
                        'controller' => ControllerTwo::class,
                        'action' => 'update',
                    ],
                ],
                43
            ],
            [
                [
                    'uri' => '/delete/item',
                    'method' => 'DELETE',
                    'handler' => [
                        'controller' => ControllerTwo::class,
                        'action' => 'delete',
                    ],
                ],
                22
            ],
            [
                [
                    'uri' => '/post/item',
                    'method' => 'POST',
                    'handler' => [
                        'controller' => ControllerTwo::class,
                        'action' => 'post',
                    ],
                ],
                'success'
            ],
        ];
    }
}
