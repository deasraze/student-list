<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Components\Exceptions;

class MethodNotExistException extends \BadMethodCallException
{
    /**
     * MethodNotExistException constructor.
     * @param string $methodName
     */
    public function __construct(string $methodName)
    {
        parent::__construct("The $methodName method is not implemented");
    }
}
