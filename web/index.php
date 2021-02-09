<?php

use App\Controllers\FrontController;

const ROOT = __DIR__;

require ROOT . '/../vendor/autoload.php';

$fc = FrontController::getInstance();
$fc->route();