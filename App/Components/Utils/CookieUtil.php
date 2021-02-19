<?php

namespace App\Components\Utils;

class CookieUtil
{
    /**
     * Create a cookie
     * @param string $key
     * @param $value
     * @param int $time
     * @return bool
     */
    public static function setCookie(string $key, $value, int $time): bool
    {
        return \setcookie($key, $value, [
            'expires' => time() + $time,
            'httponly' => true,
            'path' => '/'
        ]);
    }

    /**
     * Return the value of the cookie by the key, if there is such a cookie
     * @param string $key
     * @return bool|string
     */
    public static function getCookie(string $key)
    {
        return $_COOKIE[$key] ?? false;
    }

    /**
     * Destroying the cookie by key, if it exists
     * @param string $key
     * @return bool
     */
    public static function destroyCookie(string $key): bool
    {
        if (isset($_COOKIE[$key])) {
            return \setcookie($key, '', time() - 3600);
        }

        return false;
    }
}
