<?php

declare(strict_types=1);

namespace Deviant;

use Deviant\Component\Request;
use Deviant\Component\Response;
use Deviant\Component\Router;
use Exception;

class App
{
    /**
     * @var Router
     */
    private Router $router;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var Response
     */
    private Response $response;

    public function __construct()
    {
        $this->router = new Router();
        $this->request = new Request();
        $this->response = new Response();
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

            http_response_code($response->getCode());

            foreach ($response->getHeaders() as $key => $value) {
                header($key . ':' . $value);
            }

            echo $response->getBody();
        } catch (Exception $e) {
            echo $e->getMessage();
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
            $object = new $callable[0];
            $method = $callable[1];

            return $object->$method($this->response, $this->request, $arguments);
        }

        return $callable($this->response, $this->request, $arguments);
    }
}
