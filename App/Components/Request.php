<?php

namespace App\Components;

class Request
{
    private array $routes;
    private string $controller;
    private string $action;
    private array $queryString;
    private array $requestParams;


    public function __construct()
    {
        $this->routes = require ROOT . '/../App/config/routes.php';

        list('controller' => $controller, 'action' => $action) = $this->requestParsing();
        $this->controller = $controller;
        $this->action = $action;

        $this->queryString = $this->parsingQueryString();
        $this->requestParams = $this->parsingRequestParams();
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
     * @param string|null $key
     * @return array|string
     */
    public function getRequestParams(string $key = null)
    {
        return (is_null($key)) ? $this->requestParams : $this->requestParams[$key];
    }


    /**
     * @param string|null $key
     * @return array|string
     */
    public function getQueryString(string $key = null)
    {
        return (is_null($key)) ? $this->queryString : $this->queryString[$key];
    }

    /**
     * Checking the URI matches the routes
     * @return array
     * @throws \Exception
     */
    private function checkRequest(): array
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
     * Parse the URI and get the controller and action
     * @return array
     * @throws \Exception
     */
    private function requestParsing(): array
    {
        $result = [];
        $request = $this->checkRequest();

        $split = $this->getSplitRealPath($request['uriPattern'], $request['path']);
        $result['controller'] = ucfirst(array_shift($split)) . 'Controller';
        $result['action'] = array_shift($split);


        return $result;
    }

    /**
     * @return array
     */
    private function parsingQueryString(): array
    {
        if (!empty($_SERVER['QUERY_STRING'])) {
            return array_combine(array_keys($_GET), array_values($_GET));
        }

        return [];
    }

    /**
     * The parsing of the parameters specified in the routes
     * @return array
     * @throws \Exception
     */
    private function parsingRequestParams(): array
    {
        $request = $this->checkRequest();
        $split = $this->getSplitRealPath($request['uriPattern'], $request['path']);
        $params = array_splice($split, 2);
        if (!empty($params)) {
            $key = $value = [];
            foreach (array_chunk($params, 2) as $chunk) {
                $key[] = $chunk[0];
                $value[] = $chunk[1];
            }

            return array_combine($key, $value);
        }
        return [];
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