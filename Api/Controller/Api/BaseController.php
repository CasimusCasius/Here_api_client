<?php

declare(strict_types=1);

namespace App\Controller\Api;

abstract class BaseController
{

    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }


    protected function getUriSegments(): array
    {

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);

        return $uri;
    }


    protected function getQueryStringParams(): array
    {

        parse_str($_SERVER['QUERY_STRING'], $query);
        return $query;
    }


    protected function sendOutput($data, $httpHeaders = array()): void
    {
        header_remove('Set-Cookie');

        if (is_array($httpHeaders) && count($httpHeaders))
        {
            foreach ($httpHeaders as $httpHeader)
            {
                header($httpHeader);
            }
        }

        echo $data;
        exit;
    }
}