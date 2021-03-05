<?php

namespace App\Components;

use App\Components\Exceptions\ControllerNotExistException;
use App\Components\Exceptions\FileNotExistException;
use App\Components\Exceptions\MethodNotExistException;
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
     * @throws NotFoundException|FileNotExistException
     */
    public function __construct(RequestInterface $request)
    {
        $this->uri = trim($request->getRequestUri(), '/');
        $this->routes = $this->getRoutes();
        list('controller' => $this->controller, 'action' => $this->action) = $this->uriParsing($request);
    }

    /**
     * The initialization of the controller and call the desired action
     * @param DIContainer $container
     * @param Response $response
     * @return Response|bool
     * @throws ControllerNotExistException
     * @throws \ReflectionException
     */
    public function route(DIContainer $container, Response $response): Response
    {
        $action = $this->action;
        $rc = $this->getReflectionClass($this->controller);
        $rm = $this->getReflectionMethod($rc, $action);

        $instance = $rc->newInstance($container, $response);
        return $rm->invoke($instance, $action);
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
     * Getting the reflection class, if it exists
     * @param string $controllerName
     * @return \ReflectionClass
     * @throws ControllerNotExistException|\ReflectionException
     */
    private function getReflectionClass(string $controllerName): \ReflectionClass
    {
        if (class_exists($controllerName)) {
            return new \ReflectionClass($controllerName);
        }

        throw new ControllerNotExistException($controllerName);
    }

    /**
     * Getting the reflection method, if it exists
     * @param \ReflectionClass $rc
     * @param string $action
     * @return \ReflectionMethod
     * @throws MethodNotExistException
     */
    private function getReflectionMethod(\ReflectionClass $rc, string $action): \ReflectionMethod
    {
        if ($rc->hasMethod($action)) {
            return $rc->getMethod($action);
        }

        throw new MethodNotExistException($action);
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

        $result['controller'] = '\App\Controllers\\' . ucfirst(array_shift($split)) . 'Controller';
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
     * @throws FileNotExistException
     */
    private function getRoutes()
    {
        $file = ROOT . '/../App/config/routes.php';
        if (!is_file($file)) {
            throw new FileNotExistException($file);
        }

        return require_once ROOT . '/../App/config/routes.php';
    }
}
