<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Components\Exceptions;

class ControllerNotExistException extends \Exception
{
    /**
     * ControllerNotExistException constructor.
     * @param string $controllerName
     */
    public function __construct(string $controllerName)
    {
        parent::__construct("The controller $controllerName does not exist. "
            . "Check the correctness of the routes or describe this class.");
    }
}
