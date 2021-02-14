<?php

namespace App\Models;

use App\Components\Interfaces\TableDataGateway;

class StudentTableGateway implements TableDataGateway
{

    private \PDO $dbh;

    public function __construct(\PDO $dbh)
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
        return $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE,Student::class);

    }

    public function getById(int $id): object
    {
        // TODO: Implement getById() method.
    }

    public function add(object $object)
    {
        // TODO: Implement add() method.
    }
}