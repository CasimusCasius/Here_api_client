<?php

declare(strict_types=1);

namespace App\Model;

use PDO;
use Exception;
use Throwable;

require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class Location extends Database
{
    // private PDO $conn;
    private string $tableName = 'base_location';

    // public int $id;
    // public ?string $street;
    // public ?string $buildingNo;
    // public ?string $postCode;
    // public ?string $city;
    // public ?string $country;
    // public ?string $created;


    public function read(array $options = ["limit" => 10])
    {
        $query = "SELECT id, street, building_no, postal_code, city, country, created 
                FROM " . $this->tableName;

        if (!empty($options['id']))
        {
            $query = $query . " WHERE id=:id";
            $options['limit'] = 1;
        }

        $query = $query . " LIMIT :limit";


        return $this->dbQuery($query, $options);
    }

    public function create(array $values)
    {
        $query = "INSERT INTO " . $this->tableName .
            " (street, building_no , postal_code, city, country, created) 
        VALUES (:street, :building_no , :postal_code, :city, :country, datetime('now'))";

        foreach ($values as $key => &$value)
        {
            $values[$key] = htmlentities(strip_tags($value ?? ''));
        }

        return $this->dbQuery($query, $values);
    }

    public function delete(array $values)
    {
        $query =
            "DELETE FROM " . $this->tableName . " WHERE id = :id";

        foreach ($values as $key => $value)
        {
            $values[$key] = (int) $value ?? null;
        }

        return $this->dbQuery($query, $values);
    }


    public function update(array $values)
    {
        $query = "UPDATE " . $this->tableName . " SET  street=:street, building_no=:building_no, postal_code=:postal_code,
             city=:city, country=:country WHERE id=:id ";

        foreach ($values as $key => &$value)
        {
            $values[$key] = htmlentities(strip_tags($value ?? ''));
        }
        return $this->dbQuery($query, $values);
    }
}