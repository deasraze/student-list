<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Components\Utils;

class StringUtil
{
    /**
     * Generates a string of cryptographically random bytes of arbitrary length
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public static function getRandomString(int $length): string
    {
        return bin2hex(random_bytes($length));
    }

    /**
     * Returns a string that is safe for html
     * @param string $string
     * @return string
     */
    public static function html(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES);
    }
}
