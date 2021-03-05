<?php

namespace App\Components\Exceptions;

class FileNotExistException extends ApplicationException
{
    /**
     * FileNotExistException constructor.
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        parent::__construct("File $fileName no exist. "
            . "Check whether the file name is correct or create it");
    }
}
