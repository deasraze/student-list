<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

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
