<?php

namespace App\Controllers;

use App\Components\DIContainer;

class SiteController extends Controller
{

    public function actionIndex()
    {
        $students = $this->container->get('StudentTableGateway')->getAll();
        $this->show('index', [
            'title' => 'Student list',
            'students' => $students
        ]);
    }

}