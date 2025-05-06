<?php

namespace Doker42\VisitorsWatcher\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class LocationVisitors
{
    public static function getLocation($ip): array
    {
        if (env('APP_ENV') === 'local'){
            return [
                'country' => 'local',
                'city'    => 'host'
            ];
        }

        sleep(1);

        try {
            $client = new Client();
            $response = $client->get("http://ip-api.com/json/{$ip}");
            $data = json_decode($response->getBody(), true);

            if ($data['status'] === 'success') {
                return $data; // Contains city, country, lat, lon, etc.
            } else {
                return [];
            }

        } catch (\Exception $e) {

            Log::info('Get Location Error : ' . $e->getMessage());

            return [];
        }
    }
}