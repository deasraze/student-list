<?php

namespace App\Components;

use PDO;
use App\Components\Exceptions\DbException;

class Db
{
    /**
     * Object json_decode that contains the database connection settings
     */
    private object $config;

    /**
     * Db constructor.
     * @param object the result of the function json_decode
     */
    public function __construct(object $json)
    {
        $this->config = $json;
    }

    /**
     * @return PDO
     * @throws DbException
     */
    public function getConnection(): PDO
    {
        if (!property_exists($this->config, 'db')) {
            throw new DbException();
        }

        $json = $this->config;
        $dsn = "mysql:host={$json->db->host};dbname={$json->db->dbname};charset={$json->db->charset}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        return new PDO($dsn, $json->db->user, $json->db->password, $options);
    }
}
