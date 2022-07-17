<?php

declare(strict_types=1);

namespace SSRouter;

use function mb_strpos;
use function mb_strlen;
use function mb_substr;
use function explode;
use function array_filter;

class Router implements Routerable
{
    private array $config = [];

    public function addRoute(string $uri, HTTPMethod $method, callable|array $handler): void
    {
        $this->config[$method->value][$uri] = $handler;
    }

    public function setConfig(array $config): void
    {
        $this->config = [];

        foreach ($config as $params) {
            $this->addRoute(
                $params['uri'],
                HTTPMethod::from($params['method']),
                $params['handler']
            );
        }
    }

    public function parse(string $uri, HTTPMethod $method): array
    {
        if (!isset($this->config[$method->value])) {
            throw new NotFound('Route Not Found.');
        }

        if (isset($this->config[$method->value][$uri])) {
            return [$uri, $this->config[$method->value][$uri]];
        }

        foreach ($this->config[$method->value] as $url => $handler) {
            if (mb_strpos($uri, $url) !== false) {
                return [$url, $handler, array_filter(explode('/', mb_substr($uri, mb_strlen($url))))];
            }
        }

        throw new NotFound('Route Not Found.');
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}
