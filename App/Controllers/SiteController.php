<?php

namespace App\Controllers;

use App\Components\Interfaces\TableDataGateway;

class SiteController extends Controller
{
    protected string $title;

    private TableDataGateway $studentGateway;

    public function __construct(TableDataGateway $studentGateway)
    {
        parent::__construct();
        $this->studentGateway = $studentGateway;
    }

    public function actionIndex()
    {
        $this->title = 'Student list';
        $this->render('index');
    }

}