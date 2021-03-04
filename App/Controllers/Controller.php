<?php

namespace App\Controllers;

use App\Components\DIContainer;
use App\Components\Exceptions\ContainerException;
use App\Components\Exceptions\FileNotExistException;

abstract class Controller
{
    /**
     * @var FrontController
     */
    public FrontController $fc;

    /**
     * @var DIContainer
     */
    public DIContainer $container;

    /**
     * Controller constructor.
     * @param DIContainer $container
     */
    public function __construct(DIContainer $container)
    {
        $this->fc = FrontController::getInstance();
        $this->container = $container;
    }

    /**
     * Filling in the view and returning the result to the FrontController
     * @param string $template
     * @param array $args
     * @throws ContainerException
     * @throws FileNotExistException in render()
     */
    public function show(string $template, array $args): void
    {
        $body = $this->container->get('view')->render($template, $args);
        $this->fc->setBody($body);
    }

}
