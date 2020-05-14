<?php

namespace JonLynch\MerakiTile\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class Meraki
{
    private string $api_key;
    private string $org_id;

    public function __construct(string $api_key, string $org_id) {
        $this->api_key = $api_key;
        $this->org_id = $org_id;
    }

    public function getDeviceData(): array
    {
        $deviceEndpoint = "https://api.meraki.com/api/v0/organizations/" . $this->org_id . "/deviceStatuses";
        $headers = [
            "X-Cisco-Meraki-API-Key" => $this->api_key
        ];

        $response = Http::withHeaders($headers)
            ->get($deviceEndpoint)
            ->json();

        return $response;
        /*
        return collect($response['features'][0]['properties']['timeSeries'])
            ->map(function (array $forecast) {
                return [
                    'time' => $forecast['time'],
                    'temp' => $forecast['screenTemperature'],
                    'windSpeed' => $forecast['windSpeed10m'],
                    'windGust' => $forecast['max10mWindGust'] ?? '',
                    'windDir' => $forecast['windDirectionFrom10m'],
                    'feelsLike' => $forecast['feelsLikeTemperature'],
                    'probOfPrecip' => $forecast['probOfPrecipitation'],
                    'precipRate' => $forecast['precipitationRate'],
                ];
            })
            ->filter(function ($forecast){
                return Carbon::now() < Carbon::createFromTimeStamp(strtotime($forecast['time']))
                                    ->setTimezone('Europe/London');
            })
            ->take(24)
            ->toArray();
            */
    }
    public function getClientData(array $clients, string $network_id): array
    {
        $clientEndpoint = "https://api.meraki.com/api/v0/networks/{$network_id}/clients";
        $headers = [
            "X-Cisco-Meraki-API-Key" => $this->api_key
        ];
        $response = Http::withHeaders($headers)
            ->get($clientEndpoint)
            ->json();

        // To Do
        // Filter by mac address
        // Extract necessary information
        // Add display name

        return $response;

    }


}
