<?php

namespace App\Components\Helpers;

use App\Components\Interfaces\RequestInterface;
use App\Components\Utils\CookieUtil;
use App\Components\Utils\StringUtil;

class CSRFProtection
{
    /**
     * String of cryptographically random bytes
     * @var string
     */
    private string $csrfToken;

    /**
     * CSRFProtection constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->csrfToken = StringUtil::getRandomString(32);
    }

    /**
     * Write a unique token in the cookie and return it
     * @return string
     */
    public function setToken(): string
    {
        if (CookieUtil::getCookie('csrf') === false) {
            CookieUtil::setCookie('csrf', $this->csrfToken, 1800);
            return $this->csrfToken;
        }

        return CookieUtil::getCookie('csrf');
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->csrfToken;
    }

    /**
     * Check whether the token in the user's cookies and the token from the request are identical
     * @param RequestInterface $request
     * @return bool
     * @throws \Exception
     */
    public function validate(RequestInterface $request): bool
    {
        if (CookieUtil::getCookie('csrf') !== $request->getRequestBody('csrf')) {
            throw new \Exception('Invalid token');
        }

        return true;
    }
}
