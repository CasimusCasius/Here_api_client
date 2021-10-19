<?php

declare(strict_types=1);

namespace App\Model;

use PDO;
use Exception;
use PDOStatement;
use Throwable;

class Database
{
    protected ?PDO $conn = null;


    public function __construct()
    {

        try
        {
            $this->conn = new PDO("sqlite:" . DB_FILENAME, null, null, DB_ATTRIB);
        }
        catch (Throwable $e)
        {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    public function dbQuery(string $query, array $params = [])
    {
        try
        {
            $statement = $this->executeStatement($query, $params);

            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (Throwable $e)
        {
            throw $e;
        }
    }

    private function executeStatement(string $query, array $params = []): PDOStatement
    {
        try
        {
            $statement = $this->conn->prepare($query);

            if ($statement === false)
            {
                throw new Exception("Unable to prepare statement: " . $query);
            }
            if ($params)
            {
                foreach ($params as $key => &$param)
                {
                    $statement->bindParam(':' . $key, $param);
                }
            }

            $statement->execute();

            return $statement;
        }
        catch (Throwable $e)
        {
            throw new Exception($e->getMessage());
        }
    }
}