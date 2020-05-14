<?php

namespace JonLynch\MerakiTile;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use JonLynch\MerakiTile\Commands\FetchMerakiDataCommand;

class MerakiTileServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FetchMerakiDataCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/dashboard-meraki-tile'),
        ], 'dashboard-meraki-tile-views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dashboard-meraki-tile');

        Livewire::component('meraki-tile', MerakiTileComponent::class);
    }
}
