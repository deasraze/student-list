<?php

namespace App\Components;

use App\Components\Interfaces\RequestInterface;
use App\Components\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    private array $routes;
    private string $controller;
    private string $action;


    public function __construct(RequestInterface $request)
    {
        $this->routes = $this->getRoutes();

        list('controller' => $controller, 'action' => $action) = $this->uriParsing($request);
        $this->controller = $controller;
        $this->action = $action;

    }

    /**
     * @return mixed|string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return mixed|string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Parse the URI and get the controller, action and URI params
     * @param RequestInterface $request
     * @return array
     * @throws \Exception
     */
    public function uriParsing(RequestInterface $request): array
    {
        $result = [];
        $split = $this->getSplitRealPath();

        $request->setRequestParams($split);

        $result['controller'] = ucfirst(array_shift($split)) . 'Controller';
        $result['action'] = array_shift($split);

        return $result;
    }

    /**
     * Checking the URI matches the routes
     * @return array ('uriPattern', 'path')
     * @throws \Exception
     */
    private function checkRequestUri(): array
    {
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~^$uriPattern$~", $this->getRequestUri())) {
                return [$uriPattern, $path];
            }
        }
        throw new \Exception('Invalid URL');
    }

    /**
     * Changing the URI according to the route
     * and we break this string into parts by "/"
     * @return array
     * @throws \Exception
     */
    public function getSplitRealPath(): array
    {
        [$uriPattern, $path] = $this->checkRequestUri();
        $realPath = preg_replace("~^$uriPattern$~", $path, $this->getRequestUri());
        return explode('/', $realPath);
    }

    /**
     * Get current URI
     * @return string
     */
    private function getRequestUri(): string
    {
        return trim($_SERVER['REQUEST_URI'], '/');
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