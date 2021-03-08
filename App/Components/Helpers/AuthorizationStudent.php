<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Components\Helpers;

use App\Components\Exceptions\AuthorizationStudentException;
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
     * @throws AuthorizationStudentException
     */
    public function authorizeStudent(Student $student): bool
    {
        if (!isset($student->token)) {
            throw new AuthorizationStudentException();
        }

        return ($this->isAuthorize()) ?: $this->cookie->setCookie(
            'auth_token',
            $student->token,
            (60 * 60 * 24 * 365 * 10)
        );
    }

    /**
     * Check whether the student is authorized or not
     * @return bool
     */
    public function isAuthorize(): bool
    {
        return $this->cookie->getCookie('auth_token') !== false;
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
     * @return string
     */
    public function getAuthToken(): string
    {
        return ($this->cookie->getCookie('auth_token')) ?: $this->authToken;
    }
}
