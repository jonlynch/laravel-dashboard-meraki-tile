<x-dashboard-tile :position="$position" :refresh-interval="$refreshIntervalInSeconds">
    <div class="h-full justify-items-center">
        <h1 class="font-medium text-dimmed text-sm text-center uppercase tracking-wide">
            Repeater Network Status
        </h1>
        <div class="self-center flex flex-wrap flex-col max-h-full">
            <div class="w-full">
                @foreach ($status as $device)
                    <div class="">
                        <div class="flex flex-col items-center">
                            <div class="m-1 p-1 bg-gray-100 rounded block border-l-8 shadow border-{{$device['colour']}}-500 w-full" >
                                <div class="block ml-1">{{$device['display_name']}}</div>
                                
                                @if ($device['colour'] !== 'green')
                                    <div class="block ml-1 text-dimmed text-xs ">{{$device['device_status']}} for {{\Carbon\Carbon::createFromTimeStamp(strtotime($device['client_last_seen']))->longAbsoluteDiffForHumans()}}</div>
                                @endif 
                                <div class="block ml-1 text-dimmed text-xs ">{{$device['message']}}</div>
                            </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-dashboard-tile>
