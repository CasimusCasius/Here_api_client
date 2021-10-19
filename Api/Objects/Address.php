<?php

declare(strict_types=1);

class Address
{
    private PDO $conn;
    private string $tableName = 'base_location';

    public int $id;
    public ?string $street;
    public ?string $buildingNo;
    public ?string $postCode;
    public ?string $city;
    public ?string $country;
    public ?string $created;

    public function __construct(PDO $db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT id, street, building_no, postal_code, city, country, created FROM " . $this->tableName;

        $result = $this->conn->prepare($query);
        $result->execute();

        return $result;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->tableName .
            " (street, building_no , postal_code, city, country, created) 
        VALUES (:street, :building_no , :postal_code, :city, :country, :created)";
        var_dump($query);
        try
        {
            $result = $this->conn->prepare($query);
        }
        catch (Throwable $e)
        {
            var_dump($e);
            throw new Exception("Error Processing Request", 1);
        }
        $this->street = htmlentities(strip_tags($this->street ?? ''));
        $this->buildingNo = htmlentities(strip_tags($this->buildingNo ?? ''));
        $this->postCode = htmlentities(strip_tags($this->postCode ?? ''));
        $this->city = htmlentities(strip_tags($this->city ?? ''));
        $this->country = htmlentities(strip_tags($this->country ?? ''));

        $result->bindParam(":street", $this->street);
        $result->bindParam(":building_no", $this->buildingNo);
        $result->bindParam(":postal_code", $this->postCode);
        $result->bindParam(":city", $this->city);
        $result->bindParam(":country", $this->country);
        $result->bindParam(":created", $this->created);

        return $result->execute();
    }

    public function readOne()
    {
        $query = "SELECT id, street, building_no, postal_code, city, country FROM " . $this->tableName . " WHERE id=? LIMIT 0,1";

        $result = $this->conn->prepare($query);
        $result->bindParam(1, $this->id);
        $result->execute();

        $row = $result->fetch(PDO::FETCH_ASSOC);

        $this->id = (int)$row['id'];
        $this->street = $row['street'];
        $this->buildingNo = $row['building_no'];
        $this->postCode = $row['postal_code'];
        $this->city = $row['city'];
        $this->country = $row['country'];
    }

    public function update()
    {
        $query = "UPDATE " . $this->tableName . " SET  street=:street, building_no=:building_no, postal_code=:postal_code,
             city=:city, country=:country WHERE id=:id ";

        $result = $this->conn->prepare($query);


        $this->street = htmlentities(strip_tags($this->street ?? ''));
        $this->buildingNo = htmlentities(strip_tags($this->buildingNo ?? ''));
        $this->postCode = htmlentities(strip_tags($this->postCode ?? ''));
        $this->city = htmlentities(strip_tags($this->city ?? ''));
        $this->country = htmlentities(strip_tags($this->country ?? ''));

        $result->bindParam(":id", $this->id);
        $result->bindParam(":street", $this->street);
        $result->bindParam(":building_no", $this->buildingNo);
        $result->bindParam(":postal_code", $this->postCode);
        $result->bindParam(":city", $this->city);
        $result->bindParam(":country", $this->country);

        return ($result->execute());
    }

    public function delete()
    {
        $query =
            "DELETE FROM " . $this->tableName . " WHERE id = ?";

        $result = $this->conn->prepare($query);

        $result->bindParam(1, $this->id);

        return $result->execute();
    }
}