<?php

namespace JonLynch\MerakiTile\Commands;

use Illuminate\Console\Command;
use JonLynch\MerakiTile\MerakiStore;
use JonLynch\MerakiTile\Services\Meraki;
use JonLynch\MerakiTile\Services\Consequences;

class FetchMerakiDataCommand extends Command
{
    protected $signature = 'dashboard:fetch-meraki-data';

    protected $description = 'Fetch status information from Meraki API';

    public function handle()
    {
        $this->info('Fetching Meraki Data ...');
        
        $meraki = new Meraki(
            config('dashboard.tiles.meraki.api_key'),
            config('dashboard.tiles.meraki.organisation_id')
        );

        // fetch the device status 
        $devices = $meraki->getDeviceData(config('dashboard.tiles.meraki.configurations'));
        
        $populated_devices = [];
        
        // get the client status for each device
        foreach ($devices as $device) {
            $clientStatus = $meraki->getClientData(
                $device['client'], 
                $device['networkId']
            );
            $device = array_merge ($device, $clientStatus);
            $consequences = New Consequences($device);
            $device = $consequences->get_consequence_for_device();
            $populated_devices[] = $device;
        }
        MerakiStore::make()->setStatus($populated_devices);
        
        $this->info('All done!');
    }
}
