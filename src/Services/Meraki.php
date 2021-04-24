<?php

namespace JonLynch\MerakiTile\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class Meraki
{
    private string $api_key;
    private string $org_id;

    public function __construct(string $api_key, string $org_id)
    {
        $this->api_key = $api_key;
        $this->org_id = $org_id;
    }

    public function getDeviceData(array $devices_required): array
    {
        $deviceEndpoint =
            "https://api.meraki.com/api/v0/organizations/" .
            $this->org_id .
            "/deviceStatuses";
        $headers = [
            "X-Cisco-Meraki-API-Key" => $this->api_key,
        ];

        $required_names = collect($devices_required)
            ->pluck('device_name')
            ->toArray();

        $all_devices = Http::withHeaders($headers)
            ->get($deviceEndpoint)
            ->json();

        $devices_filtered = collect($all_devices)->filter(
            fn($device) => in_array($device['name'] ?? 'zz', $required_names)
        );

        $devices_to_return = [];
        foreach ($devices_required as $device) {
            $device_data = $devices_filtered->first(
                fn($returned_device) => $returned_device['name'] ===
                    $device['device_name']
            );
            $device['device_status'] = $device_data['status'];
            $device['device_last_seen'] = $device_data['lastReportedAt'];
            $device['networkId'] = $device_data['networkId'];
            $devices_to_return[] = $device;
        }

        return $devices_to_return;
    }

    public function getClientData(string $client_mac, string $network_id): array
    {
        $client_endpoint = "https://api.meraki.com/api/v0/networks/{$network_id}/clients";
        $headers = [
            "X-Cisco-Meraki-API-Key" => $this->api_key,
        ];
        $clients_returned = Http::withHeaders($headers)
            ->get($client_endpoint)
            ->json();

        $client_data = collect($clients_returned)->first(
            fn($client) => $client['mac'] === $client_mac
        );
        if (empty($client_data)) {
            return [
                'client_status' => "Not Found",
                'client_last_seen' => "never",
            ];
        }
        return [
            'client_status' => $client_data['status'],
            'client_last_seen' => $client_data['lastSeen'],
        ];
    }
}
