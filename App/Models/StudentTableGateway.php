<?php

namespace App\Models;

use PDO;

class StudentTableGateway
{
    private PDO $dbh;

    public function __construct(PDO $dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * Return all students in the students table
     * @return Student[]
     */
    public function getAll(): array
    {
        $sql = 'SELECT id, name, surname, sgroup, score FROM students';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Student::class);
    }

    /**
     * Getting student data by their token
     * @param string $token
     * @return Student
     */
    public function getByToken(string $token): Student
    {
        $sql = 'SELECT id, name, surname, gender, sgroup, email, score, byear, status 
                FROM students
                WHERE token = :token';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':token' => $token]);
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Student::class);

        return $stmt->fetch();
    }

    /**
     * Check if there is a user with such mail
     * @param string $email
     * @param string $token
     * @return bool
     */
    public function checkEmailExist(string $email, string $token): bool
    {
        $sql = 'SELECT COUNT(id) FROM students WHERE email = :email AND token != :token';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':token' => $token
        ]);

        return (bool)$stmt->fetchColumn();
    }

    /**
     * @param Student $student
     * @return bool
     */
    public function save(Student $student): bool
    {
        return (isset($student->id)) ? $this->update($student) : $this->insert($student);
    }

    /**
     * @param Student $student
     * @return bool
     */
    private function insert(Student $student): bool
    {
        $sql = 'INSERT INTO students 
                    (name, surname, gender, 
                     sgroup, email, score, 
                     byear, status, token) 
                VALUES 
                    (:name, :surname, :gender, 
                     :sgroup, :email, :score, 
                     :byear, :status, :token)';

        $stmt = $this->dbh->prepare($sql);
        return $stmt->execute([
            ':name' => $student->name,
            ':surname' => $student->surname,
            ':gender' => $student->gender,
            ':sgroup' => $student->sgroup,
            ':email' => $student->email,
            ':score' => $student->score,
            ':byear' => $student->byear,
            ':status' => $student->status,
            ':token' => $student->token
        ]);
    }

    /**
     * @param Student $student
     * @return bool
     */
    private function update(Student $student): bool
    {
        $sql = 'UPDATE  students 
                SET name = :name, surname = :surname, gender = :gender, 
                    sgroup = :sgroup, email = :email, score = :score, 
                    byear = :byear, status = :status, token = :token
                WHERE id = :id';

        $stmt = $this->dbh->prepare($sql);
        return $stmt->execute([
            ':id' => $student->id,
            ':name' => $student->name,
            ':surname' => $student->surname,
            ':gender' => $student->gender,
            ':sgroup' => $student->sgroup,
            ':email' => $student->email,
            ':score' => $student->score,
            ':byear' => $student->byear,
            ':status' => $student->status,
            ':token' => $student->token
        ]);
    }
}
