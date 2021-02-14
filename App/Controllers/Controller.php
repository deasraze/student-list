<?php

namespace App\Controllers;

use App\Components\Helpers\RenderHelper;
use App\Components\Interfaces\RendererInterface;

class Controller implements RendererInterface
{
    protected FrontController $fc;

    public function __construct()
    {
        $this->fc = FrontController::getInstance();
    }

    /**
     * Filling in the view and returning the result to the FrontController
     * @param string $template
     * @throws \Exception
     */
    public function render(string $template)
    {
        $file = (new RenderHelper())->getFile($template);
        ob_start();
        require_once "$file";
        $this->fc->setBody(ob_get_clean());
    }

}