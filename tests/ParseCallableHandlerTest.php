<?php

namespace SSRouter\UnitTest;

use SSRouter\HTTPMethod;

class ParseCallableHandlerTest extends MainRouter
{
    /** @dataProvider provideStaticRoutes */
    public function testParseStaticRoute(array $config): void
    {   
        self::$router->setConfig([$config]);

        $result = self::$router->parse($config['uri'], HTTPMethod::from($config['method']));

        $this->assertSame($config['uri'], $result[0]);
        $this->assertIsCallable($result[1]);
        $this->assertSame('success', $result[1]());
    }

    /** @dataProvider provideRoutesWithParams */
    public function testParseRouteWithParams(array $config, string $param): void
    {
        self::$router->setConfig([$config]);

        $result = self::$router->parse($config['uri'] . '/' . $param, HTTPMethod::from($config['method']));

        $this->assertSame($config['uri'], $result[0]);
        $this->assertIsCallable($result[1]);
        $this->assertSame('success', $result[1]());
        $this->assertSame($param, $result[2][1]);
    }

    public function provideStaticRoutes(): array
    {
        return [
            [
                [
                    'uri' => '/just-a-test-route',
                    'method' => 'GET',
                    'handler' => function () { return 'success'; },
                ],
            ],
            [
                [
                    'uri' => '/just-a-test-route/sub-route',
                    'method' => 'POST',
                    'handler' => function () { return 'success'; },
                ],
            ],
            [
                [
                    'uri' => '/just-a-test-route/put',
                    'method' => 'PUT',
                    'handler' => function () { return 'success'; },
                ],
            ],
            [
                [
                    'uri' => '/just-a-test-route/head',
                    'method' => 'HEAD',
                    'handler' => function () { return 'success'; },
                ],
            ],
            [
                [
                    'uri' => '/just-a-test-route/options',
                    'method' => 'OPTIONS',
                    'handler' => function () { return 'success'; },
                ],
            ],
            [
                [
                    'uri' => '/just-a-test-route/connect',
                    'method' => 'CONNECT',
                    'handler' => function () { return 'success'; },
                ],
            ],
            [
                [
                    'uri' => '/just-a-test-route/delete',
                    'method' => 'DELETE',
                    'handler' => function () { return 'success'; },
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
                    'handler' => function () { return 'success'; },
                ],
                '43'
            ],
            [
                [
                    'uri' => '/just-a-test-route-with-params/sub-route',
                    'method' => 'GET',
                    'handler' => function () { return 'success'; },
                ],
                '32'
            ],
            [
                [
                    'uri' => '/just-a-test-route-with-parmas/sub-route',
                    'method' => 'GET',
                    'handler' => function () { return 'success'; },
                ],
                'product-slug'
            ],
            [
                [
                    'uri' => '/just-a-test-route-with-params/sub-route',
                    'method' => 'POST',
                    'handler' => function () { return 'success'; },
                ],
                '23'
            ],
        ];
    }
}
