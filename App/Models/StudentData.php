<?php
/*
 * Student List application
 * @author theifel
 * @link https://github.com/theifel/student-list/
 * @copyright Copyright (c) 2021
 * @license https://github.com/theifel/student-list/blob/main/LICENSE.md
 */

namespace App\Models;

class StudentData
{
    /**
     * @var Student
     */
    public Student $student;

    /**
     * StudentData constructor.
     * @param Student $student
     */
    public function __construct(Student $student)
    {
        $this->student = $student;

    }

    /** Filling in the entity with the data that was passed
     * @param array $data
     */
    public function fill(array $data)
    {
        $allowedProps = [
            'name', 'surname', 'byear', 'gender',
            'score', 'sgroup', 'status', 'email'
        ];

        foreach ($allowedProps as $prop) {
            $dataValue = trim($data[$prop] ?? '');
            (property_exists($this->student, $prop))
                ? $this->student->{$prop} = $dataValue
                : $this->{$prop} = $dataValue;
        }
    }
}
