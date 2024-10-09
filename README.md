# A short description of the tile

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jonlynch/laravel-dashboard-meraki-tile.svg?style=flat-square)](https://packagist.org/packages/jonlynch/laravel-dashboard-meraki-tile)
[![Total Downloads](https://img.shields.io/packagist/dt/jonlynch/laravel-dashboard-meraki-tile.svg?style=flat-square)](https://packagist.org/packages/jonlynch/laravel-dashboard-meraki-tile)

A tile to display the status of devices and clients from the Cisco Meraki cloud.

This tile can be used on [the Laravel Dashboard](https://docs.spatie.be/laravel-dashboard).

## Installation

You can install the package via composer:

```bash
$ composer require jonlynch/laravel-dashboard-meraki-tile
```

## Usage

In your dashboard view you use the `livewire:meraki-tile` component. 

```html
<x-dashboard>
    <livewire:meraki-tile position="a1:a12" />
</x-dashboard>
```

Add the config to the tiles sections of your `config/dashboard.php`

```php
// in config/dashboard.php

return [
    // ...
    tiles => [
         'meraki' => [
            'api_key' => env('MERAKI_API_KEY'),
            'organisation_id' => env('MERAKI_ORG_ID'),
             'configurations' => [ // one for each device you are interested in
                [
                    'display_name' => 'Site 1',
                    'device_name' => 'Site 1', // as used in the Meraki Cloud
                    'client' => '00:0e:06:00:22:22',
                    'radio_link' => true // Add this if there is a radio link instead of Xtend
                ],
                [
                    'display_name' => 'Site 2',
                    'device_name' => 'Site 2', // as used in the Meraki Cloud
                    'client' => '00:0e:06:00:11:11',
                ],
                [
                    'display_name' => 'Site 3',
                    'device_name' => 'Site 3', // as used in the Meraki Cloud
                    'client' => '00:0e:06:00:11:12',
                    'sleeps' => true // add true if this repeater is expected to power down when not in use
                ]
            ]
        ]
    ]
```

In `app\Console\Kernel.php` you should schedule the `JonLynch\MerakiTile\Commands\FetchMerakiDataCommand` to run every minute.

``` php
// in app\Console\Kernel.php

protected function schedule(Schedule $schedule)
{
    $schedule->command(\JonLynch\MerakiTile\Commands\FetchMerakiDataCommand::class)->everyMinute();

}
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
