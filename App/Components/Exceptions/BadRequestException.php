<?php

namespace App\Components\Exceptions;

class BadRequestException extends ApplicationException
{
    /**
     * BadRequestException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct(
            $message,
            400,
            'It looks like your request has invalid syntax. '
        . 'Please try again or contact your server administrator for more information.'
        );
    }
}
