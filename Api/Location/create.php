<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../Config/Database.php';
include_once '../Objects/Address.php';


$database = new Database();
$db = $database->createConnection();
$location = new Address($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->street) && !empty($data->city))
{
    $location->street = $data->street;
    $location->buildingNo = $data->building_no;
    $location->postCode = $data->postal_code;
    $location->city = $data->city;
    $location->country = $data->country;
    $location->created = date('Y-m-d H:i:s');

    if ($location->create())
    {
        http_response_code(201);
        echo json_encode(array("message" => "Location was created"));
    }
    else
    {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create location"));
    }
}
else
{
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create location. Data incomplete"));
}