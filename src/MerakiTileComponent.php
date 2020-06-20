<?php

namespace JonLynch\MerakiTile;

use Livewire\Component;

class MerakiTileComponent extends Component
{
    /** @var string */
    public $position;

    public function mount(string $position)
    {
        $this->position = $position;
    }

    public function render()
    {
        //dd(MerakiStore::make()->status());
        return view('dashboard-meraki-tile::tile', [
            'status' => MerakiStore::make()->status(),
            'refreshIntervalInSeconds' => config('dashboard.tiles.meraki.refresh_interval_in_seconds') ?? 60
        ]);
    }
}
