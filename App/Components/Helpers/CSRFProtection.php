<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Components\Helpers;

use App\Components\Exceptions\BadRequestException;
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
        return ($this->cookie->getCookie('csrf') === false)
            ? $this->cookie->setCookie('csrf', $this->csrfToken, 1800)
            : true;
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
     * @throws BadRequestException
     */
    public function validate(RequestInterface $request): bool
    {
        $cookieToken = $this->cookie->getCookie('csrf');
        $postToken = ($request->getRequestBody('csrf'));
        if (empty($cookieToken) || empty($postToken) || $cookieToken !== $postToken) {
            throw new BadRequestException('The registration/editing form cannot be processed. '
            . 'The tokens don\'t match');
        }

        return true;
    }
}
