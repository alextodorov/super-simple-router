<?php

namespace SSRouter\UnitTest;

use PHPUnit\Framework\TestCase;
use SSRouter\Router;

abstract class MainRouter extends TestCase
{
    protected static Router $router;

    public static function setUpBeforeClass(): void
    {
        self::$router = new Router; 
    }
}
