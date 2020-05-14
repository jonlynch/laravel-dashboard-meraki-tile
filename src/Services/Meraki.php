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
    public function getClientData(array $clients_required, string $network_id): array
    {
        $client_endpoint = "https://api.meraki.com/api/v0/networks/{$network_id}/clients";
        $headers = [
            "X-Cisco-Meraki-API-Key" => $this->api_key
        ];
        $clients_returned = Http::withHeaders($headers)
            ->get($client_endpoint)
            ->json();

        $required_macs = collect($clients_required)->pluck('mac')->toArray();

        $clients_filtered = collect($clients_returned)->filter(function ($client) use ($required_macs) {
            return in_array($client['mac'], ($required_macs)) ;
        });
        
        $clients_to_return = [];
        
        foreach ($clients_required as $client) {
            $client_data = $clients_filtered
                ->first(fn ($returned_client)=> $returned_client['mac'] === $client['mac']);
            $client['status'] = $client_data['status'];
            $client['last_seen'] = $client_data['lastSeen'];
            $client['device_name'] = $client_data['recentDeviceName'];
            unset($client['mac']);
            $clients_to_return[] = $client;
        }
        // To Do
        // Extract necessary information
        // Add display name

        return $clients_to_return;

    }


}
