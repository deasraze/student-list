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
     * Getting all students from the db
     * @param string $order
     * @param string $direction
     * @param int $limit
     * @param int $offset
     * @return Student[]
     */
    public function getAll(string $order, string $direction, int $limit, int $offset): array
    {
        $sql = "SELECT id, name, surname, sgroup, score 
                FROM students 
                ORDER BY $order $direction 
                LIMIT :offset, :limit";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Student::class);
    }

    /**
     * Getting total students
     * @param string $searchQuery
     * @return int count students
     */
    public function getTotalStudents(string $searchQuery = ''): int
    {
        $sql = "SELECT COUNT(id) FROM students WHERE CONCAT(name, ' ', surname, ' ', sgroup) LIKE :search";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(['search' => "%$searchQuery%"]);

        return (int)$stmt->fetchColumn();
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
     * Search for records by the passed search query
     * @param string $searchQuery
     * @param string $order
     * @param string $direction
     * @return array
     */
    public function search(string $searchQuery, string $order, string $direction): array
    {
        $sql = "SELECT id, name, surname, sgroup, score 
                FROM students
                WHERE CONCAT(name, ' ', surname, ' ', sgroup) LIKE :search
                ORDER BY $order $direction";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':search' => "%$searchQuery%"]);

        return $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Student::class);
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
