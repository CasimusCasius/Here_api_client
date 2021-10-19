<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Error;
use App\Model\Location;

class LocationController extends BaseController
{

    public function readAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrayQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET')
        {
            try
            {
                $locationModel = new Location();

                if (isset($arrayQueryStringParams['limit']) && (int)$arrayQueryStringParams['limit'])
                {
                    $limit = ['limit' => (int)$arrayQueryStringParams['limit']];
                }
                else
                {
                    $limit = ['limit' => 10];
                }

                $arrayLocation = $locationModel->read($limit);
                $responseData = json_encode($arrayLocation);
                $this->sendOutput($responseData, array('Content-Type: application/json', 'HTTP/1.1 200 OK'));
            }
            catch (Error $e)
            {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        else
        {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        if ($strErrorDesc)
        {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function createAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrayQueryStringParams = json_decode(file_get_contents("php://input"), true);



        if (strtoupper($requestMethod) == 'POST')
        {
            try
            {
                $locationModel = new Location();


                if (isset($arrayQueryStringParams['street']) && $arrayQueryStringParams['city'])
                {
                    $locationModel->create($arrayQueryStringParams);
                    $this->sendOutput('201 Created', array('Content-Type: application/json', 'HTTP/1.1 201 Created'));
                }


                // $responseData = json_encode($arrayLocation);
                $this->sendOutput('Done', array('Content-Type: application/json', 'HTTP/1.1 201 Created'));
            }
            catch (Error $e)
            {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }
        else
        {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        if ($strErrorDesc)
        {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }
}