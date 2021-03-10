<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Components;

use App\Components\Exceptions\ControllerNotExistException;
use App\Components\Exceptions\MethodNotExistException;
use App\Components\Exceptions\NotFoundException;
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
     * The path according to the route
     * @var array
     */
    private array $splitRealPath;

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
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    /**
     * Defining the required parameters and calling invoke
     * @param DIContainer $container
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws ControllerNotExistException
     * @throws NotFoundException
     * @throws \ReflectionException
     */
    public function route(DIContainer $container, Request $request, Response $response): Response
    {
        $this->uri = trim($request->getUri(), '/');
        $this->splitRealPath = $this->getSplitRealPath();
        ['controller' => $this->controller, 'action' => $this->action] = $this->uriParsing();

        return $this->invoke($container, $request, $response);
    }

    /**
     * Get routes
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
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
     * The initialization of the controller and call the desired action
     * @param DIContainer $container
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws ControllerNotExistException
     * @throws \ReflectionException
     */
    private function invoke(DIContainer $container, Request $request, Response $response): Response
    {
        $rc = $this->getReflectionClass($this->controller);
        $rm = $this->getReflectionMethod($rc, $this->action);
        $instance = $rc->newInstance($container, $response);

        return $rm->invoke($instance, $request, $this->parsingAttributes());
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
     * Parse the URI and get the controller and action
     * @return array
     */
    private function uriParsing(): array
    {
        $split = $this->splitRealPath;
        $result['controller'] = '\App\Controllers\\' . ucfirst(array_shift($split)) . 'Controller';
        $result['action'] = array_shift($split);

        return $result;
    }

    /**
     * Changing the URI according to the route
     * and we break this string into parts by "/"
     * @return array
     * @throws NotFoundException
     */
    private function getSplitRealPath(): array
    {
        [$uriPattern, $path] = $this->getCurrentRoute();
        $realPath = preg_replace("~^$uriPattern$~", $path, $this->uri);

        return explode('/', $realPath);
    }

    /**
     * The parsing of the parameters specified in the routes
     * @return array
     */
    private function parsingAttributes(): array
    {
        $split = $this->splitRealPath;
        $attributes = array_splice($split, 2);
        if (count($attributes) !== 0) {
            $key = $value = [];
            foreach (array_chunk($attributes, 2) as $chunk) {
                $key[] = $chunk[0];
                $value[] = $chunk[1];
            }

            return array_combine($key, $value);
        }

        return [];
    }

    /**
     * Getting the required route from the requested uri,
     * if there is a match in the routes
     * @return array ('uriPattern', 'path')
     * @throws NotFoundException
     */
    private function getCurrentRoute(): array
    {
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~^$uriPattern$~", $this->uri)) {
                return [$uriPattern, $path];
            }
        }

        throw new NotFoundException("This {$this->uri} does not exist in routes");
    }
}
