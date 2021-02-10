<?php

namespace App\Controllers;

use App\Components\RenderHelper;

class SiteController implements Controller
{
    private FrontController $fc;

    public function actionIndex()
    {
        $this->fc = FrontController::getInstance();
        $this->render('index');
    }

    public function render(string $fileName)
    {
        ob_start();
        (new RenderHelper())->getFile($fileName);
        $this->fc->setBody(ob_get_clean());
    }
}