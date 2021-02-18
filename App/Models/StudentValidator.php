<?php

namespace App\Models;

class StudentValidator
{
    private StudentTableGateway $studentGateway;

    /**
     * StudentValidator constructor.
     * @param StudentTableGateway $studentGateway
     */
    public function __construct(StudentTableGateway $studentGateway)
    {
        $this->studentGateway = $studentGateway;
    }

    /**
     * @param Student $student
     * @return array
     */
    public function validate(Student $student): array
    {
        $errors = [];
        $errors['name'] = $this->validateName($student->name);
        $errors['surname'] = $this->validateName($student->surname);
        $errors['gender'] = $this->validateGender($student->gender);
        $errors['sgroup'] = $this->validateSgroup($student->sgroup);
        $errors['email'] = $this->validateEmail($student->email);
        $errors['score'] = $this->validateScore($student->score);
        $errors['byear'] = $this->validateByear($student->byear);
        $errors['status'] = $this->validateStatus($student->status);

        return array_filter($errors, [$this, 'errorsFilter']);
    }

    /**
     * @param string $name
     * @return bool
     */
    private function validateName(string $name): bool
    {
        return (bool) preg_match("/^[а-яёА-ЯЁa-zA-Z '-]{1,40}$/u", $name);
    }

    /**
     * @param string $gender
     * @return bool
     */
    private function validateGender(string $gender): bool
    {
        if ($gender !== Student::GENDER_MALE && $gender !== Student::GENDER_FEMALE) {
            return false;
        }

        return true;
    }

    /**
     * @param string $sgroup
     * @return bool
     */
    private function validateSgroup(string $sgroup): bool
    {
        return (bool) preg_match('/^[0-9А-ЯЁA-Z]{2,5}$/u', $sgroup);
    }

    /**
     * @param string $email
     * @return bool
     */
    private function validateEmail(string $email): bool
    {
        return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param int $score
     * @return bool
     */
    private function validateScore(int $score): bool
    {
       return $score <= 1110;
    }

    /**
     * @param int $byear
     * @return bool
     */
    private function validateByear(int $byear): bool
    {
        if ($byear < 1900 || $byear > 2004) {
            return false;
        }

        return true;
    }

    /**
     * @param string $status
     * @return bool
     */
    private function validateStatus(string $status): bool
    {
        if ($status !== Student::STATUS_RESIDENT && $status !== Student::STATUS_NONRESIDENT) {
            return false;
        }

        return true;
    }

    private function errorsFilter(bool $error)
    {
        return $error !== true;
    }
}