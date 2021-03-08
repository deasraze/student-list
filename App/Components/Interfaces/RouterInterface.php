<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Components\Interfaces;

interface RouterInterface
{
    public function getSplitRealPath(): array;

    public function getController(): string;

    public function getAction(): string;
}
