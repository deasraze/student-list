<?php

use App\Components\Db;
use App\Components\Request;
use App\Components\Router;
use App\Controllers\FrontController;
use App\Models\StudentTableGateway;

const ROOT = __DIR__;

require ROOT . '/../vendor/autoload.php';

$request = new Request();
$router = new Router($request);
$studentGateway = new StudentTableGateway((new Db())->getConnection());

$fc = FrontController::getInstance();
$fc->route($router, $request, $studentGateway);

echo $fc->getBody();