<?php

namespace App\Components\Exceptions;

class ControllerNotExistException extends ApplicationException
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
