<?php

namespace App\Controllers;

use App\Components\View;

abstract class Controller
{
    protected FrontController $fc;

    public function __construct()
    {
        $this->fc = FrontController::getInstance();
    }

    /**
     * Filling in the view and returning the result to the FrontController
     * @param string $template
     * @param array $args
     * @throws \Exception
     */
    public function render(string $template, array $args): void
    {
        $body = (new View())->render($template, $args);
        $this->fc->setBody($body);
    }

}