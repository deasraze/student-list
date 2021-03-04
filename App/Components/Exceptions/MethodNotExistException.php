<?php

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
