<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Error;
use App\Model\Distance;



class DistanceController extends BaseController
{
    public function distanceAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $arrayQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET')
        {
            try
            {
                $distanceModel = new Distance();

                $arrayLocation = $distanceModel->distance($arrayQueryStringParams);

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
}
