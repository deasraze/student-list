<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

use App\Components\DIContainer;
use App\Components\Exceptions\DbException;
use App\Components\Exceptions\FileNotExistException;
use App\Components\Helpers\AuthorizationStudent;
use App\Components\Helpers\CookieHelper;
use App\Components\Helpers\CSRFProtection;
use App\Components\Helpers\LinkHelper;
use App\Components\Helpers\SortingHelper;
use App\Components\Navbar;
use App\Components\Request;
use App\Components\Router;
use App\Components\View;
use App\Models\StudentTableGateway;
use App\Models\StudentValidator;

require ROOT . '/../vendor/autoload.php';

$container = new DIContainer();

$container->register('config_db', function (DIContainer $container) {
    $file = ROOT . '/../App/config/db_params.json';
    if (!is_file($file)) {
        throw new FileNotExistException($file);
    }

    return json_decode(file_get_contents($file), true, JSON_THROW_ON_ERROR);
});

$container->register('dbh', function (DIContainer $container) {
    $config = $container->get('config_db');
    if (!array_key_exists('db', $config)) {
        throw new DbException('Invalid configuration of the db_params.json file.');
    }

    $config = $config['db'];
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    return new PDO($dsn, $config['user'], $config['password'], $options);
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
