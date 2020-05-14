<x-dashboard-tile :position="$position">
    <div class="h-full justify-items-center text-center">
        <h1 class="font-medium text-dimmed text-sm uppercase tracking-wide pb-2">
            Meraki
        </h1>
        <div wire:poll.{{ $refreshIntervalInSeconds }}s class="self-center grid grid-cols-4 row-gap-1 col-gap-1">
            Hello World
        </div>
    </div>
</x-dashboard-tile>
