<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Models;

class Student
{
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    const STATUS_RESIDENT = 'resident';
    const STATUS_NONRESIDENT = 'nonresident';

    public int $id;

    public string $name;

    public string $surname;

    public string $gender;

    public string $sgroup;

    public string $email;

    public int $score;

    public int $byear;

    public string $status;

    public string $token;
}
