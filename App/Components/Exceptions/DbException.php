<?php

namespace App\Components\Exceptions;

class DbException extends ApplicationException
{
    /**
     * DbException constructor.
     */
    public function __construct()
    {
        parent::__construct('Invalid configuration of the db_params.json file.');
    }
}
