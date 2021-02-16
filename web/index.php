<?php

use App\Components\Db;
use App\Components\DIContainer;
use App\Components\Request;
use App\Components\Router;
use App\Components\View;
use App\Controllers\FrontController;
use App\Models\StudentTableGateway;

const ROOT = __DIR__;

require ROOT . '/../vendor/autoload.php';

$container = new DIContainer();

$container->register('config_db', function (DIContainer $container) {
    return json_decode(file_get_contents(ROOT . '/../App/config/db_params.json'));
});

$container->register('dbh', function (DIContainer $container) {
    $db = new Db($container->get('config_db'));
    return $db->getConnection();
});

$container->register('request', function (DIContainer $container) {
    return new Request();
});

$container->register('router', function (DIContainer $container) {
    return new Router($container->get('request'));
});

$container->register('StudentTableGateway', function (DIContainer $container) {
    return new StudentTableGateway($container->get('dbh'));
});

$container->register('view', function (DIContainer $container) {
    return new View();
});

$fc = FrontController::getInstance();
$fc->route($container);

echo $fc->getBody();