<?php

namespace App\Components\Helpers;

use App\Components\Utils\StringUtil;
use App\Models\Student;

class AuthorizationStudent
{
    /**
     * @var CookieHelper
     */
    private CookieHelper $cookie;

    /**
     * String of cryptographically random bytes
     * @var string
     */
    private string $authToken;

    /**
     * AuthorizationStudent constructor.
     * @param CookieHelper $cookie
     * @throws \Exception
     */
    public function __construct(CookieHelper $cookie)
    {
        $this->cookie = $cookie;
        $this->authToken = StringUtil::getRandomString(32);
    }

    /**
     * Remember a student in the user's cookies
     * @param Student $student
     * @return bool
     * @throws \Exception
     */
    public function authorizeStudent(Student $student): bool
    {
        if (!isset($student->token)) {
            throw new \Exception('It is not possible to authorize the student, he does not have a token');
        }

        return $this->cookie->setCookie('auth_token', $student->token, (60 * 60 * 24 * 365 * 10));
    }

    /**
     * Check whether the student is authorized or not
     * @return bool
     */
    public function isAuthorize(): bool
    {
        return $this->cookie->getCookie('auth_token') ? true : false;
    }

    /**
     * De-authorization of the student
     * @return bool
     */
    public function deauthorizeStudent(): bool
    {
        return $this->cookie->destroyCookie('auth_token');
    }

    /**
     * Return authorize token for student
     * @return bool|string
     */
    public function getAuthToken()
    {
        return ($this->cookie->getCookie('auth_token')) ?: $this->authToken;
    }
}
