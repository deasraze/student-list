<?php

namespace App\Components;

use PDO;

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
     */
    public function getConnection(): PDO
    {
        $json = $this->config;
        $dsn = "mysql:host={$json->db->host};dbname={$json->db->dbname};charset={$json->db->charset}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        return new PDO($dsn, $json->db->user, $json->db->password, $options);
    }
}