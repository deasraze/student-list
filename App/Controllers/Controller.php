<?php

namespace App\Controllers;

use App\Components\DIContainer;

abstract class Controller
{
    public FrontController $fc;

    public DIContainer $container;

    public function __construct(DIContainer $container)
    {
        $this->fc = FrontController::getInstance();
        $this->container = $container;
    }

    /**
     * Filling in the view and returning the result to the FrontController
     * @param string $template
     * @param array $args
     * @throws \Exception
     */
    public function show(string $template, array $args): void
    {
        $body = $this->container->get('view')->render($template, $args);
        $this->fc->setBody($body);
    }

}