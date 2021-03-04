<?php

namespace App\Components\Exceptions;

class ContainerException extends ApplicationException
{
    /**
     * ContainerException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
