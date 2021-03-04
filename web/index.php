<?php
use App\Controllers\FrontController;

const ROOT = __DIR__;

require_once ROOT . '/../App/config/bootstrap.php';

$fc = FrontController::getInstance();
$fc->route($container);

echo $fc->getBody();
