<?php

namespace App\Components\Helpers;

use App\Components\Interfaces\RequestInterface;
use App\Components\Utils\StringUtil;

class CSRFProtection
{
    /**
     * @var CookieHelper
     */
    private CookieHelper $cookie;

    /**
     * String of cryptographically random bytes
     * @var string
     */
    private string $csrfToken;

    /**
     * CSRFProtection constructor.
     * @param CookieHelper $cookie
     * @throws \Exception
     */
    public function __construct(CookieHelper $cookie)
    {
        $this->cookie = $cookie;
        $this->csrfToken = StringUtil::getRandomString(32);
    }

    /**
     * Write a unique token in the cookie
     * @return bool
     */
    public function setCsrfToken(): bool
    {
        if ($this->cookie->getCookie('csrf') === false) {
            return $this->cookie->setCookie('csrf', $this->csrfToken, 1800);
        }

        return false;
    }

    /**
     * Return csrf token
     * @return string
     */
    public function getCsrfToken(): string
    {
        return ($this->cookie->getCookie('csrf')) ?: $this->csrfToken;
    }

    /**
     * Check whether the token in the user's cookies and the token from the request are identical
     * @param RequestInterface $request
     * @return bool
     * @throws \Exception
     */
    public function validate(RequestInterface $request): bool
    {
        $cookieToken = $this->cookie->getCookie('csrf');
        $postToken = ($request->getRequestBody('csrf'));
        if (empty($cookieToken) || empty($postToken) || $cookieToken !== $postToken) {
            throw new \Exception('Invalid token');
        }

        return true;
    }
}
