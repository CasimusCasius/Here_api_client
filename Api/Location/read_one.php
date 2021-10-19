<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../Config/Database.php';
include_once '../Objects/Address.php';
$database = new Database();
$db = $database->createConnection();
$location = new Address($db);

$location->id = (int)isset($_GET['id']) ? $_GET['id'] : die();

$location->readOne();

if ($location->street != null)
{
    $locationArray = [
        'id' => $location->id,
        'street' => $location->street,
        'building_no' => $location->buildingNo,
        'postal_code' => $location->postCode,
        'city' => $location->city,
        'country' => $location->country
    ];

    http_response_code(200);

    echo json_encode($locationArray);
}
else
{
    http_response_code(404);
    echo json_encode(array("message" => "Location does not exist."));
}