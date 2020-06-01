<?php

declare(strict_types=1);

namespace Deviant\Component;

class Response
{
    /**
     * @var int
     */
    private int $code = 200;

    /**
     * @var array
     */
    private array $headers = [];

    /**
     * @var string
     */
    private string $body = '';

    /**
     * @param int $code
     *
     * @return Response
     */
    public function withCode(int $code): Response
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function withHeader(string $name, string $value): Response
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param string $body
     *
     * @return Response
     */
    public function withBody(string $body): Response
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param array $data
     *
     * @return Response
     */
    public function withJson(array $data): Response
    {
        $this->withHeader('Content-Type', 'application/json');

        $this->body = json_encode($data);

        return $this;
    }
}
