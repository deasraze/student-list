<?php

namespace App\Controllers;

use App\Components\DIContainer;
use App\Components\Exceptions\ContainerException;
use App\Components\Exceptions\ControllerNotExistException;
use App\Components\Exceptions\MethodNotExistException;

class FrontController
{
    private static FrontController $instance;

    private string $body;

    /**
     * @return FrontController
     */
    public static function getInstance(): FrontController
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * The initialization of the controller and call the desired action
     * @param DIContainer $container
     * @throws ContainerException
     * @throws \ReflectionException|ControllerNotExistException
     */
    public function route(DIContainer $container): void
    {
        $router = $container->get('router');

        $controller = $this->getCurrentNamespace($router->getController());
        $action = $router->getAction();

        $this->invoke($container, $controller, $action);
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
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
     * Checks whether the requested method exists
     * @param \ReflectionClass $rc
     * @param string $action
     * @return bool
     * @throws MethodNotExistException
     */
    private function checkActionExist(\ReflectionClass $rc, string $action): bool
    {
        if ($rc->hasMethod($action)) {
            return true;
        }

        throw new MethodNotExistException($action);
    }

    /**
     * Calling the required action
     * @param DIContainer $container
     * @param string $controllerName
     * @param string $action
     * @throws ControllerNotExistException|\ReflectionException
     */
    private function invoke(DIContainer $container, string $controllerName, string $action): void
    {
        $rc = $this->getReflectionClass($controllerName);
        if ($this->checkActionExist($rc, $action)) {
            $instance = $rc->newInstance($container);
            $rm = $rc->getMethod($action);
            $rm->invoke($instance, $action);
        }
    }

    /**
     * FrontController constructor.
     */
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * Getting current namespace
     * @param string|null $string
     * @return string
     */
    private function getCurrentNamespace(string $string = null): string
    {
        return (is_null($string)) ? __NAMESPACE__ . '\\' : __NAMESPACE__ . "\\$string";
    }

}
