<?php

declare(strict_types=1);

namespace Deviant\Component;

class Container
{
    /**
     * @var array
     */
    private array $storage = [];

    /**
     * @param string $name
     * @param object $instance
     */
    public function set(string $name, object $instance): void
    {
        $this->storage[$name] = $instance;
    }

    /**
     * @param string $name
     *
     * @return object|null
     */
    public function get(string $name): ?object
    {
        return $this->storage[$name];
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->storage[$name]);
    }
}
