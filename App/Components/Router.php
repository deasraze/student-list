<?php

namespace App\Components;

class Router
{
    private array $routes;
    private string $controller;
    private string $action;


    public function __construct(Request $request)
    {
        $this->routes = require ROOT . '/../App/config/routes.php';

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
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    private function uriParsing(Request $request): array
    {
        $result = [];
        $requestUri = $this->checkRequestUri();
        $split = $this->getSplitRealPath($requestUri['uriPattern'], $requestUri['path']);

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
                return [
                    'uriPattern' => $uriPattern,
                    'path' => $path
                ];
            }
        }
        throw new \Exception('Invalid URL');
    }

    /**
     * Changing the URI according to the route, where uriPattern => $path
     * And we break this string into parts by "/"
     * @param string $uriPattern
     * @param string $path
     * @return array
     */
    private function getSplitRealPath(string $uriPattern, string $path): array
    {
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
}