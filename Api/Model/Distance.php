<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\ExternalApi;

require_once PROJECT_ROOT_PATH . "/Model/ExternalApi.php";

class Distance extends ExternalApi
{
    public function distance(array $options)
    {
        $waypoints = $this->getWaypoints($options);
        $distance = $this->getDistance($waypoints);


        return $distance;
    }

    private function getWaypoints(array $options)
    {
        $from = $this->getWaypoint($options['from']);
        $to = $this->getWaypoint($options['to']);

        return [
            'from' => $from,
            'to' => $to
        ];
    }

    private function getDistance(array $waypoints)
    {
        $from = $waypoints['from'];
        $to = $waypoints['to'];
        $origin = (string)$from['lat'] . ',' . (string)$from['lng'];
        $destination = (string)$to['lat'] . ',' . (string)$to['lng'];

        $url = 'https://router.hereapi.com/v8/routes?transportMode=car&origin=' . $origin . '&destination=' . $destination .
            '&return=travelSummary&apiKey=' . API_KEY;

        curl_setopt($this->curl, CURLOPT_URL, $url);
        $result = curl_exec($this->curl);
        $resArray = json_decode($result, true);
        $distance = ($resArray['routes'][0]['sections'][0]['travelSummary']);
        curl_close($this->curl);
        $distanceArray = ['distance' => $distance['length'] / 1000];
        return $distanceArray;
    }

    private function getWaypoint(string $location)
    {
        $address = '';

        if (((int) $location) > 0)
        {
            $url = 'http://hereapi.localhost/Api/index.php/location/read?id=' . $location;
            curl_setopt($this->curl, CURLOPT_URL, $url);
            $result = curl_exec($this->curl);
            $resArray = json_decode($result, true);
            foreach ($resArray[0] as $key => $value)
            {
                if ($key == 'id' || $key == 'created' || $value == '')
                {
                    continue;
                }
                $address = $address . " "  . $value;
            }
            $waypoint = trim($address);
        }
        else
        {
            $waypoint = $location;
        }

        return $this->getCoordinates($waypoint);
    }

    private function getCoordinates(string $waypoint)
    {
        $query = str_replace(' ', '+', $waypoint,);

        $url = 'https://geocode.search.hereapi.com/v1/geocode?lang=pl&q=' . $query . '&apiKey=' . API_KEY;
        curl_setopt($this->curl, CURLOPT_URL, $url);
        $responce = curl_exec($this->curl);

        $geocode = json_decode($responce, true);

        $position = $geocode['items'][0]['position'];
        return $position;
    }
}