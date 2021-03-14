<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Components\Utils;

class NotificationUtil
{
    /**
     * Getting notification
     * @param string $alertType
     * @param string $alertHeading
     * @param string $alertDesc
     * @return string html
     */
    public static function getNotification(string $alertType, string $alertHeading, string $alertDesc): string
    {
        $notify = file_get_contents(ROOT . '/../App/Views/static/notify.php');
        $search = ['{alert-type}', '{alert-heading}', '{alert-description}'];
        $replace = [$alertType, $alertHeading, $alertDesc];

        return str_replace($search, $replace, $notify);
    }
}
