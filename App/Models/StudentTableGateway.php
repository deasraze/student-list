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
}
