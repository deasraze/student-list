<?php

namespace App\Components\Utils;

class CookieUtil
{
    /**
     * Create a cookie, if there is no cookie, and return it
     * @param string $key
     * @param $value
     * @param int $time
     * @return mixed
     */
    public static function setCookie(string $key, $value, int $time)
    {
        if (!isset($_COOKIE[$key])) {
            \setcookie($key, $value, [
                'expires' => time() + $time,
                'httponly' => true,
                'path' => '/'
            ]);
        }

        return $_COOKIE[$key];
    }

    /**
     * Return the value of the cookie by the key, if there is such a cookie
     * @param string $key
     * @return string
     */
    public static function getCookie(string $key): string
    {
        return $_COOKIE[$key] ?? '';
    }

    /**
     * Destroying the cookie by key, if it exists
     * @param string $key
     * @return bool
     */
    public static function destroyCookie(string $key): bool
    {
        if (isset($_COOKIE[$key])) {
            \setcookie($key, '', time() - 3600);
            return true;
        }

        return false;
    }
}
