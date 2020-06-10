<?php

declare(strict_types=1);

namespace Deviant;

use Deviant\Component\Container;
use Deviant\Component\Request;
use Deviant\Component\Response;
use Deviant\Component\Router;
use Exception;

class App
{
    /**
     * @var Container
     */
    private Container $container;

    /**
     * @var Response
     */
    private Response $response;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var Router
     */
    private Router $router;

    public function __construct()
    {
        $this->container = new Container();
        $this->response = new Response();
        $this->request = new Request();
        $this->router = new Router();
    }

    /**
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * @param string $route
     * @param callable $callable
     */
    public function get(string $route, callable $callable): void
    {
        if ($this->request->isMethodGet()) {
            $this->router->add($route, $callable);
        }
    }

    /**
     * @param string $route
     * @param callable $callable
     */
    public function post(string $route, callable $callable): void
    {
        if ($this->request->isMethodPost()) {
            $this->router->add($route, $callable);
        }
    }

    public function run(): void
    {
        try {
            $response = $this->handle();

            $this->emit($response);
        } catch (Exception $e) {
            $response = new Response();
            $response->withBody($e->getMessage());
            $response->withCode($e->getCode());

            $this->emit($response);
        }
    }

    /**
     * @return Response
     *
     * @throws Exception
     */
    private function handle(): Response
    {
        [$callable, $arguments] = $this->router->get();

        if (is_array($callable)) {
            $object = new $callable[0]($this->container);
            $method = $callable[1];

            return $object->$method($this->response, $this->request, $arguments);
        }

        $callable = $callable->bindTo($this->container);

        return $callable($this->response, $this->request, $arguments);
    }

    /**
     * @param Response $response
     */
    private function emit(Response $response): void
    {
        http_response_code($response->getCode());

        foreach ($response->getHeaders() as $key => $value) {
            header($key . ':' . $value);
        }

        echo $response->getBody();
    }
}
