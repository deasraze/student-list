<?php

namespace App\Components\Helpers;

use App\Components\Utils\StringUtil;
use App\Models\Student;

class AuthorizationStudent
{
    /**
     * @var Student entity
     */
    private Student $student;

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
     * @param Student $student
     * @param CookieHelper $cookie
     * @throws \Exception
     */
    public function __construct(Student $student, CookieHelper $cookie)
    {
        $this->student = $student;
        $this->cookie = $cookie;
        $this->authToken = $this->generateToken(32);
    }

    /**
     * Remember a student in the user's cookies
     * @return bool
     * @throws \Exception
     */
    public function authorizeStudent(): bool
    {
        if (!isset($this->student->token)) {
            throw new \Exception('It is not possible to authorize the student, he does not have a token');
        }

        return $this->cookie->setCookie('auth_token', $this->student->token, (60*60*24*365*10));
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
     * Writing the token to the student
     * @return $this
     */
    public function setToken(): AuthorizationStudent
    {
        $this->student->token = $this->authToken;
        return $this;
    }

    /**
     * Return authorize token for student
     * @return bool|string
     */
    public function getAuthToken()
    {
        return ($this->cookie->getCookie('auth_token')) ?: $this->authToken;
    }

    /**
     * Generate string of cryptographically random bytes
     * @param int $length
     * @return string
     * @throws \Exception
     */
    private function generateToken(int $length): string
    {
        return StringUtil::getRandomString($length);
    }
}
