<?php

namespace App\Components\Exceptions;

class AuthorizationStudentException extends ApplicationException
{
    /**
     * AuthorizationStudentException constructor.
     */
    public function __construct()
    {
        parent::__construct('It is not possible to authorize the student. '
        . 'The transferred student entity does not have a token.');
    }
}
