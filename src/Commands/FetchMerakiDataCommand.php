<?php

namespace JonLynch\MerakiTile\Commands;

use Illuminate\Console\Command;
use JonLynch\MerakiTile\MerakiStore;
use JonLynch\MerakiTile\Services\Meraki;

class FetchMerakiDataCommand extends Command
{
    protected $signature = 'dashboard:fetch-meraki-data';

    protected $description = 'Fetch status information from Meraki API';

    public function handle()
    {
        $this->info('Fetching Meraki Data ...');
        // fetch the device status 
        $meraki = new Meraki(config('dashboard.tiles.meraki.api_key'),
            config('dashboard.tiles.meraki.organisation_id'));
        $deviceStatus = $meraki->getDeviceData();

        dd($deviceStatus);
        
        $devices = collect($deviceStatus);

        // for each 
        foreach (config('dashboard.tiles.meraki.configurations') as $deviceConfig) {
            // lookup the networkId from the deviceStatuses
            $device = $devices->first( function ($device) use ($deviceConfig) {
                return $device['name'] === $deviceConfig['device_name'];
            });
            $networkId = $device['networkId'];
            // Call to fetch client data
            $clientStatus = Meraki::getClientData(
                config('dashboard.tiles.meraki.api_key'),
                $deviceConfig['clients'], 
                $networkId
            );
            dd($clientStatus);

            // add on display name before storing
            // produce pretty output
        }

        $clientStatus = Meraki::getClientData(
            config('dashboard.tiles.meraki.api_key'),
            ['00:0e:06:00:54:0d', '00:0e:06:00:54:08'], 
            'N_682858293500074852'
        );
        /*
        // fetch the client status
        foreach ($clients as $client) {
            $clientData = Meraki::getClientData($clientMac, $networkId);
        }*/
        $status = [];
        // store in a structure suitable for displaying
        MerakiStore::make()->setStatus($status);
        
        $this->info('All done!');
    }
}
