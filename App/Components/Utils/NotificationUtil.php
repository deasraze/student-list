<?php

namespace App\Components\Utils;

class NotificationUtil
{
    /**
     * Getting notification html
     * @param string $alertType
     * @param string $alertHeading
     * @param string $alertDesc
     * @return string html
     */
    public static function getNotification(string $alertType, string $alertHeading, string $alertDesc): string
    {
        return sprintf(
            '<div class="alert alert-%s alert-dismissible fade show" role="alert">
            <h4 class="alert-heading">%s</h4>%s
            <button type="button" id="notification-close" class="btn-close" 
            data-bs-dismiss="alert" aria-label="Close"></button></div>',
            StringUtil::html($alertType),
            StringUtil::html($alertHeading),
            StringUtil::html($alertDesc)
        );
    }
}
