<?php

namespace App\Controllers;

use App\Components\Interfaces\TableDataGateway;

class SiteController extends Controller
{
    private TableDataGateway $studentGateway;

    public function __construct(TableDataGateway $studentGateway)
    {
        parent::__construct();
        $this->studentGateway = $studentGateway;
    }

    public function actionIndex()
    {
        $students = $this->studentGateway->getAll();
        $this->render('index', [
            'title' => 'Student list',
            'students' => $students
        ]);
    }

}