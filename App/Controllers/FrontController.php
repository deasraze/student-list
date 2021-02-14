<?php

namespace App\Controllers;

use App\Components\Interfaces\TableDataGateway;
use App\Components\Interfaces\RequestInterface;
use App\Components\Interfaces\RouterInterface;
use App\Components\Helpers\ReflectionClassHelper;

class FrontController
{
    public RequestInterface $request;

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
     * @param RouterInterface $router
     * @param RequestInterface $request
     * @param TableDataGateway $dataGateway
     * @throws \ReflectionException
     */
    public function route(
        RouterInterface $router,
        RequestInterface $request,
        TableDataGateway $dataGateway
    ): void {
        $this->request = $request;
        $controller = $this->getCurrentNamespace($router->getController());
        $action = $router->getAction();
        ReflectionClassHelper::setReflectionClass($controller)->invoke($dataGateway, $action);
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

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @param string|null $string
     * @return string
     */
    private function getCurrentNamespace(string $string = null): string
    {
        return (is_null($string)) ? __NAMESPACE__ . '\\' : __NAMESPACE__ . "\\$string";
    }

}