<?php
use App\App;

const ROOT = __DIR__;

require_once ROOT . '/../App/config/bootstrap.php';

$app = new App($container);
$app->run();
