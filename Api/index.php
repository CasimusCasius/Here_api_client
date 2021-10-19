<?php

namespace App;

// use App\Controller\Api\LocationController;
// use App\Controller\Api\DistanceController;

require __DIR__ . "/include/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$key = (int)array_search('index.php', $uri);


if (($uri[$key + 1] != 'location' && $uri[$key + 1] != 'distance') || !isset($uri[$key + 2]))
{

    header("HTTP/1.1 404 Not Found");

    exit();
}

$controller = ucfirst($uri[$key + 1]) . "Controller";
require_once PROJECT_ROOT_PATH . "/Controller/Api/" . $controller . ".php";

$fullNameController = "\\App\\Controller\\Api\\" . $controller;
$objFeedController = new $fullNameController();

$strMethodName = $uri[4] . 'Action';

$objFeedController->{$strMethodName}();