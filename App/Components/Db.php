<?php

namespace App\Components;

use PDO;

class Db
{


    public function __construct()
    {
        $json = $this->getJsonParams();
        $dsn = "mysql:host={$json->db->host};dbname={$json->db->dbname};charset={$json->db->charset}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,
        ];

        return new PDO($dsn, $json->db->user, $json->db->password, $options);
    }

    private function getJsonParams()
    {
        return json_decode(file_get_contents(ROOT . '/../App/config/db_params.json'));
    }
}