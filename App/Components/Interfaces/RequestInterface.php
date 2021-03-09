<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Components\Interfaces;

interface RequestInterface
{
    public function getRequestBody(string $key = null, $default = null);

    public function getUri(): string;

    public function getUrlPath(): string;
}
