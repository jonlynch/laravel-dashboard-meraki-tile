<x-dashboard-tile :position="$position" :refresh-interval="$refreshIntervalInSeconds">
    <div class="h-full ">
        <h1 class="font-medium text-dimmed text-sm text-center uppercase tracking-wide">
            Repeater Network Status
        </h1>
        <ul class="divide-y-2 divide-canvas -mt-1">
            @foreach ($status as $device)
            <?php
            switch (strtolower($device['status'])) {
                case 'online':
                    $colour = 'green';
                    break;
                case 'offline':
                    $colour = 'red';
                    break;
                default:
                    $colour = 'yellow';
            } ?>
                <li class="py-1">
                    <div class="my-2 flex flex-col items-center">
                        <div class="text-xl px-2 py-1 uppercase leading-none rounded border-2 shadow-md flex flex-col text-center text-{{$colour}}-600 bg-{{$colour}}-200 border-{{$colour}}-600">{{$device['display_name']}}
                        @if ($device['status'] !== 'online')
                            <div class="text-sm mt-1">{{$device['status']}} for {{\Carbon\Carbon::createFromTimeStamp(strtotime($device['last_seen']))->longAbsoluteDiffForHumans()}}</div>
                        @endif
                    </div>
                    </div>
                    @foreach ($device['clients'] as $client)
                        <?php
                        switch (strtolower($client['status'])) {
                            case 'online':
                                $colour = 'green';
                                break;
                            case 'offline':
                                $colour = 'red';
                                break;
                            default:
                                $colour = 'yellow';
                        } ?>
                        <div class="my-2 flex flex-col items-center">
                            <div class="px-2 py-1 uppercase leading-none rounded border-2 shadow-md flex flex-col text-center text-{{$colour}}-600 bg-{{$colour}}-200 border-{{$colour}}-600">{{$client['display_name']}}
                            @if ($client['status'] !== 'Online')
                                <div class="text-sm mt-1">{{$client['status']}} for {{\Carbon\Carbon::createFromTimeStamp(strtotime($client['last_seen']))->longAbsoluteDiffForHumans()}}</div>
                            @endif
                        </div>
                    @endforeach
                </li>
            @endforeach
        </ul>
    </div>
</x-dashboard-tile>