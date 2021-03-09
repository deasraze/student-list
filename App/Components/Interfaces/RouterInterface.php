<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Components\Interfaces;

use App\Components\DIContainer;
use App\Components\Request;
use App\Components\Response;

interface RouterInterface
{
    public function route(DIContainer $container, Request $request, Response $response): Response;

    public function getController(): string;

    public function getAction(): string;

    public function getRoutes(): array;
}
