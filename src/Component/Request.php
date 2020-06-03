<?php

declare(strict_types=1);

namespace Deviant\Component;

class Request
{
    private const METHOD_GET = 'GET';
    private const METHOD_POST = 'POST';

    /**
     * @var string
     */
    private string $method;

    public function __construct()
    {
        $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return bool
     */
    public function isMethodGet(): bool
    {
        return $this->method === self::METHOD_GET;
    }

    /**
     * @return bool
     */
    public function isMethodPost(): bool
    {
        return $this->method === self::METHOD_POST;
    }
}
