# A short description of the tile

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jonlynch/laravel-dashboard-uk-weather-tile.svg?style=flat-square)](https://packagist.org/packages/jonlynch/laravel-dashboard-uk-weather-tile)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/jonlynch/laravel-dashboard-uk-weather-tile/run-tests?label=tests)](https://github.com/jonlynch/laravel-dashboard-uk-weather-tile/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/jonlynch/laravel-dashboard-uk-weather-tile.svg?style=flat-square)](https://packagist.org/packages/jonlynch/laravel-dashboard-uk-weather-tile)

A weather forecast tile powered by [Met Office data](https://metoffice.apiconnect.ibmcloud.com/metoffice/production/).

This tile can be used on [the Laravel Dashboard](https://docs.spatie.be/laravel-dashboard).

## Installation

You can install the package via composer:

```bash
$ composer require jonlynch/laravel-dashboard-uk-weather-tile
```

## Usage

In your dashboard view you use the `livewire:uk-weather-tile` component. You may add more than one weather forecast by adding more locations.

```html
<x-dashboard>
    <livewire:uk-weather-tile position="a1:a2" location-name="St Bees"/>
    <livewire:uk-weather-tile position="b1:b2" location-name="Scafell Pike"/>
</x-dashboard>
```

Add the config to the tiles sections of your `config/dashboard.php`

```php
// in config/dashboard.php

return [
    // ...
    tiles => [
        'ukweather' => [
            'client_id' => env('MET_OFFICE_CLIENT_ID'),
            'client_secret' => env('MET_OFFICE_CLIENT_SECRET'),
            'locations' => [
                'St Bees' => [
                    'lat' => '54.4891',
                    'lon' => '-3.6080',
                ],
                'Scafell Pike' => [
                    'lat' => '54.4543',
                    'lon' => '-3.2115'
                ]
            ],
            'refresh_interval_in_seconds' => 600,
        ]
    ]
```

In app\Console\Kernel.php you should schedule the JonLynch\UkWeatherTile\Commands\FetchMetOfficeDataCommand to run every 30 minutes.

``` php
// in app\Console\Kernel.php

protected function schedule(Schedule $schedule)
{
    $schedule->command(\JonLynch\UkWeatherTile\Commands\FetchMetOfficeDataCommand::class)->everyThirtyMinutes();

}
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Credits

- [Jon Lynch](https://github.com/jonlynch)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
