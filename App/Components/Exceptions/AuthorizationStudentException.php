<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

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
