<?php

namespace SSRouter;

interface Routerable
{
    public function addRoute(string $uri, HTTPMethod $method, callable|array $handler): void;
    public function setConfig(array $config): void;
    public function getConfig(): array;
    public function parse(string $uri, HTTPMethod $method): array;
}
