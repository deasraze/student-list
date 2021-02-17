<?php

namespace App\Controllers;

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

    public function actionRegister()
    {
        $this->show('register', [
            'title' => 'Add yourself'
        ]);
    }

}