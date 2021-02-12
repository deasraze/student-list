<?php

namespace App\Controllers;

class SiteController extends Controller
{
    protected string $title;


    public function actionIndex()
    {
        $this->title = 'Student list';
        $this->render('index');
    }

}