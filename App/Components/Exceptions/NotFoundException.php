<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Components\Exceptions;

class NotFoundException extends ApplicationException
{
    /**
     * NotFoundException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct(
            $message,
            404,
            'The page you requested was not found. '
            . 'Please check the URL or contact the server administrator.'
        );
    }
}
