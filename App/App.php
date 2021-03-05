<?php

namespace App;

use App\Components\DIContainer;
use App\Components\Exceptions\ContainerException;
use App\Components\Response;

class App
{
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
        header(sprintf(
            'HTTP/1.1 %s %s',
            $response->getStatusCode(),
            $response->getStatusPhrase()
        ));

        header('Content-Length:' . strlen($response->getBody()));

        echo $response->getBody();
    }

    /**
     * Create new response
     * @return Response
     */
    private function createResponse(): Response
    {
        return new Response('', 200);
    }

}