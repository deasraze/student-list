<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

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
