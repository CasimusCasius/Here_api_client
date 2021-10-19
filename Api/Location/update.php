<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../Config/Database.php';
include_once '../Objects/Address.php';
$database = new Database();
$db = $database->createConnection();
$location = new Address($db);

$data = json_decode(file_get_contents("php://input"));

$location->id = (int) $data->id;

$location->street = $data->street;
$location->buildingNo = $data->building_no;
$location->postCode = $data->postal_code;
$location->city = $data->city;
$location->country = $data->country;

if ($location->update())
{

    http_response_code(200);

    echo json_encode(array("message" => "Location was updated."));
}
else
{
    http_response_code(503);

    echo json_encode(array("message" => "Unable to update location."));
}