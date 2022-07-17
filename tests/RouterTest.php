<?php

namespace SSRouter\UnitTest;

use SSRouter\HTTPMethod;
use SSRouter\NotFound;

class RouterTest extends MainRouter
{
    public function testAddRoute(): void
    {
        self::$router->addRoute('/test', HTTPMethod::from('GET'), function () {return 'success';});

        $this->assertIsArray(self::$router->getConfig());
        $this->assertIsCallable(self::$router->getConfig()['GET']['/test']);
    }

    public function testConfig(): void
    {
        self::$router->setConfig(
            [
                [
                    'uri' => '/test',     
                    'method' => 'GET', 
                    'handler' => function () { return 'success'; },
                ],
            ]
        );

        $this->assertIsArray(self::$router->getConfig());
        $this->assertIsCallable(self::$router->getConfig()['GET']['/test']);
    }

    public function testParse(): void
    {   
        $config = [
            'uri' => '/test',     
            'method' => 'GET', 
            'handler' => function () { return 'success'; },
        ];

        $result = self::$router->parse($config['uri'], HTTPMethod::from($config['method']));

        $this->assertSame($config['uri'], $result[0]);
        $this->assertIsCallable($result[1]);
        $this->assertSame('success', $result[1]());
    }

   /** @dataProvider provideNotExistingRoutes */
   public function testNotFoundRoute(array $config, $notFoundRoutes): void
   {
       self::$router->setConfig([$config]);

       $this->expectException(NotFound::class);
       $this->expectExceptionMessage('Route Not Found.');

       self::$router->parse($notFoundRoutes['uri'], HTTPMethod::from($notFoundRoutes['method']));
   }

   /** @dataProvider provideBadRouteConfig */
   public function testBadConfig(array $config, string $expectedMessage): void
   {
       $this->expectError();
       $this->expectErrorMessage($expectedMessage);

       $this::$router->setConfig($config);
   }

   public function provideNotExistingRoutes(): array
   {
       return [
           [
               [
                   'uri' => '/just-a-test-route-not-exist/43',
                   'method' => 'GET',
                   'handler' => function () { return 'success'; },
               ],
               [
                   'uri' => '/route-exist/43',
                   'method' => 'POST',
               ],
           ],
           [
               [
                   'uri' => '/just-a-test-route-not-exist/sub-route/43',
                   'method' => 'GET',
                   'handler' => function () { return 'success'; },
               ],
               [
                   'uri' => '/route-not-exist/sub-route2',
                   'method' => 'GET',
               ],
           ],
           [
               [
                   'uri' => '/just-a-test-route-not-exist/sub-route/product-slug?q=2',
                   'method' => 'GET',
                   'handler' => function () { return 'success'; },
               ],
               [
                   'uri' => '/test-route-not-exist?q=2',
                   'method' => 'GET',
               ],
           ],
       ];
   }

   public function provideBadRouteConfig(): array
   {
       return [
           [
               [
                   'uri' => '/just-a-test-route/43',
                   'method' => 'GET',
               ],
               'Cannot access offset of type string on string',
           ],
           [
               [
                   'method' => 'GET',
                   'handler' => function () { return 'success'; },
               ],
               'Cannot access offset of type string on string',
           ],
           [
               [
                   'uri' => '/just-a-test-route/sub-route/product-slug?q=2',
                   'handler' => function () { return 'success'; },
               ],
               'Cannot access offset of type string on string',
           ],
           [
               [
                   'uri' => null,
                   'method' => 'GET',
                   'handler' => function () { return 'success'; },
               ],
               'Trying to access array offset on value of type null',
           ],
           [
               [
                   'uri' => '/test',
                   'method' => 'A',
                   'handler' => function () { return 'success'; },
               ],
               'Cannot access offset of type string on string',
           ],
           [
               [
                   'uri' => '/test',
                   'method' => 'A',
                   'handler' => null,
               ],
               'Cannot access offset of type string on string',
           ],
       ];
   }
}
