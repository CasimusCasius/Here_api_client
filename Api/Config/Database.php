<?php

declare(strict_types=1);

class Database
{
    public PDO $conn;

    public function createConnection(): PDO
    {

        $this->conn = new PDO("sqlite:" . getcwd() . "/../../database/database.sqlite");
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $this->conn;
    }
}