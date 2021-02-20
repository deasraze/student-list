<?php

namespace App\Components\Helpers;

class CookieHelper
{
    /**
     * Create a cookie
     * @param string $key
     * @param $value
     * @param int $time
     * @return bool
     */
    public function setCookie(string $key, $value, int $time): bool
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
    public function getCookie(string $key)
    {
        return $_COOKIE[$key] ?? false;
    }

    /**
     * Destroying the cookie by key, if it exists
     * @param string $key
     * @return bool
     */
    public function destroyCookie(string $key): bool
    {
        if (isset($_COOKIE[$key])) {
            return \setcookie($key, '', time() - 3600);
        }

        return false;
    }
}
