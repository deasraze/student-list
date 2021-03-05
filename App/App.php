<?php

namespace App;

use App\Components\DIContainer;
use App\Components\Exceptions\ContainerException;
use App\Components\Response;

class App
{
    /**
     * @var DIContainer
     */
    private DIContainer $container;

    /**
     * App constructor.
     * @param DIContainer $container
     */
    public function __construct(DIContainer $container)
    {
        $this->container = $container;
    }

    /**
     * Start application
     * @throws ContainerException
     */
    public function run(): void
    {
        set_error_handler([$this, 'errorHandler']);
        $router = $this->container->get('router');
        $response = $router->route($this->container, $this->createResponse());
        $this->respond($response);
    }

    /**
     * Send response
     * @param Response $response
     */
    private function respond(Response $response): void
    {
        $body = $response->getBody();

        if (!headers_sent()) {
            header(sprintf(
                'HTTP/1.0 %s %s',
                $response->getStatusCode(),
                $response->getStatusPhrase()
            ));
            foreach ($response->getHeaders() as $name => $value) {
                header(sprintf('%s: %s', $name, $value), false);
            }

            header('Content-Length: ' . strlen($body));
        }

        echo $body;
    }

    /**
     * Create new response
     * @return Response
     */
    private function createResponse(): Response
    {
        return new Response([], '', 200);
    }

    /**
     * Error handler
     * If error output is enabled, then we turn all errors into exceptions
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @return bool
     * @throws \ErrorException
     */
    public function errorHandler(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        if (!error_reporting()) {
            return false;
        }

        throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
    }
}
