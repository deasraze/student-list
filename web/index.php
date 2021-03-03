<?php

use App\Components\Db;
use App\Components\DIContainer;
use App\Components\Helpers\AuthorizationStudent;
use App\Components\Helpers\CookieHelper;
use App\Components\Helpers\CSRFProtection;
use App\Components\Helpers\LinkHelper;
use App\Components\Helpers\SortingHelper;
use App\Components\Navbar;
use App\Components\Request;
use App\Components\Router;
use App\Components\View;
use App\Controllers\FrontController;
use App\Models\StudentTableGateway;
use App\Models\StudentValidator;

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
    return new StudentTableGateway($container->get('dbh'), 10);
});

$container->register('view', function (DIContainer $container) {
    return new View(ROOT . '/../App/Views/', 'php');
});

$container->register('StudentValidator', function (DIContainer $container) {
    return new StudentValidator($container->get('StudentTableGateway'));
});

$container->register('cookieHelper', function (DIContainer $container) {
    return new CookieHelper();
});

$container->register('csrf', function (DIContainer $container) {
    return new CSRFProtection($container->get('cookieHelper'));
});

$container->register('AuthorizationStudent', function (DIContainer $container) {
    return new AuthorizationStudent($container->get('cookieHelper'));
});

$container->register('LinkHelper', function (DIContainer $container) {
    return new LinkHelper($container->get('request'));
});

$container->register('navbar', function (DIContainer $container) {
    return new Navbar($container->get('request'));
});

$container->register('sorting', function (DIContainer $container) {
    return new SortingHelper(
        $container->get('request'),
        $container->get('LinkHelper'),
        'score',
        'desc'
    );
});

$fc = FrontController::getInstance();
$fc->route($container);

echo $fc->getBody();
