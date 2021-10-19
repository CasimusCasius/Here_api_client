<?php

declare(strict_types=1);

namespace App\Model;

use CurlHandle;
use Exception;

abstract class ExternalApi
{
    protected $curl = null;

    public function __construct()
    {
        try
        {
            $this->curl = curl_init();
            $curlOptions = [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER         => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_ENCODING       => "",
                CURLOPT_USERAGENT      => "test",
                CURLOPT_AUTOREFERER    => true,
                CURLOPT_CONNECTTIMEOUT => 120,
                CURLOPT_TIMEOUT        => 120

            ];
            curl_setopt_array($this->curl, $curlOptions);
        }
        catch (\Throwable $th)
        {
            throw new Exception($th->getMessage());
        }
    }
}