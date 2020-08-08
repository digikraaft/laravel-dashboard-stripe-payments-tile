<?php

namespace Digikraaft\StripePaymentsTile;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class StripePaymentsTileServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                FetchPaymentsDataFromStripeApi::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/stripe-payments-tile'),
        ], 'stripe-payments-tile-views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dashboard-stripe-payments-tile');

        Livewire::component('stripe-payments-tile', StripePaymentsTileComponent::class);
    }
}
