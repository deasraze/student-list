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
        $stmt = $this->dbh->query($sql);
        return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Student::class);
    }

    public function getById(int $id): object
    {
        // TODO: Implement getById() method.
    }

    /**
     * Check if there is a user with such mail
     * @param string $email
     * @return bool
     */
    public function checkEmailExist(string $email): bool
    {
        $sql = 'SELECT COUNT(id) FROM students WHERE email = :email';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':email' => $email]);
        return (bool)$stmt->fetchColumn();
    }

    /**
     * @param Student $student
     */
    public function save(Student $student): void
    {
        (isset($student->id)) ? $this->update($student) : $this->insert($student);
    }

    /**
     * @param Student $student
     */
    private function insert(Student $student): void
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
        $stmt->execute([
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
     */
    private function update(Student $student): void
    {
        $sql = 'UPDATE  students 
                SET name = :name, surname = :surname, gender = :gender, 
                    sgroup = :sgroup, email = :email, score = :score, 
                    byear = :score, status = :status, token = :token
                WHERE id = :id';

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([
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
