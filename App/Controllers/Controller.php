<?php

namespace App\Controllers;

use App\Components\Render;
use App\Components\RenderHelper;

class Controller implements Render
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