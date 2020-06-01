<?php

declare(strict_types=1);

namespace Deviant\Component;

use Exception;

class Router
{
    /**
     * @var array
     */
    private array $routes;

    /**
     * @param string $route
     * @param callable $callable
     */
    public function add(string $route, callable $callable): void
    {
        if (is_string($callable)) {
            $callable = explode('::', $callable);
        }

        $route = trim($route, '/');

        $this->routes[$route] = $callable;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function get(): array
    {
        $uri = trim($_SERVER['REQUEST_URI'], '/');

        foreach ($this->routes as $route => $callable) {
            $pattern = '|^' . preg_replace('/{(\w+)}/', '(?<$1>\w+)', $route) . '$|';

            if (preg_match($pattern, $uri, $matches)) {
                $arguments = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                return [$callable, $arguments];
            }
        }

        throw new Exception('404 Not Found');
    }
}