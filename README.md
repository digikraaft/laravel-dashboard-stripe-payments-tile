# A tile to show list of Stripe Payments on Laravel Dashboard
![run-tests](https://github.com/digikraaft/laravel-dashboard-stripe-payments-tile/workflows/run-tests/badge.svg)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/digikraaft/laravel-dashboard-stripe-payments-tile/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/digikraaft/laravel-dashboard-stripe-payments-tile/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/digikraaft/laravel-dashboard-stripe-payments-tile/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

This tile displays the list of [Stripe](https://stripe.com) customers. 
It can be used on [the Laravel Dashboard](https://docs.spatie.be/laravel-dashboard).

## Installation

You can install the package via composer:

```bash
composer require digikraaft/laravel-dashboard-stripe-payments-tile
```
You need to publish the migrations and config file of the [Laravel Dashboard](https://github.com/spatie/laravel-dashboard) package.
In the `dashboard` config file, you can optionally add this configuration in the tiles key and customize it for your own needs:
```
// in config/dashboard.php

'tiles' => [

        /**
         * Stripe configuration settings
         */
        'stripe' => [

            'secret_key' => env('STRIPE_SECRET'),
            'payments' => [

                /**
                 * the values here must be supported by the Stripe API
                 * @link https://stripe.com/docs/api/charges?lang=php
                 */
                'params' => [
                    'limit' => 5,
                ],

                /**
                 * How often should the data be refreshed in seconds
                 */
                'refresh_interval_in_seconds' => 1800,
            ],
        ],
    ],
```
You must set your `STRIPE_SECRET` in the `.env` file. You can get this from your Stripe dashboard. 
To load the customer data from Stripe at regular intervals, you need to schedule the `FetchPaymentsDataFromStripeApi`
command:
```
// in app/Console/Kernel.php
use Digikraaft\StripePaymentsTile\FetchPaymentsDataFromStripeApi;

protected function schedule(Schedule $schedule)
{
    $schedule->command(FetchPaymentsDataFromStripeApi::class)->twiceDaily();
}
```
You can change the frequency of the schedule as desired. You can also use the
`php artisan dashboard:fetch-payments-data-from-stripe-api` command.

## Usage
In your dashboard view you use the `livewire:stripe-payments-tile` component.
```html
<x-dashboard>
    <livewire:stripe-payments-tile position="e7:e16" />
</x-dashboard>
```
You can add an optional title:
```html
<x-dashboard>
    <livewire:stripe-payments-tile position="e7:e16" title="Stripe Payments" />
</x-dashboard>
```

## Pagination
The package paginates data by default. The default value is 5. This can be changed by adding a `perPage`
property to the tile:
```html
<x-dashboard>
    <livewire:stripe-payments-tile position="e7:e16" title="Stripe Payments" perPage="10" />
</x-dashboard>
```

## Testing
Use the command below to run your tests:
``` bash
composer test
```

## More Good Stuff
Check [here](https://github.com/digikraaft) for more awesome free stuff!

## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security
If you discover any security related issues, please email dev@digitalkraaft.com instead of using the issue tracker.

## Credits
- [Tim Oladoyinbo](https://github.com/timoladoyinbo)
- [All Contributors](../../contributors)

## Thanks to
- [Spatie](https://github.com/spatie/) for the [Laravel Dashboard](https://github.com/spatie/laravel-dashboard) package

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
