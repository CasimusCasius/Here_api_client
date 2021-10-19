<?php

header("Acces-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../Config/Database.php';
include_once '../Objects/Address.php';
$database = new Database();
$db = $database->createConnection();
$location = new Address($db);

$result = $location->read()->fetchAll(PDO::FETCH_ASSOC);;
$recordCounter = count($result);

if ($recordCounter > 0)
{
    $locationArray = [];
    $locationArray['locations'] = [];

    foreach ($result as $row)
    {
        extract($row);

        $locationItem = [
            'id' => $id,
            'street' => $street,
            'building_no' => $building_no,
            'postal_code' => $postal_code,
            'city' => $city,
            'country' => $country,
            'created' => $created
        ];
        array_push($locationArray['locations'], $locationItem);
    };

    http_response_code(200);
    echo json_encode($locationArray);
}
else
{
    http_response_code(404);
    echo json_encode(
        array("message" => "No location found.")
    );
}