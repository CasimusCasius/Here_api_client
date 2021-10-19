<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Error;
use App\Model\Location;

class LocationController extends BaseController
{

    public function readAction(): void
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
                    $arrayQueryStringParams['limit'] = (int)$arrayQueryStringParams['limit'];
                }
                else
                {
                    $arrayQueryStringParams['limit'] = 10;
                }

                $arrayLocation = $locationModel->read($arrayQueryStringParams);
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

    public function createAction(): void
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrayQueryStringParams = json_decode(file_get_contents("php://input"), true);

        if (strtoupper($requestMethod) == 'POST')
        {
            try
            {
                $locationModel = new Location();

                if (isset($arrayQueryStringParams['street']) && isset($arrayQueryStringParams['city']))
                {
                    $locationModel->create($arrayQueryStringParams);
                    $this->sendOutput('201 Created', array('Content-Type: application/json', 'HTTP/1.1 201 Created'));
                }
                else
                {
                    $this->sendOutput('Something went wrong, Bad JSON, street name or city', array('Content-Type: application/json', 'HTTP/1.1 304 Not Modified'));
                }
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

    public function deleteAction(): void
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrayQueryStringParams = json_decode(file_get_contents("php://input"), true);

        if (strtoupper($requestMethod) == 'DELETE')
        {
            try
            {
                $locationModel = new Location();

                if (isset($arrayQueryStringParams['id']))
                {
                    $locationModel->delete($arrayQueryStringParams);
                    $this->sendOutput('204 No Content', array('Content-Type: application/json', 'HTTP/1.1 201 Created'));
                }
                else
                {
                    $this->sendOutput('Something went wrong, Bad JSON or id not integer', array('Content-Type: application/json', 'HTTP/1.1 304 Not Modified'));
                }
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

    public function updateAction(): void
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrayQueryStringParams = json_decode(file_get_contents("php://input"), true);

        if (strtoupper($requestMethod) == 'PUT')
        {
            try
            {
                $locationModel = new Location();

                if (isset($arrayQueryStringParams['street']) && isset($arrayQueryStringParams['city']) && (int) isset($arrayQueryStringParams['id']))
                {
                    $locationModel->update($arrayQueryStringParams);
                    $this->sendOutput('204 No Content', array('Content-Type: application/json', 'HTTP/1.1 201 Created'));
                }
                else
                {
                    $this->sendOutput('Something went wrong, Bad JSON, street name or city', array('Content-Type: application/json', 'HTTP/1.1 304 Not Modified'));
                }
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