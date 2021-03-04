<?php

namespace App\Components;

use App\Components\Exceptions\NotFoundException;
use App\Components\Interfaces\RequestInterface;
use App\Components\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    /**
     * Request URI
     * @var string
     */
    private string $uri;

    /**
     * Routes
     * @var array
     */
    private array $routes;

    /**
     * Controller name
     * @var string
     */
    private string $controller;

    /**
     * Action name
     * @var string
     */
    private string $action;

    /**
     * Router constructor.
     * @param RequestInterface $request
     * @throws NotFoundException
     */
    public function __construct(RequestInterface $request)
    {
        $this->uri = trim($request->getRequestUri(), '/');
        $this->routes = $this->getRoutes();

        list('controller' => $controller, 'action' => $action) = $this->uriParsing($request);
        $this->controller = $controller;
        $this->action = $action;

    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Parse the URI and get the controller, action and URI params
     * @param RequestInterface $request
     * @return array
     * @throws NotFoundException
     */
    private function uriParsing(RequestInterface $request): array
    {
        $result = [];
        $split = $this->getSplitRealPath();

        $request->setRequestBody($split);

        $result['controller'] = ucfirst(array_shift($split)) . 'Controller';
        $result['action'] = array_shift($split);

        return $result;
    }

    /**
     * Checking the URI matches the routes
     * @return array ('uriPattern', 'path')
     * @throws NotFoundException
     */
    private function checkRequestUri(): array
    {
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~^$uriPattern$~", $this->uri)) {

                return [$uriPattern, $path];
            }
        }

        throw new NotFoundException("This {$this->uri} does not exist in routes");
    }

    /**
     * Changing the URI according to the route
     * and we break this string into parts by "/"
     * @return array
     * @throws NotFoundException
     */
    public function getSplitRealPath(): array
    {
        [$uriPattern, $path] = $this->checkRequestUri();
        $realPath = preg_replace("~^$uriPattern$~", $path, $this->uri);
        return explode('/', $realPath);
    }

    /**
     * Get routes
     * @return mixed
     */
    private function getRoutes()
    {
        return require_once ROOT . '/../App/config/routes.php';
    }
}
