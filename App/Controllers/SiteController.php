<?php

namespace App\Controllers;

use App\Components\RenderHelper;

class SiteController implements Controller
{
    private FrontController $fc;
    private string $title;

    public function __construct()
    {
        $this->fc = FrontController::getInstance();
    }

    public function actionIndex()
    {
        $this->title = 'Student list';
        $this->render('index');
    }

    public function render(string $fileName)
    {
        $file = (new RenderHelper())->getFile($fileName);
        ob_start();
        require_once "$file";
        $this->fc->setBody(ob_get_clean());
    }
}