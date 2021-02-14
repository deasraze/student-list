<?php

namespace App\Components\Interfaces;

interface TableDataGateway
{
    /**
     * TableDataGateway constructor.
     * @param \PDO $dbh
     */
    public function __construct(\PDO $dbh);

    /**
     * Return all rows from the table
     * @return array
     */
    public function getAll(): array;

    /**
     * Returning rows with id = $id
     * @param int $id
     * @return object|null
     */
    public function getById(int $id): object;

    /**
     * Insert new row in the table
     * @param object $object
     * @return mixed
     */
    public function add(object $object);
}